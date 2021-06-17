<?php

namespace App\Http\Controllers;

use App\Http\Resources\TipoContato as ResourcesTipoContato;
use App\Models\TipoContato;
use Illuminate\Http\Request;

class TipoContatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResourcesTipoContato::collection(TipoContato::orderBy('titulo', 'ASC')->get());
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
        $novoTipoContato = new TipoContato();
        $novoTipoContato->titulo = $request->tipoContato['titulo'];
        $novoTipoContato->save();
        return $novoTipoContato;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoContato  $tipoContato
     * @return \Illuminate\Http\Response
     */
    public function show(TipoContato $tipoContato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TipoContato  $tipoContato
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoContato $tipoContato)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipoContato = TipoContato::find($id);
        // Se existir, atualiza
        if ($tipoContato) {
            $tipoContato->titulo = $request->tipoContato['titulo'];
            $tipoContato->save();
            return $tipoContato;
        }
        return 'Tipo de Contato não encontrado.';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoContato = TipoContato::find($id);
        if ($tipoContato) {
            $tipoContato->delete();
            return 'Tipo de Contato deletado com sucesso.';
        }
        return 'Tipo de Contato não encontrado.';
    }
}
