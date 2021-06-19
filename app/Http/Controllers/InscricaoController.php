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
     * Método utilizado para pegar a list especifica
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $idUsuario = $this->requestsUsuario($request, $request->id);
            $idEndereco = $this->requestsEndereco($request, $request->endereco['id']);
            $idDadosUsuario =  $this->requestsDadosUsuario($request, $idUsuario, $idEndereco);
            $this->requestsContato($request, $idDadosUsuario);
            $this->requestsInscricao($request, $idUsuario);
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
        if (!empty($request->usuario['senha'])) {
            $usuario->senha = bcrypt($request->usuario['senha']);
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
        $contatos = Contato::join('dados_usuario_contatos', 'dados_usuario_contatos.contatos_id', '=', 'contatos.id')->get(['contatos.*']);
        if (!empty($contatos)) {
            foreach ($contatos as $contato) {
                if ($contato->tipo_contatos_id == 1) {
                    $celularAdicionado = true;
                    $contato->ddd = $request->contato['celular']['ddd'];
                    $contato->numero = $request->contato['celular']['numero'];
                    $contato->save();
                } else {
                    $telefoneAdicionado = true;
                    $contato->ddd = $request->contato['telefone']['ddd'];
                    $contato->numero = $request->contato['telefone']['numero'];
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
            $contato->ddd = $request->contato['telefone']['ddd'];
            $contato->numero = $request->contato['telefone']['numero'];
            $contato->tipo_contatos_id = 2;
            $contato->save();
            $dadosUsuarioContatos = new DadosUsuarioContato();
            print_r($id);
            $dadosUsuarioContatos->dados_usuarios_id = $id;
            $dadosUsuarioContatos->contatos_id = $contato->id;
            $dadosUsuarioContatos->save();
        }
        if (!$celularAdicionado) {
            $celularAdicionado = true;
            $contato = new Contato();
            $contato->ddd = $request->contato['celular']['ddd'];
            $contato->numero = $request->contato['celular']['numero'];
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
     * @return void
     */
    private function requestsInscricao($request, $idUsuario)
    {
        $inscricao = new Inscricao();
        $inscricao->usuarios_id = $idUsuario;
        $inscricao->cursos_id = $request->curso;
        $inscricao->status_id = 2;
        $inscricao->save();
    }
    /**
     * Método utilizado para criar ou atualizar o usuario
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $idUsuario id do usuario
     * @param  int  $idEndereco id do endereço
     * @return void
     */
    private function requestsDadosUsuario($request, $idUsuario, $idEndereco)
    {
        $dadosUsuario = (DadosUsuario::where('usuarios_id', $idUsuario)->first() ?? new DadosUsuario());
        $dadosUsuario->cpf = $request->usuario['dadosUsuario']['cpf'];
        $dadosUsuario->empresa = $request->usuario['dadosUsuario']['empresa'];
        $dadosUsuario->tipo_usuarios_id = $request->usuario['dadosUsuario']['tipoUsuario'];
        $dadosUsuario->usuarios_id = $idUsuario;
        $dadosUsuario->enderecos_id = $idEndereco;
        $dadosUsuario->save();
        return $dadosUsuario->id;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function show(Inscricao $inscricao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscricao $inscricao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscricao $inscricao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscricao  $inscricao
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inscricao = Inscricao::find($id);
        if ($inscricao) {
            $inscricao->delete();
            return response()->json('Tipo de Contato deletado com sucesso.', 200);
        }
        return response()->json('Tipo de Contato não encontrado.', 500);
    }
}
