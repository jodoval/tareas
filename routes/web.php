<?php

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
Auth::routes();

///get
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index');
Route::get('/cambiar-estado/{id?}/{estado?}', 'HomeController@cambiarEstado');
Route::get('/eliminar/{id?}', 'HomeController@eliminar');
Route::get ('/idioma/{id}',function ($id){
  session()->put('idioma',$id);
  return back();
});

//post
route::post('crear-tarea','HomeController@crearTarea');
