<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Auth;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware(function ($request,$next){
          if (session()->has('idioma')){
            App::setlocale(session()->get('idioma'));
          }
        return $next($request);
      });

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas=Task::where('user_id',Auth::id())->orderBy('created_at','desc')->paginate(5);
        return view ('home',['tareas'=>$tareas]);
    }

    public function crearTarea (Request $request){
      $this->validate ($request,[
        'texto'=>'required|string|max:191'
      ]);
      $tarea=new Task();
      $tarea->texto=$request->texto;
      $tarea->user_id=Auth::id();
      $tarea->save();

      alert()->success(__('messages.creada_la_tarea'))->persistent(__('messages.cerrar'));  //usando sweet alerts
      // session()->flash('msg','Tarea creada correctamente');
      // session()->flash('tipoAlert','success');
      return redirect ('/home');


    } //fin crearTarea


    public function cambiarEstado($id=null,$estado=null){
        if (!isset($id) || !isset($estado)){
          session()->flash('msg',__('messages.no_se_ha_podido'));
          session()->flash('tipoAlert','danger');
          return redirect ('/home');
        }

        $tarea=Task::find($id);
        if ($tarea->user_id===Auth::id()) {   //controla que sea el usuario de la sesion
          switch ($estado) {
            case 1:
              $tarea->estado="En proceso";
              break;
            case 2:
              $tarea->estado="Completada";
              break;

          }
           $tarea->save();
        }
        session()->flash('msg',__('messages.tarea_cambiada'));
        session()->flash('tipoAlert','success');
        return redirect('/home');

    }  //fin cambiarEstado

       public function eliminar($id=null){
         if (!isset($id)) {
           session()->flash('msg',__('messages.no_se_ha_podido'));
           session()->flash('tipoAlert','danger');
           return redirect ('/home');
         }

         $tarea=Task::find($id);
         if ($tarea->user_id===Auth::id()) {   //controla que sea el usuario de la sesion

            $tarea->delete();
         }
         session()->flash('msg',__('messages.tarea_eliminada'));
         session()->flash('tipoAlert','success');
         return redirect('/home');


       }  //fin eliminar




}  //fin controlador
