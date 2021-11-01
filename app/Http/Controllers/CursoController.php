<?php

namespace App\Http\Controllers;

use App\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    public function obterCurso($id)
    {
        $curso = Curso::find($id);
        return view('cadastros.cursos.umCurso', compact("curso"));
    }

    public function homecursos()
    {
        return view('cadastros.cursos.homeCursos');
    }

    public function ooo()
    {
        return \Datatables::of(Curso::orderByDesc('id'))->make(true);
    }

}


