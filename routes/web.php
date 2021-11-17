<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoDisciplinaController;
use App\Http\Controllers\AulasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DisciplinasController;



Route::get('/', function () {
    return view ('welcome');
});

Route::get('cursodisciplinas', [CursoDisciplinaController::class,'index']);

Route::get('/curso/{id}', [CursosController::class,'obtercursos'])->name('curso.obter');
Route::get('/homecurso', [CursoController::class,'homeCursos'])->name('home.curso');
Route::get('/homecurso/obter', [CursoController::class,'ooo'])->name('ooo');

Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class,'index'])->name('home');
Route::get('/aulas/deleteaula', [CursosController::class,'deleteaula'])->name('cursos.deletar.aula');

Route::get('/usuarios/obter', [UsuariosController::class,'obterUsuarios'])->name('usuarios.obter');
Route::resource('/usuarios', [UsuariosController::class]);

Route::get('/aulas/obter', [AulasController::class,'obterAulas'])->name('aulas.obter');
Route::resource('/aulas', [AulasController::class]);


Route::get('/cursos/obter', [CursosController::class,'obtercursos'])->name('cursos.obter');
Route::get('/cursos/updateaddaula', [CursosController::class,'updateAddAula'])->name('cursos.update.aulas');

Route::resource('/cursos', [CursosController::class]);


Route::get('/categorias/obter', [CategoriasController::class,'obterCategorias'])->name('categorias.obter');
Route::resource('/categorias', [CategoriasController::class]);


Route::get('/disciplinas/obter', [DisciplinasController::class,'obterDisciplinas'])->name('disciplinas.obter');
Route::resource('/disciplinas', [DisciplinasController::class]);

?>

