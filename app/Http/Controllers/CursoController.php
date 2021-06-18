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

    public function get()
    {
        return response()->json(ResourcesCurso::collection(Curso::where('data_inicio', '>=', date('Y-m-d'))->where('data_fim', '<=', date('Y-m-d'))->orderBy('updated_at', 'DESC')->get()));
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
            $curso = $this->requestsCurso($request);
            $curso->save();
            if ($request->file != null) {
                $caminho = $this->insereMaterial($request->file, $curso->id);
            }
            DB::commit();
            return response()->json(['msg' => 'Curso cadastrado com sucesso!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $arquivo = new ArquivoClass();
            $arquivo->remove($caminho);

            return response()->json(['msg' => 'Ocorreu um erro ao cadastrar o curso'], 401);
        }
    }
    /**
     * Método utilizado para a inserção do material em relação ao curso
     * @param  \Illuminate\Http\Request $request->file
     * @param int $id id do curso
     * @return string caminho do file
     */
    private function insereMaterial($file, $idCurso)
    {
        $arquivo = new ArquivoClass();
        $caminho = $arquivo->upload($file);
        // Salva valor do Material
        $material = new Material();
        $material->nome = $caminho['nome'];
        $material->caminho = $caminho['caminho'];
        $material->save();
        // Salva valor do cursoMaterial
        $cursoMaterial = new CursoMaterial();
        $cursoMaterial->cursos_id = $idCurso;
        $cursoMaterial->materiais_id = $material->id;
        $cursoMaterial->save();
        return $caminho['caminho'];
    }
    /**
     * Método utilizado para adicionar os requests do curso
     *
     * @param \Illuminate\Http\Request  $request
     * @return Curso
     */
    private function requestsCurso(Request $request)
    {
        $curso = new Curso();
        $curso->nome_curso = $request->nomeCurso;
        $curso->descricao = $request->descricao;
        $curso->data_inicio = $request->dataInicio;
        $curso->data_fim = $request->dataFim;
        $curso->valor = $request->valor;
        $curso->quantidade = $request->quantidade;
        return $curso;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
