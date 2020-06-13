<?php

use App\Http\Controllers\PrincipalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PrincipalController@index');

Route::post('/', 'PrincipalController@buscar');

Route::get('/login', 'AuthController@index');

Route::post('/login', 'AuthController@ingresar');

Route::get('/logout', 'AuthController@cerrarsession');

Route::get('/nologeado', function () {
    return view('nologeado');
});

Route::get('/sinpermisos', function () {
    return view('sinpermisos');
});

Route::get('/registro', 'AuthController@registro');

Route::post('/registro', 'AuthController@registrar');


Route::get('/miperfil', 'UserController@index');
Route::post('/miperfil', 'UserController@actualizar');


Route::get('/miperfil/curriculum', 'UserController@vercurriculum');
Route::post('/miperfil/curriculum/titulo', 'UserController@guardartitulo');
Route::post('/miperfil/curriculum/experiencia', 'UserController@guardarexperiencia');
Route::post('/miperfil/curriculum/observacion', 'UserController@guardarobservacion');

Route::get('/miperfil/ofertas', 'UserController@verofertas');

Route::post('/miperfil/eliminar', 'UserController@eliminar');


Route::post('/miperfil/ofertas/categoria', 'UserController@guardarcategoria');
Route::post('/miperfil/ofertas', 'UserController@guardaroferta');

Route::post('/listado', 'PrincipalController@verlistado');
Route::post('/aplicar', 'PrincipalController@aplicar');
Route::post('/removerapp', 'PrincipalController@removerapp');

Route::get('/aplicaciones','UserController@misaplicaciones');

Route::post('/reporte/aplicaciones','UserController@reporteaplicaciones');

