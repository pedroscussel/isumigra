<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Document;
use App\Company;
use App\ContainerType;

class DocumentController extends Controller
{

    protected function path($doc)
    {
        Storage::makeDirectory($doc->documentable_type ."/". $doc->documentable_id);
        return $doc->documentable_type ."/". $doc->documentable_id;
    }

    protected function basename($doc)
    {
        return $doc->id;
    }

    protected function filename($doc)
    {
        return $this->path($doc) .'/' . $this->basename($doc);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('documents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //Se false significa que o tamanho do arquivo é maior que o máximo possível
        if ($request->document->getClientSize() == false)
            return redirect()->back();

        $doc = new Document();
        $doc->name = $request->name;
        $doc->description = $request->description;
        $doc->save();

        if ($request->company_id) {
            $company = Company::findOrFail($request->company_id);
            $company->documents()->save($doc);
        }

        if ($request->container_type_id) {
            $container_type = ContainerType::findOrFail($request->container_type_id);
            $container_type->documents()->save($doc);
        }

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $request->document->storeAs($this->path($doc), $this->basename($doc));
            $doc->filename  = $request->document->getClientOriginalName();
            $doc->mimetype  = $request->document->getMimeType();
            $doc->extension = $request->document->getClientOriginalExtension();
            $doc->filesize  = $request->document->getClientSize();
            $doc->save();
        }

        return redirect()->back();
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
            $doc = Document::findOrFail($id);
            Storage::delete($this->filename($doc));
            $doc->delete();
        } catch (QueryException  $e) {
            return redirect()->back()->with("error", trans('message.no_delete_record'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with("error", trans('message.no_record_found'));
        }
        return redirect()->back();
    }

    public function download($id)
    {
        $doc = Document::findOrFail($id);
        //Se o arquivo for "Teste - Cópia", por exemplo, da o seguinte erro:
        //The filename fallback must only contain ASCII characters
        //Então removemos todos caracteres de acentos ou diferentes do básico
        $filenameAscii = Document::stripAccents($doc->filename);
        $filenameAscii = filter_var($filenameAscii, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        return Storage::download($this->filename($doc), $filenameAscii);
    }
}
