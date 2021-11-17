<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Curso;
use App\Aula;
use App\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view('cadastros.cursos.index', compact('mensagem'));
    }

    public function obtercursos()
    {
        return \Datatables::of(Curso::with('categoria')->orderByDesc('id'))->make(true);
    }

    public function create()
    {
        $data = Categoria::all();
        $disciplinas = Disciplina::all();
        return view ('cadastros.cursos.adicionarCursos',['data'=> $data, 'disciplinas' => $disciplinas]);
    }

    public function store(Request $request) {

        $nome = $request->nome;
        $descricao = $request->descricao;
        $ativo = $request->ativo;
        $image = $request->image;
        $categoria_id = $request->categoria_id;

        DB::beginTransaction();

        try {
         $curso = new Curso;
         $curso->nome = $nome;
         $curso->descricao = $descricao;
         $curso->ativo = $ativo;


         if ($request->hasFile('image') && $request->image->isValid()){
             $file = $request->image->store('cursos');
             $curso->image = $file;
             $data['image'] = $image;
         }
         $curso->categoria_id = $categoria_id;
         $curso->save();


            DB::commit();
            $request->session()
            ->flash(
                'mensagem',
                "Curso '$curso->nome' criado com sucesso!"
            );

          return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();

            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    public function edit(Curso $curso) {

        $disciplinas = Disciplina::all();
        $model = Curso::findOrFail($curso->id);
        $aulas = $curso->aulas;
        $aulasSemCurso = Aula::whereNull('curso_id')->get();

        return view ('cadastros.cursos.editarCursos', compact('model', 'aulas','aulasSemCurso','disciplinas'));
    }

    public function updateAddAula(Request $request)
    {
        $curso_id = $request->curso_id;
        $aula_id = $request->aula_id;

        DB::beginTransaction();

        try {
            $aula = Aula::findOrFail($aula_id);
            $aula->curso_id = $curso_id;
            $aula->save();

            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    /**
     * Update the given user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $nome = $request->nome;
        $descricao = $request->descricao;
        $ativo = $request->ativo;
        $image = $request->image;

        DB::beginTransaction();

        try {
            $curso = Curso::findOrFail($id);
            $curso->nome = $nome;
            $curso->descricao = $descricao;
            $curso->ativo = $ativo;


            if ($request->hasFile('image') && $request->image->isValid()){
                $file = $request->image->store('cursos');
                $curso->image = $file;
                $data['image'] = $image;
          }

            $curso->save();
            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $model= Curso::findOrFail($id);
        return view ('cadastros.cursos.editarCursos', compact('model'));
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Curso::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['sucesso' => true, 'mensagem' => 'Registro deletado com sucesso']);

        } catch (\Exception $ex){
            DB::rollback();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);

        }
    }

    public function deleteaula(Request $request)
    {

        $id = $request->id;

        DB::beginTransaction();

        try {
            $aula= Aula::findOrFail($id);
            $aula->curso_id = null;
            $aula->save();
            DB::commit();

            return response()->json(['sucesso' => true, 'mensagem' => 'Registro deletado com sucesso']);

        } catch (\Exception $ex){
            DB::rollback();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);
    }}

}
