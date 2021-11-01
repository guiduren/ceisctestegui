<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Http\Request;
use vendor\Yajra\Datatables\Facades\Datatables;

class UsuariosController extends Controller
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
        return view('cadastros.usuarios.index');
    }

    public function obterUsuarios() {
        return \DataTables::of(User::orderByDesc('id'))->make(true);
    }

    public function create()
    {
        return view('cadastros.usuarios.adicionar');
    }

    public function store(Request $request) {
        $name = $request->name;
        $password = $request->password;
        $email = $request->email;

        DB::beginTransaction();

        try {
            $usuario = new User;
            $usuario->name = $name;
            $usuario->password = $password;
            $usuario->email = $email;
            $usuario->save();
            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro salvo com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser salvo']);
        }
    }

    public function edit($id) {
        $model = User::findOrFail($id);
        return view('cadastros.usuarios.editar', compact('model'));
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
        $name = $request->name;
        $password = $request->password;
        $email = $request->email;

        DB::beginTransaction();

        try {
            $usuario = User::findOrFail($id);
            $usuario->name = $name;
            $usuario->password = $password;
            $usuario->email = $email;
            $usuario->save();
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
        $model = User::findOrFail($id);
        return view('cadastros.usuarios.editar', compact('model'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            User::findOrFail($id)->delete();
            DB::commit();
            return response()->json(['sucesso' => true, 'mensagem' => 'Registro deletado com sucesso']);
        } catch (\Exception $ex){
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Registro não pode ser deletado']);
        }
    }
}
