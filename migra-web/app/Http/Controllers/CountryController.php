<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Country;

class CountryController extends Controller
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
        $countries = Country::search()->sortable('name')->paginate(config('config.paginate'));
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $country = new Country();
        return view('countries.create', compact('country'));
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
            'name' => 'required|unique:countries|max:255',
            'abbreviation' => "required|unique:countries|min:3|max:3",
        ]);
        
        $country = new Country();
        $country->name = $request->name;
        $country->abbreviation = $request->abbreviation;
        $country->common = $request->name;
        $country->save();
        return redirect('countries');
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
        $country = Country::find($id);
        return view('countries.edit', compact('country'));
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
            'name'         => 'required|unique:countries,name,'. $id.'|max:255',
            'abbreviation' => 'required|unique:countries,abbreviation,'. $id.'|min:3|max:3',
        ]);
        $country = Country::find($id);
        $country->name = $request->name;
        $country->abbreviation = $request->abbreviation;
        $country->common = $request->name;
        $country->save();
        return redirect('countries');
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
            $country = Country::findOrFail($id);
            $country->delete();
        } catch (QueryException  $e) {
            return redirect('countries')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('countries')->with("error", trans('message.no_record_found'));
        }
        return redirect('countries');
    }
}
