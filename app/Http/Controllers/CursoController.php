<?php

namespace App\Http\Controllers;

use App\Http\Resources\Curso as ResourcesCurso;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\ArquivoClass;
use App\Models\CursoMaterial;
use App\Models\Material;

class CursoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Curso::orderBy('updated_at', 'DESC')->get());
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function getCurso($id)
    {
        return response()->json(Curso::join('curso_materiais', 'curso_materiais.cursos_id', '=', 'cursos.id')->join('materiais', 'materiais.id', '=', 'curso_materiais.materiais_id')->where('cursos.id', $id)->get(['cursos.id', 'cursos.quantidade', 'cursos.nome_curso', 'cursos.descricao', 'cursos.data_inicio', 'cursos.data_fim', 'cursos.valor', 'curso_materiais.materiais_id', 'materiais.caminho', 'materiais.nome AS nome_material'])->first());
    }
    /**
     * Método utilizado para pegar uma coleção de array para dropdowns
     *
     * @return void
     */
    public function get()
    {
        return response()->json(ResourcesCurso::collection(Curso::where('data_inicio', '<=', date('Y-m-d'))->where('data_fim', '>=', date('Y-m-d'))->orderBy('updated_at', 'DESC')->get()));
    }
    /**
     * Atualiza ou grava dados
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUpdate(Request $request)
    {
        try {
            DB::beginTransaction();
            $idCurso = $this->requestsCurso($request, $request->id);
            if ($request->file != null) {
                $caminho = $this->insereMaterial($request, $idCurso, $request->idFile);
            }
            DB::commit();
            return response()->json(['msg' => 'Registro salvo com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($caminho)) {
                $arquivo = new ArquivoClass();
                $arquivo->remove($caminho);
            }
            return response()->json(['msg' => 'Ocorreu um erro ao cadastrar o curso',  'data' => $e->getMessage(), 'linha' => $e->getLine()], 401);
        }
    }

    /**
     * Método utilizado para a inserção do material em relação ao curso
     * @param  \Illuminate\Http\Request $request
     * @param int $id id do curso
     * @param int $idFile id do arquivo
     * @return string caminho do file
     */
    private function insereMaterial($request, $idCurso, $idFile)
    {
        $file = $request->file;
        // Pega o material, caso tenha um file
        $material = (empty($idFile)) ? new Material() : Material::find($idFile);
        // Se o nome do material for igual, não faz nada
        if (!empty($file)) {
            $arquivo = new ArquivoClass();
            $caminho = $arquivo->upload($file);
            $material->nome = $caminho['nome'];
            $material->caminho = $caminho['caminho'];
            $material->save();
            // Salva valor do cursoMaterial
            $cursoMaterial =  (empty($idFile)) ? new CursoMaterial() : CursoMaterial::where('curso_materiais.materiais_id', $idFile)->first();
            $cursoMaterial->cursos_id = $idCurso;
            $cursoMaterial->materiais_id = $material->id;
            $cursoMaterial->save();
            return $caminho['caminho'];
        } else {
            $material->caminho;
        }
    }
    /**
     * Método utilizado para adicionar os requests do curso
     *
     * @param \Illuminate\Http\Request  $request
     * @return int $id ID do curso
     */
    private function requestsCurso(Request $request, $id)
    {
        $curso = (empty($id)) ? new Curso() : Curso::find($id);
        $curso->nome_curso = $request->nomeCurso;
        $curso->descricao = $request->descricao;
        $curso->data_inicio = $request->dataInicio;
        $curso->data_fim = $request->dataFim;
        $curso->valor = $request->valor;
        $curso->quantidade = $request->quantidade;
        $curso->save();
        return $curso->id;
    }

    /**
     * Remove o curso
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = Curso::find($id);
        if ($curso) {
            $curso->delete();
            return response()->json('Curso deletado com sucesso.');
        }
        return response()->json('Curso não encontrado.', 500);
    }
}
