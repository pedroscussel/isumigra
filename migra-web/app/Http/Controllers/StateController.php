<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\State;
use App\Country;

class StateController extends Controller
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
        $states = State::search()->sortable()->paginate(config('config.paginate'));
        return view('states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $country = Country::all();
        $state = new State();
        return view('states.create', compact('state', 'country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'abbreviation' => "required|min:2|max:2",
            'country_id' => "required|exists:countries,id",
        ]);

        $country = Country::find($request->country_id);
        $state = new State();
        $state->name = $request->name;
        $state->abbreviation = $request->abbreviation;
        $state->country()->associate($country);
        $state->save();
        return redirect('states');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $state = State::find($id);
        return view('states.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|min:3|max:255',
            'abbreviation' => 'required|min:2|max:2',
            'country_id' => 'required|exists:countries,id',
        ]);
        $state = State::find($id);
        $state->name = $request->name;
        $state->abbreviation = $request->abbreviation;
        $state->save();
        return redirect('states');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy($id)
    {
        try {
            $state = State::findOrFail($id);
            $state->delete();
        } catch (QueryException  $e) {
            return redirect('cities')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('cities')->with("error", trans('message.no_record_found'));
        }
        return redirect('states');
    }
}
