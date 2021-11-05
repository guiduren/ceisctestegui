<?php

namespace App\Http\Controllers;


use App\Curso;
use App\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CursosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $mensagem = $request->session()->get('mensagem');
        return view('cadastros.cursos.index', compact('mensagem'));

    }

    public function obtercursos()
    {
        return \Datatables::of(Curso::orderByDesc('id'))->make(true);
    }

    public function create()
    {
        return view ('cadastros.cursos.adicionarCursos');
    }

    public function store(Request $request) {

        $nome = $request->nome;
        $descricao = $request->descricao;
        $ativo = $request->ativo;
        $image = $request->image;


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

        $model = Curso::findOrFail($curso->id);

        if($curso){
            echo "<h1>Curso:</h1>";
            echo "Nome do Curso: {$curso->nome}";
       }

        // aulas
        $aulas = $curso->aulas;

        return view ('cadastros.cursos.editarCursos', compact('model', 'aulas'));
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
            dd($ex);
            DB::rollback();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);

        }
    }


}
