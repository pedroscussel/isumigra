<?php

namespace App\Http\Controllers;

use Gate;
use App\Container;
use App\ServiceOrder;
use App\Company;
use App\Device;
use App\ContainerType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }

    public function index()
    {
        if (Gate::allows('migra')) {
            $containers = Container::search()->sortable('serial')->paginate(config('config.paginate'));
        } else {
            $containers = Container::search()->sortable('name')->onlyCompany(Auth::user()->company_id)->paginate(config('config.paginate'));
        }
        return view('containers.index', compact('containers'));
    }

    public function create()
    {
        $container = new Container();
        $this->authorize('create', $container);
        $device = collect();
        if (Gate::allows('operator_migra')) {
            $container_type = ContainerType::all();
            $company = Company::all();
            $device = Device::doesntHave('container')->get();
        } else {
            $container_type = ContainerType::onlyCompany(Auth::user()->company_id)->get();
            $company = Company::onlyCompany(Auth::user()->company_id)->get();
        }
        return view('containers.create', compact('container_type', 'company', 'device'));
    }

    public function store(Request $request)
    {
        $container = new Container();
        $this->authorize('create', $container);

        $request->validate(
            [ 'serial' => 'unique:containers' ]
        );

        if (Gate::allows('operator_migra')) {
            $container->serial = $request->serial;
            $container->name = $request->serial;
            $container->original_container_type_id = $request->container_type_id;
            $container->container_type_id = $request->container_type_id;
            $container->company_id = $request->company_id;
            $container->company_service_id = $request->company_id;
            $container->save();

            $device = Device::find($request->device_id);
            $container->device()->associate($device);
            $device->container_id = $container->id;
            $device->save();
        } else {
            $container->name = $request->name;
            $container->container_type_id = $request->container_type_id;
            $container->company_id = Auth::user()->company_id;
            $container->company_service_id = Auth::user()->company_id;
            $container->save();
        }

        return redirect()->action('ContainerController@index');
    }

    public function show($id)
    {
        $container = Container::find($id);
        $this->authorize('view', $container);
        return view('containers.show', compact('container'));
    }

    public function edit($id)
    {
        $container = Container::find($id);
        $this->authorize('update', $container);
        $device = collect();
        if (Gate::allows('operator_migra')) {
            $container_type = ContainerType::all();
            $company = Company::all();
            $device = Device::doesntHave('container')->get();
        } else {
            $container_type = ContainerType::onlyCompany(Auth::user()->company_id)->get();
            $company = Company::onlyCompany(Auth::user()->company_id)->get();
        }
        return view('containers.edit', compact('container', 'container_type', 'company', 'device'));
    }


    public function update(Request $request, $id)
    {
        $container = Container::find($id);
        $this->authorize('update', $container);
        $request->validate(
            [ 'name' => 'unique:containers,name,'.$id.',id']
        );
        if (Gate::allows('operator_migra')) {
            $container->serial = $request->serial;
            $container->original_container_type_id = $request->container_type_id;
            $container->company_id = $request->company_id;
            $container->device()->associate(Device::find($request->device_id));
        } else {
            $container->name = $request->name;
            $container->container_type_id = $request->container_type_id;
            $container->company_id = Auth::user()->company_id;
        }
        $container->save();
        return redirect()->action('ContainerController@show', $id);
    }

    public function remove($id)
    {
        $container = Container::find($id);
        $this->authorize('delete', $container);
        return view('containers.remove', compact('container'));
    }

    public function destroy(Request $request, $id)
    {
        try {
            $container = Container::findOrFail($id);
            $this->authorize('delete', $container);
            $container->device()->dissociate();
            $container->delete();
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }
        return redirect()->action('ContainerController@index');
    }

    public function download(Request $request, $id)
    {
        $container = Container::find($id);
        return Storage::download($container->type->file);
    }
}
