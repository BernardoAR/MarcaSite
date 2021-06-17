<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArquivoController extends Controller
{
    /**
     * Fazer upload do arquivo
     *
     * @param Request $request
     * @return array|null Caminho do arquivo
     */
    public function upload(Request $request)
    {
        $file = $request->file;
        $nome = $file->getClientOriginalName();
        $extensao = $file->getClientOriginalExtension();
        $fileName = time() . '.' . $extensao;
        $caminho = public_path("uploads/$extensao", $fileName);
        if ($file->move($caminho, $fileName)) {
            return array('nome' => $nome, 'caminho' => $caminho);
        } else return null;
    }
}
