<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Device;
use App\Container;
use App\Material;

class DeviceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:migra']);
    }

    public function index()
    {
        $devices = Device::search()
            ->sortable('name')
            ->paginate(config('config.paginate'));
        $this->authorize('view', new Device()); //200 só pra migra (phpunit)
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        $device = new Device();
        $this->authorize('create', $device);
        $containers = Container::doesntHave('device')->get();
        return view('devices.create', compact('containers'));
    }

    public function store(Request $request)
    {
        $device = new Device();
        $this->authorize('create', $device);
        $device->model_device_id = $request->model_device_id;
        $device
            ->container()
            ->associate(Container::find($request->container_id));
        $device->save();

        return redirect()->route('devices.show', [$device]);
    }

    public function show($id)
    {
        $device = Device::find($id);
        $this->authorize('view', $device);

        $materials_base = Material::all()->toArray();
        $materials = [];
        foreach ($materials_base as $item) {
            $materials[strval($item['density'])] = $item['name'];
        }

        $material_selected = '';
        if ($device->container->activeServiceOrder->material != null) {
            $material_selected =
                $device->container->activeServiceOrder->material->name;
        }

        return view(
            'devices.show',
            compact('device', 'materials', 'material_selected')
        );
    }

    public function edit($id)
    {
        $device = Device::find($id);
        $this->authorize('update', $device);
        $containers = Container::doesntHave('device')
            ->orWhere('id', $device->container_id)
            ->get();
        return view('devices.edit', compact('device', 'containers'));
    }

    public function update(Request $request, $id)
    {
        $device = Device::find($id);
        $this->authorize('update', $device);
        $request->validate([
            'model_device_id' => 'required'
        ]);

        $container = Container::find($device->container_id);
        if ($container && $request->container_id != $container->id) {
            $container->device_id = null;
            $contaner->save();
        }

        $device->model_device_id = $request->model_device_id;
        $device->container_id = $request->container_id;
        $device->save();

        $container = Container::find($request->container_id);
        if ($container) {
            $container->device_id = $device->id;
            $container->save();
        }

        return redirect()->action('DeviceController@show', $id);
    }

    public function remove($id)
    {
        $device = Device::find($id);
        $this->authorize('delete', $device);
        return view('devices.remove', compact('device'));
    }

    public function destroy(Request $request, $id)
    {
        try {
            $device = Device::findOrFail($id);
            $this->authorize('delete', $device);
            $device->delete();
        } catch (QueryException $e) {
            return redirect('users')->with(
                'error',
                trans('message.no_records_found')
            );
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with(
                'error',
                trans('message.no_record_found')
            );
        }
        return redirect()->action('DeviceController@index');
    }
}
