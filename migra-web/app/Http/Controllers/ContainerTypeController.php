<?php

namespace App\Http\Controllers;

use Gate;
use App\ContainerType;
use App\Container;
use App\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ContainerTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth', 'can:users']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Gate::allows('migra')) {
            $container_types = ContainerType::sortable('name')->paginate(config('config.paginate'));
        } else {
            $container_types = ContainerType::
                    where('company_id', Auth()->user()->company_id)
                    ->sortable('name')
                    ->paginate(config('config.paginate'));
        }
        return view('container_types.index', compact('container_types'));
    }

    public function create()
    {
        $this->authorize('create', new ContainerType());

        return view('container_types.create');
    }

    public function store(Request $request)
    {
        $container_type = new ContainerType;
        $this->authorize('create', $container_type);

        $container_type->name = $request->name;
        $container_type->description = $request->description;
        $container_type->width  = $request->width?:0;
        $container_type->length = $request->length?:0;
        $container_type->height = $request->height?:0;
        $container_type->bulk = $request->bulk?:0;
        $container_type->weight = $request->weight?:0;
        $container_type->carrying_capacity = $request->carrying_capacity?:0;
        $container_type->traceable  = $request->traceable?:false;
        $container_type->company_id = $request->company_id;
        $container_type->save();

        return redirect(route('container_types.edit', $container_type->id));
    }

    public function show($id)
    {
        $container_type = ContainerType::findOrFail($id);
        $this->authorize('view', $container_type);

        return view('container_types.show', compact('container_type'));
    }

    public function edit($id)
    {
        $container_type = ContainerType::find($id);
        $this->authorize('update', $container_type);

        return view('container_types.edit', compact('container_type'));
    }


    public function update(Request $request, $id)
    {
        $container_type = ContainerType::find($id);
        $this->authorize('update', $container_type);

        $container_type->name=$request->name;
        $container_type->description=$request->description;
        $container_type->width  = $request->width?:0;
        $container_type->length = $request->length?:0;
        $container_type->height = $request->height?:0;
        $container_type->bulk = $request->bulk?:0;
        $container_type->weight = $request->weight?:0;
        $container_type->carrying_capacity = $request->carrying_capacity?:0;
        $container_type->traceable  = $request->traceable?:false;
        $container_type->company_id = $request->company_id;
        $container_type->save();

        return redirect('/container_types');
    }

    public function remove($id)
    {
        $container_type = ContainerType::find($id);
        $this->authorize('delete', $container_type);
        return Gate::allows('admin_migra') ? view('container_types.remove', compact('container_type')) : redirect(route('container_types.index'));
    }

    public function destroy($id)
    {
        $container_type = ContainerType::find($id);
        $this->authorize('delete', $container_type);
        foreach ($container_type->documents as $d) {
            removeDocument($d);
        }
        $container_type->delete();
        return redirect()->action('ContainerTypeController@index');
    }

    public function download(Request $request, $id)
    {
        $doc = Document::findOrFail($id);
        $filename = $doc->documentable_type ."/". $doc->documentable_id ."/". $doc->id;
        //Se o arquivo for "Teste - Cópia", por exemplo, da o seguinte erro:
        //The filename fallback must only contain ASCII characters
        //Então removemos todos caracteres de acentos ou diferentes do básico
        $filenameAscii = Document::stripAccents($doc->filename);
        $filenameAscii = filter_var($filenameAscii, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        return Storage::download($filename, $filenameAscii);
    }

    public function removeDocument($id)
    {
        $document = Document::find($id);
        $document->delete();
        Storage::delete($document->path . "/" . $document->id, $document->name);
        return redirect()->back();
    }
}
