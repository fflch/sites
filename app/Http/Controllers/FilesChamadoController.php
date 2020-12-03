<?php

namespace App\Http\Controllers;

use App\Models\FilesChamado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesChamadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_chamado' => 'required|file|image|mimes:jpeg,png|max:2048',
            'chamado_id'   => 'required|integer|exists:chamados,id',
        ]);

        $file_chamado = new FilesChamado;
        $file_chamado->chamado_id    = $request->chamado_id;
        $file_chamado->original_name = $request->file('file_chamado')->getClientOriginalName();
        $file_chamado->path          = $request->file('file_chamado')->store('./chamados');
        $file_chamado->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FilesChamado  $filesChamado
     * @return \Illuminate\Http\Response
     */
    public function show(FilesChamado $filesChamado)
    {
        return Storage::download($filesChamado->path, $filesChamado->original_name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilesChamado  $filesChamado
     * @return \Illuminate\Http\Response
     */
    public function edit(FilesChamado $filesChamado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FilesChamado  $filesChamado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FilesChamado $filesChamado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilesChamado  $filesChamado
     * @return \Illuminate\Http\Response
     */
    public function destroy(FilesChamado $filesChamado)
    {
        //
    }
}
