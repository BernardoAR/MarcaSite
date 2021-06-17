<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Function index, utilizado para verificação se o usuário está logado ou não, caso não esteja redireciona para o login
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return redirect('/');
        }
        return view('spa');
    }
    /**
     * Método utilizado para o Login do Usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logar(Request $request)
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
     * Método utilizado para deslogar o usuário
     *
     */
    public function deslogar()
    {
        Auth::logout();
        return redirect('/login');
    }
}
