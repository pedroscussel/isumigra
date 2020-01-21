<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Support\Facades\Auth;

use Gate;
use App\ServiceOrder;
use App\ContainerType;
use App\CompanyType;
use App\Container;
use App\Company;
use App\Address;
use App\Truck;
use App\Material;
use App\Tools\ContainerMap;

class ServiceOrderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }

    public function index()
    {
        if (Gate::allows('migra')) {
            $service_orders = ServiceOrder::search()->sortable('num_service')->paginate(config('config.paginate'));
        } else {
            $service_orders = ServiceOrder::search()->sortable('num_service')->where('owner_id', Auth::user()->company_id)->paginate(config('config.paginate'));
        }
        return view('service_orders.index', compact('service_orders'));
    }

    public function create()
    {
        $service_order = new ServiceOrder();
        $this->authorize('create', $service_order);

        if (array_key_exists('REQUEST_URI', $_SERVER))
            $container = Container::find(substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '?') + 1));
        else
            $container = null;

        if (Gate::allows('migra')) {
            $containers = Container::whereNull('service_order_id')->get();
            $container_types = ContainerType::all();
            $companies = Company::all();
            $trucks = Truck::all();
        } else {
            $containers = Container::onlyCompany(Auth::user()->company_id)->whereNull('service_order_id')->get();
            $container_types =  ContainerType::onlyCompany(Auth::user()->company_id)->get();
            $companies = Company::onlyCompany(Auth::user()->company_id)->get();
            $trucks = Truck::where('company_id', Auth::user()->company_id)->get();
        }
        $materials = Material::all();
        $number = Company::find(Auth::user()->company_id)->num_services+1;
        return view('service_orders.create', compact('number', 'materials', 'containers', 'container', 'container_types', 'trucks', 'companies'));
    }

    public function store(Request $request)
    {
        $service_order = new ServiceOrder();
        $this->authorize('create', $service_order);

        $container = Container::find($request->container_id);
        $service_order->num_service = $request->number;
        $service_order->company_id = $request->company_id;
        $service_order->address_src_id = $request->origin_address;
        $service_order->address_des_id = $request->destination_address;
        $service_order->container_type_id = $request->container_type_id;
        $service_order->container_id = $request->container_id;
        $service_order->material_id = $request->material_id;
        $service_order->truck_id = $request->truck_id;
        $service_order->user_id = Auth::user()->id;
        $service_order->owner_id = Auth::user()->company_id;
        $service_order->quantity = 0;
        $service_order->save();
        if ($container) {
            $container->service_order_id = $service_order->id;
            $container->company_service_id = Address::find($request->destination_address)->companies()->first()->id;
            $service_order->quantity = Material::find($request->material_id)->density * $container->device->volume;
            $container->save();
            $service_order->save();
        }
        $company = Company::find(Auth::user()->company_id);
        $company->num_services = $service_order->num_service;
        $company->save();

        return redirect()->action('ServiceOrderController@index');
    }

    public function show($id)
    {
        $service_order = ServiceOrder::find($id);
        $this->authorize('view', $service_order);
        $m = new GMaps();
        $config['map_height'] = config('googlemaps.map_height');
        $config['zoom'] = config('googlemaps.zoom');
        $config['center'] = config('googlemaps.center');
        $m->initialize($config);
        // geocode service needed
        // $m->add_marker($service_order->addressSrc->getFullAddressAttribute());
        // $m->add_marker($service_order->addressDes->getFullAddressAttribute());
        $map = $m->create_map();
        return view('service_orders.show', compact('service_order', 'map'));
    }

    public function edit($id)
    {
        $service_order = ServiceOrder::find($id);
        $this->authorize('update', $service_order);

        if (! $service_order) {
            $service_order = null;
            return view('service_orders.edit', compact('service_order'));
        }

        if (Gate::allows('migra')) {
            $containers = Container::onlyCompany($service_order->owner_id)->whereNull('service_order_id')->get();
            $container_types = ContainerType::onlyCompany($service_order->owner_id)->get();
            $companies = Company::onlyCompany($service_order->owner_id)->get();
            $trucks = Truck::all();
        } else {
            $company_src = $service_order->addressSrc->companies->first();
            $containers = Container::onlyCompany(Auth::user()->company_id)
                ->where('company_service_id', $company_src->id)
                ->whereNull('service_order_id')
                ->orWhere('id', $service_order->container_id)->get();
            $container_types = ContainerType::onlyCompany(Auth::user()->company_id)->get();
            $companies = Company::onlyCompany(Auth::user()->company_id)->get();
            $trucks = Truck::where('company_id', Auth::user()->company_id)->get();
        }
        if ($service_order->container) {
            $quantity = $service_order->container->device->volume * $service_order->material->density;
        } else {
            $quantity = 0;
        }
        $materials = Material::all();
        $address_src = [$service_order->addressSrc->id => $service_order->addressSrc->getFullAddressAttribute()];
        $address_des = [$service_order->addressDes->id => $service_order->addressDes->getFullAddressAttribute()];
        $number = $service_order->num_service;
        return view('service_orders.edit', compact('service_order', 'number', 'containers', 'container_types', 'materials', 'trucks', 'companies', 'address_src', 'address_des', 'quantity'));
    }


    public function update(Request $request, $id)
    {
        $service_order = ServiceOrder::find($id);
        $this->authorize('update', $service_order);
        $service_order->material_real = Material::find($request->material_id)->name;
        $service_order->quantity_real = $request->quantity . " " . $request->unity;
        $service_order->container_type_id = $request->container_type_id;
        $service_order->container_id = $request->container_id;
        $service_order->address_src_id = $request->origin_address;
        $service_order->address_des_id = $request->destination_address;
        $service_order->save();
        if ($request->finished) {
            $container = Container::find($request->container_id);
            $container->service_order_id = null;
            $container->save();
        }
        return redirect()->action('ServiceOrderController@show', $id);
    }

    public function destroy(Request $request, $id)
    {
        try {
            $service_order = ServiceOrder::findOrFail($id);
            $this->authorize('delete', $service_order);
            $service_order->delete();
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }
        return redirect()->route('service_orders.index');
    }
}
