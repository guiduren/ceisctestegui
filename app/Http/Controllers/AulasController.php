<?php

namespace App\Http\Controllers;

use DB;
use App\Aula;
use App\Curso;
use Illuminate\Http\Request;
use vendor\Yajra\Datatables\Facades\Datatables;

class AulasController extends Controller
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
    public function index()
    {
        return view('cadastros.aulas.index');
    }

    public function obteraulas()
    {
        return \Datatables::of(Aula::with('curso')->orderByDesc('id'))->make(true);
    }

    public function create()
    {
        $data = Curso::all();
        return view ('cadastros.aulas.adicionarAulas', ['data' => $data]);
    }

    public function store(Request $request) {

        $nome = $request->nome;
        $descricao = $request->descricao;
        $disponivel = $request->disponivel;
        $curso_id = $request->curso_id;


        DB::beginTransaction();

        try {
            $aula = new Aula;
            $aula->nome = $nome;
            $aula->descricao = $descricao;
            $aula->disponivel = $disponivel;
            $aula->curso_id = $curso_id;
            $aula->save();

            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    public function edit($id) {

        $model = Aula::findOrFail($id);
        $data = Curso::all();
        return view ('cadastros.aulas.editarAulas', compact('model'),['dataa' => $data]);
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
        $disponivel = $request->disponivel;
        $curso_id = $request->curso_id;


        DB::beginTransaction();

        try {
            $aula = Aula::findOrFail($id);
            $aula->nome = $nome;
            $aula->descricao = $descricao;
            $aula->disponivel = $disponivel;
            $aula->curso_id = $curso_id;

            $aula->save();

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
        $model = Aula::findOrFail($id);
        return view('cadastros.aulas.editarAulas', compact('model'));
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Aula::findOrFail($id)->delete();
            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro deletado com sucesso']);
        } catch (\Exception $ex){
            DB::rollback();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);

        }
    }
}
