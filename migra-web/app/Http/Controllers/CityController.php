<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\City;
use App\State;

class CityController extends Controller
{

    
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:root']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cities = City::search()->sortable(['state_id', 'name'])->paginate(config('config.paginate'));
        return view('cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $states = State::with('countries');
        $city = new City();
        return view('cities.create', compact('city', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cities|max:255',
            'country_id' => "required",
            'state_id' => "required"
        ]);
      
        $state = State::find($request->state);
        $city = new City();
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->save();
        return redirect('cities');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $city = City::find($id);
        return view('cities.edit', compact('city', 'country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $city = City::find($id);
        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->save();
        return redirect('cities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $city = City::findOrFail($id);
            $city->delete();
        } catch (QueryException  $e) {
            return redirect('cities')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('cities')->with("error", trans('message.no_record_found'));
        }
        return redirect('cities');
    }
}
