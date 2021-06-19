<?php

namespace App\Http\Controllers;

use App\Http\Resources\Usuario as ResourcesUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(ResourcesUsuario::collection(Usuario::all()));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'bail|required|email|unique:usuarios',
            'senha' => 'bail|required|min:8',
            'nome'  => 'bail|required'
        ]);
        $usuario = new Usuario();
        $usuario->email = $request->email;
        $usuario->senha = bcrypt($request->senha);
        $usuario->nome = $request->nome;
        $usuario->api_token = Str::random(60);
        $usuario->cargo_usuarios_id = $request->cargo;
        $usuario->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
