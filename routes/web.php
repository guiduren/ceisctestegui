<?php

Route::get('/', function () {
    return view ('welcome');
});

Route::get('/curso/{id}', 'CursoController@obterCurso')->name('curso.obter');
Route::get('/homecurso', 'CursoController@homeCursos')->name('home.curso');
Route::get('/homecurso/obter', 'CursoController@ooo')->name('ooo');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/usuarios/obter', 'UsuariosController@obterUsuarios')->name('usuarios.obter');
Route::resource('/usuarios', 'UsuariosController');

Route::get('/aulas/obter', 'AulasController@obterAulas')->name('aulas.obter');
Route::resource('/aulas', 'AulasController');

Route::get('/cursos/obter', 'CursosController@obterCursos')->name('cursos.obter');
Route::get('/cursos/updateaddaula', 'CursosController@updateAddAula')->name('cursos.update.aulas');
Route::resource('/cursos', 'CursosController');


Route::get('/categorias/obter', 'CategoriasController@obterCategorias')->name('categorias.obter');
Route::resource('/categorias', 'CategoriasController');

?>

