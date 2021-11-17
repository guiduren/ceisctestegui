<?php

namespace App\Http\Controllers;


use App\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisciplinasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('cadastros.disciplinas.index');
    }

    public function create()
    {
        return view('cadastros.disciplinas.adicionarDisciplinas');
    }

    public function store(Request $request)
    {
        $nome = $request->nome;

        DB::beginTransaction();

        try {
            $disciplina = new Disciplina();
            $disciplina->nome = $nome;
            $disciplina->save();

            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    public function obterdisciplinas()
    {
        return \Datatables::of(Disciplina::orderByDesc('id'))->make(true);
    }

    public function show($id)
    {
        $model = Disciplina::findOrFail($id);
        return view('cadastros.disciplinas.editarDisciplinas', compact('model'));
    }

    public function edit($id)
    {
        $model = Disciplina::findOrFail($id);
        return view('cadastros.disciplinas.editarDisciplinas', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $nome = $request->nome;

        DB::beginTransaction();

        try {
            $disciplina = Disciplina::findOrFail($id);
            $disciplina->nome = $nome;
            $disciplina->save();

            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Disciplina::findOrFail($id)->delete();
            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro deletado com sucesso']);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);

        }
    }
}
