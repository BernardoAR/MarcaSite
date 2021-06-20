<?php

namespace App\Http\Controllers;

use App\Http\Resources\Usuario as ResourcesUsuario;
use App\Models\DadosUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * Método utilizado para pegar os dados do usuário, junto com
     * @param int $id do usuario
     *
     * @return void
     */
    public function getUsuarioDados($id)
    {
        return response()->json(Usuario::leftJoin('dados_usuarios', 'usuarios.id', '=', 'dados_usuarios.usuarios_id')->where('usuarios.id', $id)->get(['usuarios.id', 'usuarios.email', 'usuarios.nome', 'usuarios.cargo_usuarios_id', 'dados_usuarios.cpf', 'dados_usuarios.empresa', 'dados_usuarios.cpf', 'dados_usuarios.tipo_usuarios_id'])->first());
    }
    /**
     * Método utilizado para gravar dados, tanto no Usuário quanto no DadosUsuario, feito por um cadastro de usuário
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storeUpdateUsuarioDados(Request $request)
    {
        try {
            DB::beginTransaction();
            $idUsuario = $this->requestsUsuario($request, $request->id);
            $this->requestsDadosUsuario($request, $idUsuario);
            DB::commit();
            return response()->json(['msg' => 'Registro salvo com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'Ocorreu um erro ao se registrar', 'data' => $e->getMessage(), 'linha' => $e->getLine()], 401);
        }
        // Verifica o ID
        $usuario = Usuario::find($request->id);

        if (empty($request->id)) {
            $usuario->senha = bcrypt($request->senha);
        }

        $usuario->save();
        return $request;
        // $usuario->contato;
    }
    /**
     * Método utilizado para criar ou atualizar o usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idUsuario id do usuario
     * @return void
     */
    private function requestsDadosUsuario($request, $idUsuario)
    {
        $dadosUsuario = (DadosUsuario::where('usuarios_id', $idUsuario)->first() ?? new DadosUsuario());
        $dadosUsuario->cpf = $request->dadosUsuario['cpf'];
        $dadosUsuario->empresa = $request->dadosUsuario['empresa'];
        $dadosUsuario->tipo_usuarios_id = $request->dadosUsuario['profissao'];
        $dadosUsuario->usuarios_id = $idUsuario;
        $dadosUsuario->save();
        return $dadosUsuario->id;
    }
    /**
     * Método utilizado para criar ou atualizar o usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return int
     */
    private function requestsUsuario($request, $id)
    {
        $usuario = (empty($id)) ? new Usuario() : Usuario::find($id);
        $usuario->email = $request->email;
        $usuario->nome = $request->nome;
        $usuario->api_token = Str::random(60);
        $usuario->cargo_usuarios_id = $request->tipo;
        // Se o usuáro for vazio, cadastrará a senha
        if (empty($id)) {
            $usuario->senha = bcrypt($usuario->senha);
        }
        $usuario->save();
        return $usuario->id;
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
