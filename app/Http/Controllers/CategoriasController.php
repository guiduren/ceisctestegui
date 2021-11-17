<?php

namespace App\Http\Controllers;

use DB;
use App\Categoria;
use Illuminate\Http\Request;
use vendor\Yajra\Datatables\Facades\Datatables;



class CategoriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('cadastros.categorias.index');
    }


    public function create()
    {
        return view ('cadastros.categorias.adicionarCategorias');
    }


    public function store(Request $request)
    {
        $nome = $request->nome;

        DB::beginTransaction();

        try {
            $categoria = new Categoria;
            $categoria->nome = $nome;
            $categoria->save();

            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }


    public function obtercategorias()
    {
        return \Datatables::of(Categoria::orderByDesc('id'))->make(true);
    }

    public function show($id)
    {
        $model = Categoria::findOrFail($id);
        return view('cadastros.categorias.editarCategorias', compact('model'));
    }

    public function edit($id)
    {
        $model = Categoria::findOrFail($id);
        return view('cadastros.categorias.editarCategorias', compact('model'));
    }


    public function update(Request $request, $id)
    {
        $nome = $request->nome;

        DB::beginTransaction();

        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->nome = $nome;
            $categoria->save();

            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            Categoria::findOrFail($id)->delete();
            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro deletado com sucesso']);
        } catch (\Exception $ex){
            DB::rollback();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);

        }
    }
}
