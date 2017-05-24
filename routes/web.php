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
})->name('welcome');

Route::get('/home', 'HomeController@index')->name('inicio');
Route::get('/cambiar-estado/{id?}/{estado?}', 'HomeController@cambiarEstado')->name('cambiar.estado');
Route::get('/eliminar/{id?}', 'HomeController@eliminar')->name('eliminar.tarea');
Route::get ('/idioma/{id}',function ($id){
  session()->put('idioma',$id);
  return back();
})->name('idioma');
Route::get('config','HomeController@verConfiguracion')->name('configuracion');

//post
route::post('crear-tarea','HomeController@crearTarea')->name('crear.tarea');
Route::post('config','HomeController@cambiarPass')->name('cambiar.pass');
