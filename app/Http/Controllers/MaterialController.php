<?php

namespace App\Http\Controllers;

use App\Libraries\ArquivoClass;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{

    /**
     * Baixa um material específico
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request)
    {
        $material = new ArquivoClass();
        return  response()->download($request->caminho, $request->nome);
    }
}
