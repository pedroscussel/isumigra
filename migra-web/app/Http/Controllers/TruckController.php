<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Truck;

class TruckController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }

    public function index()
    {
        if (Gate::allows('migra')) {
            $trucks = Truck::search()->sortable('license_plate')->paginate(config('config.paginate'));
        } else {
            $trucks = Truck::search()->sortable('license_plate')->where('company_id', Auth::user()->company_id)->paginate(config('config.paginate'));
        }
        return view('trucks.index', compact('trucks'));
    }
   
    public function create()
    {
        $this->authorize('create', new Truck);
        return view('trucks.create');
    }

    public function store(Request $request)
    {
        $truck = new Truck;
        $this->authorize('create', $truck);
        $request->validate([
                'license_plate' => 'required|unique:trucks|min:7',
                'company_id' => 'required|exists:companies,id'
             ]);
        
        $truck->name = $request->name?:$request->license_plate;
        $truck->license_plate = $request->license_plate;
        $truck->created_at = now();
        $truck->company_id = $request->company_id;
        $truck->save();
        return redirect()->action('TruckController@index');
    }

    public function show($id)
    {
        $truck = Truck::find($id);
        $this->authorize('view', $truck);
        
        return view('trucks.show', compact('truck'));
    }

    public function edit($id)
    {
        $truck = Truck::find($id);
        $this->authorize('update', $truck);
        
        return view('trucks.edit', compact('truck'));
    }

    public function update(Request $request, $id)
    {
        $truck = Truck::find($id);
        $this->authorize('update', $truck);

        $request->validate([
                'license_plate' => 'required|unique:trucks,id,'.$id.'|min:7',
                'company_id' => 'required|exists:companies,id'
             ]);
        
        $truck->name = $truck->name = $request->name?:$request->license_plate;
        $truck->license_plate = $request->license_plate;
        $truck->company_id    = $request->company_id;
        $truck->is_defect = $request->is_defect?:0;
        $truck->is_outofservice = $request->is_outofservice?:0;
        $truck->save();
        
        return redirect()->action('TruckController@show', $id);
    }
    
    public function remove($id)
    {
        $truck = Truck::find($id);
        $this->authorize('delete', $truck);
        return view('trucks.remove', compact('truck'));
    }
    
    public function destroy(Request $request, $id)
    {
        $truck = Truck::find($id);
        $this->authorize('delete', $truck);
        
        $truck->delete();
        return redirect('trucks');
    }
}
