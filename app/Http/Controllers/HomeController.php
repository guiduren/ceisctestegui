<?php

namespace App\Http\Controllers;

use App\Curso;
use App\User;
use App\Aula;
use vendor\Illuminate\Http\Request;

class HomeController extends Controller
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
         $quantidadeUsuarios = User::count();
         $quantidadeAulas = Aula::count();
         $quantidadeCursos = Curso::count();


        /* Compact - Serve para passarmos variaveis (informações) para a nossa view (home') */;
        return view('home', compact('quantidadeUsuarios', 'quantidadeAulas','quantidadeCursos'));

    }
}
