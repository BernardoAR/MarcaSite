<?php

namespace App\Http\Controllers;

use App\Http\Resources\Usuario as ResourcesUsuario;
use App\Models\Contato;
use App\Models\DadosUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{

    /**
     * Método utilizado para pegar o usuário
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ResourcesUsuario::collection(Usuario::all()));
    }
    /**
     * Método utilizado para pegar todos os usuários
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return response()->json(Usuario::join('cargo_usuarios', 'cargo_usuarios.id', '=', 'usuarios.cargo_usuarios_id')->get(['usuarios.id', 'usuarios.email', 'usuarios.nome', 'cargo_usuarios.titulo AS tipo']));
    }
    /**
     * Método utilizado para pegar os dados de usuário em relação a todos os dados necessários da inscrição
     *
     * @return void
     */
    public function getUsuarioInscricao($id)
    {
        $valor =
            Usuario::leftJoin('dados_usuarios', 'usuarios.id', '=', 'dados_usuarios.usuarios_id')
            ->leftJoin('enderecos', 'enderecos.id', '=', 'dados_usuarios.enderecos_id')
            ->where('usuarios.id', $id)
            ->get(['usuarios.id', 'usuarios.email', 'usuarios.nome', 'usuarios.cargo_usuarios_id', 'dados_usuarios.cpf', 'dados_usuarios.empresa', 'dados_usuarios.tipo_usuarios_id', 'enderecos.id AS id_endereco', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.uf', 'enderecos.cep', 'enderecos.cidade', 'enderecos.complemento'])->first();
        $this->retornaContatos($valor, $id);
        return response()->json($valor);
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
     * Método utilizado para retorna os contatos baseado no usuário
     *
     * @param int $id
     * @return void
     */
    public function retornaContatos(&$valor, $id)
    {
        $contatos = Contato::join('dados_usuario_contatos', 'dados_usuario_contatos.contatos_id', '=', 'contatos.id')->join('dados_usuarios', 'dados_usuarios.id', '=', 'dados_usuario_contatos.dados_usuarios_id')->where('dados_usuarios.usuarios_id', $id)->get();
        foreach ($contatos as $contato) {
            if ($contato['tipo_contatos_id'] == 2) {
                $valor['telefone'] = $contato['numero'];
            } else if ($contato['tipo_contatos_id'] == 1) {
                $valor['celular'] = $contato['numero'];
            }
        }
    }
    /**
     * Método utilizado para pegar os dados do usuário, junto com
     * @param int $id do usuario
     *
     * @return void
     */
    public function getUsuarioDados($id)
    {
        return response()->json(Usuario::leftJoin('dados_usuarios', 'usuarios.id', '=', 'dados_usuarios.usuarios_id')->where('usuarios.id', $id)->get(['usuarios.id', 'usuarios.email', 'usuarios.nome', 'usuarios.cargo_usuarios_id', 'dados_usuarios.cpf', 'dados_usuarios.empresa', 'dados_usuarios.tipo_usuarios_id'])->first());
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
     * Remove o usuário
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if ($usuario) {
            $usuario->delete();
            return response()->json('Usuário deletado com sucesso.');
        }
        return response()->json('Usuário não encontrado.', 500);
    }
}
