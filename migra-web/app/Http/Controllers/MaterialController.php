<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gate;
use App\Material;

class MaterialController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }
    
    public function index()
    {
        if (Gate::allows('migra')) {
            $materials = Material::search()->sortable('name')->paginate(config('config.paginate'));
        } else {
            $materials = Material::search()->sortable('name')->where('company_id', Auth::user()->company_id)->orWhere('company_id', null)->paginate(config('config.paginate'));
        }
        return view('materials.index', compact('materials'));
    }
   
    public function create()
    {
        $material = new Material();
        $this->authorize('create', $material);
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $material = new Material();
        $this->authorize('create', $material);
        $request->validate([
            'name' => 'required',
            'density' => 'required',
        ]);
        $material->name = $request->name;
        $material->description = $request->description;
        $material->density = $request->density;
        if (Gate::denies('migra')) {
            $material->company()->associate(Auth::user()->company_id);
        }
        $material->save();
        
        return redirect()->route('materials.index');
    }

    public function show($id)
    {
        $material = Material::find($id);
        return view('materials.show', compact('material'));
    }

    public function edit($id)
    {
        $material = Material::find($id);
        $this->authorize('update', $material);
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::find($id);
        $this->authorize('update', $material);
        $material->name = $request->name;
        $material->description = $request->description;
        $material->density = $request->density;
        $material->save();
        return redirect()->action('MaterialController@show', $id);
    }
    
    public function destroy(Request $request, $id)
    {
        try {
            $material = Material::findOrFail($id);
            $this->authorize('delete', $material);
            $material->delete();
        } catch (QueryException  $e) {
            return redirect('users')->with("error", trans('message.no_records_found'));
        } catch (ModelNotFoundException $e) {
            return redirect('users')->with("error", trans('message.no_record_found'));
        }
        return redirect()->route('materials.index');
    }
}
