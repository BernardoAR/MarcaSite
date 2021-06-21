<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Models\DadosUsuario;
use App\Models\DadosUsuarioContato;
use App\Models\Endereco;
use App\Models\Inscricao;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InscricaoController extends Controller
{
    /**
     * Método utilizado para pegar os dados de usuário em relação a todos os dados necessários da inscrição
     *
     * @return void
     */
    public function getInscricaoUsuario($id)
    {
        $valor =
            Inscricao::leftJoin('usuarios', 'usuarios.id', '=', 'inscricoes.usuarios_id')->leftJoin('dados_usuarios', 'usuarios.id', '=', 'dados_usuarios.usuarios_id')
            ->leftJoin('enderecos', 'enderecos.id', '=', 'dados_usuarios.enderecos_id')
            ->where('inscricoes.id', $id)
            ->get(['usuarios.id', 'usuarios.email', 'usuarios.nome', 'usuarios.cargo_usuarios_id', 'dados_usuarios.cpf', 'dados_usuarios.empresa', 'dados_usuarios.tipo_usuarios_id', 'enderecos.id AS id_endereco', 'enderecos.logradouro', 'enderecos.numero', 'enderecos.uf', 'enderecos.cep', 'enderecos.cidade', 'enderecos.complemento', 'inscricoes.cursos_id'])->first();
        $this->retornaContatos($valor, $valor['id']);
        return response()->json($valor);
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
     * Método utilizado para pegar a lista de inscrição
     *
     * @return \Illuminate\Http\Response
     */
    public function getInscricaoList()
    {
        return response()->json(Inscricao::join('usuarios', 'inscricoes.usuarios_id', '=', 'usuarios.id')
            ->join('dados_usuarios', 'inscricoes.usuarios_id', '=', 'dados_usuarios.usuarios_id')
            ->join('enderecos', 'enderecos.id', '=', 'dados_usuarios.enderecos_id')
            ->join('tipo_usuarios', 'tipo_usuarios.id', '=', 'dados_usuarios.tipo_usuarios_id')
            ->join('status', 'inscricoes.status_id', '=', 'status.id')
            ->join('cursos', 'inscricoes.cursos_id', '=', 'cursos.id')->get(['inscricoes.id', 'usuarios.nome AS inscrito', 'inscricoes.created_at AS data_inscricao', 'tipo_usuarios.titulo AS categoria', 'dados_usuarios.cpf', 'usuarios.email', 'enderecos.uf', 'status.id AS status', 'cursos.valor AS total']));
    }
    /**
     * Método utilizado para pegar a lista de inscrição, especificamente
     *
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        return response()->json(Inscricao::join('usuarios', 'inscricoes.usuarios_id', '=', 'usuarios.id')
            ->join('dados_usuarios', 'inscricoes.usuarios_id', '=', 'dados_usuarios.usuarios_id')
            ->join('enderecos', 'enderecos.id', '=', 'dados_usuarios.enderecos_id')
            ->join('tipo_usuarios', 'tipo_usuarios.id', '=', 'dados_usuarios.tipo_usuarios_id')
            ->join('status', 'inscricoes.status_id', '=', 'status.id')
            ->join('cursos', 'inscricoes.cursos_id', '=', 'cursos.id')->where('usuarios.id', $id)->get(['inscricoes.id', 'usuarios.nome AS inscrito', 'inscricoes.created_at AS data_inscricao', 'tipo_usuarios.titulo AS categoria', 'dados_usuarios.cpf', 'usuarios.email', 'enderecos.uf', 'status.id AS status', 'cursos.valor AS total'])->first());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $idUsuario = $this->requestsUsuario($request, $request->usuario['id']);
            $idEndereco = $this->requestsEndereco($request, $request->endereco['id']);
            $idDadosUsuario =  $this->requestsDadosUsuario($request->usuario, $idUsuario, $idEndereco);
            $this->requestsContato($request, $idDadosUsuario);
            $this->requestsInscricao($request, $idUsuario, $request->id);
            DB::commit();
            return response()->json(['msg' => 'Inscrição cadastrada com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['msg' => 'Ocorreu um erro ao se increver', 'data' => $e->getMessage(), 'linha' => $e->getLine()], 401);
        }
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
        $usuario->nome = $request->usuario['nome'];
        $usuario->email = $request->usuario['email'];
        $usuario->api_token = Str::random(60);
        // Se o usuáro for vazio, cadastrará a senha
        if (empty($id)) {
            $usuario->senha = bcrypt($usuario->senha);
        }
        $usuario->save();
        return $usuario->id;
    }
    /**
     * Método utilizado para criar ou atualizar o contato
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idDadosUsuario ID do dados usuario
     * @return int
     */
    private function requestsContato($request, $idDadosUsuario)
    {
        $telefoneAdicionado = false;
        $celularAdicionado = false;
        $contatos = Contato::join('dados_usuario_contatos', 'dados_usuario_contatos.contatos_id', '=', 'contatos.id')->where('dados_usuario_contatos.dados_usuarios_id', $idDadosUsuario)->get(['contatos.*']);
        if (!empty($contatos)) {
            foreach ($contatos as $contato) {
                if ($contato->tipo_contatos_id == 1) {
                    $celularAdicionado = true;
                    $contato->numero = $request->contato['celular'];
                    $contato->save();
                } else {
                    $telefoneAdicionado = true;
                    $contato->numero = $request->contato['telefone'];
                    $contato->save();
                }
            }
        }
        $this->novoContato($request, $telefoneAdicionado, $celularAdicionado, $idDadosUsuario);
    }
    /**
     * Método utilizado para a inserção de um novo contato
     *
     * @param int $id id do dadosusuario
     * @return void
     */
    public function novoContato($request, $telefoneAdicionado, $celularAdicionado, $id)
    {
        if (!$telefoneAdicionado) {
            $celularAdicionado = true;
            $contato = new Contato();
            $contato->numero = $request->contato['telefone'];
            $contato->tipo_contatos_id = 2;
            $contato->save();
            $dadosUsuarioContatos = new DadosUsuarioContato();
            $dadosUsuarioContatos->dados_usuarios_id = $id;
            $dadosUsuarioContatos->contatos_id = $contato->id;
            $dadosUsuarioContatos->save();
        }
        if (!$celularAdicionado) {
            $celularAdicionado = true;
            $contato = new Contato();
            $contato->numero = $request->contato['celular'];
            $contato->tipo_contatos_id = 1;
            $contato->save();
            $dadosUsuarioContatos = new DadosUsuarioContato();
            $dadosUsuarioContatos->dados_usuarios_id = $id;
            $dadosUsuarioContatos->contatos_id = $contato->id;
            $dadosUsuarioContatos->save();
        }
    }
    /**
     * Método utilizado para criar ou atualizar ou cadastrar o endereco
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return int
     */
    private function requestsEndereco($request, $id)
    {
        $endereco = (empty($id)) ? new Endereco() : Endereco::find($id);
        $endereco->logradouro = $request->endereco['logradouro'];
        $endereco->numero = $request->endereco['numero'];
        $endereco->uf = $request->endereco['uf'];
        $endereco->cep = $request->endereco['cep'];
        $endereco->cidade = $request->endereco['cidade'];
        $endereco->complemento = $request->endereco['complemento'];
        $endereco->save();
        return $endereco->id;
    }
    /**
     * Método utilizado para criar ou atualizar a inscrição
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idUsuario id do usuario
     * @param  int  $idEndereco id do endereço
     * @param  int  $idEndereco id da inscrição
     * @return void
     */
    private function requestsInscricao($request, $idUsuario, $idInscricao)
    {
        $inscricao = (empty($idInscricao)) ? new Inscricao() : Inscricao::find($idInscricao);
        $inscricao->usuarios_id = $idUsuario;
        $inscricao->cursos_id = $request->curso;
        if (empty($idInscricao)) {
            $inscricao->status_id = 2;
        }
        $inscricao->save();
    }
    /**
     * Método utilizado para criar ou atualizar o usuario
     *
     * @param  \Illuminate\Http\Request  $request->usuario
     * @param  int  $idUsuario id do usuario
     * @param  int  $idEndereco id do endereço
     * @return void
     */
    private function requestsDadosUsuario($request, $idUsuario, $idEndereco)
    {
        $dadosUsuario = (DadosUsuario::where('usuarios_id', $idUsuario)->first() ?? new DadosUsuario());
        $dadosUsuario->cpf = $request['dadosUsuario']['cpf'];
        $dadosUsuario->empresa = $request['dadosUsuario']['empresa'];
        $dadosUsuario->tipo_usuarios_id = $request['dadosUsuario']['profissao'];
        $dadosUsuario->usuarios_id = $idUsuario;
        $dadosUsuario->enderecos_id = $idEndereco;
        $dadosUsuario->save();
        return $dadosUsuario->id;
    }
    /**
     * Atualiza o Status baseado no id da inscrição
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Status  $id ID do status
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $inscricao = Inscricao::find($id);
        // Se existir, atualiza
        if ($inscricao) {
            $inscricao->status_id = $request->status;
            $inscricao->save();
            return response()->json('Status atualizado com sucesso.');
        }
        return response()->json('Inscrição não encontrada.', 500);
    }

    /**
     * Remove a inscrição específica
     *
     * @param  \App\Models\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inscricao = Inscricao::find($id);
        if ($inscricao) {
            $inscricao->delete();
            return response()->json('Inscrição deletada com sucesso.', 200);
        }
        return response()->json('Inscrição não encontrada.', 500);
    }
}
