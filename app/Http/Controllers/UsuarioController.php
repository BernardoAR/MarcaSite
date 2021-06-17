<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
        return response()->json(
            [
                'msg' => 'Nós retornaremos apenas JSON'
            ]
        );
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
        $this->validate($request, [
            'email' => 'bail|required|email|unique:usuarios',
            'senha' => 'bail|required|min:8'
        ]);
        $usuario = new Usuario();
        $usuario->email = $request->email;
        $usuario->senha = bcrypt($request->senha);
        $usuario->save();
    }
    /**
     * Método utilizado para o Login do Usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Valida
        $this->validate($request, [
            'email' => 'bail|required|email',
            'senha' => 'bail|required|min:8'
        ]);
        // Utiliza o auth para logar
        if (Auth::attempt(['email' => $request->email, 'password' => $request->senha], $request->lembrar)) {
            return response()->json(['msg' => 'Você está logado'], 200);
        } else {
            return response()->json(['msg' => 'Email ou senha incorretos'], 401);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
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
