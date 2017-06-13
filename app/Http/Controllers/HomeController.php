<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Auth;
use App;
use Hash;
use App\User;
use Log;

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
      //  $tareas=Task::where('user_id',Auth::id())->orderBy('created_at','desc')->paginate(5);
      $tareas=User::find(Auth::id())->tasks()->orderBy('created_at','desc')->paginate(5);
        return view ('home',['tareas'=>$tareas]);
    }

    public function crearTarea (Request $request){
      $this->validate ($request,[
        'texto'=>'required|string|max:191'
      ]);
      // $tarea=new Task();
      // $tarea->texto=$request->texto;
      // $tarea->user_id=Auth::id();
      // $tarea->save();
      $tarea=new Task(['texto'=>$request->texto]);
      $usuario=User::find(Auth::id());
      $usuario->tasks()->save($tarea);

      alert()->success(__('messages.creada_la_tarea'))->persistent(__('messages.cerrar'));  //usando sweet alerts
      // session()->flash('msg','Tarea creada correctamente');
      // session()->flash('tipoAlert','success');
      return redirect()->route('inicio');


    } //fin crearTarea


    public function cambiarEstado($id=null,$estado=null){
        if (!isset($id) || !isset($estado)){
          session()->flash('msg',__('messages.no_se_ha_podido'));
          session()->flash('tipoAlert','danger');
          return redirect()->route('inicio');
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
        return redirect()->route('inicio');

    }  //fin cambiarEstado

       public function eliminar($id=null){
         if (!isset($id)) {
           session()->flash('msg',__('messages.no_se_ha_podido'));
           session()->flash('tipoAlert','danger');
           return redirect()->route('inicio');
         }

         $tarea=Task::find($id);
         if ($tarea->user_id===Auth::id()) {   //controla que sea el usuario de la sesion

            $tarea->delete();
            session()->flash('msg',__('messages.tarea_eliminada'));
            session()->flash('tipoAlert','success');
         }else{
           Log::notice('Intento de eliminación fallido',[
             'id'=>Auth::id(),
             'tarea'=>$id,
           ]);
         }

         return redirect()->route('inicio');


       }  //fin eliminar


       public function verConfiguracion(){
         return view ('config');
       }


       public function cambiarPass(Request $request){
         $this->validate ($request,[
           'oldPass'=>'required|string',
           'newPass1'=>'required|string|min:8',
           'newPass2'=>'required|string|min:8',
         ]);

         if (Hash::check($request->oldPass,Auth::user()->password)){
           if ($request->newPass1 === $request->newPass2){
                 $usuario=User::find(Auth::id());
                 $usuario->password=Hash::make($request->newPass1);
                 $usuario->save();
                 session()->flash('msg',__('messages.pass_modificada'));
                 session()->flash('tipoAlert','success');
            }else{
              session()->flash('msg',__('messages.pass_distintas'));
              session()->flash('tipoAlert','danger');
            }
          }else{
            session()->flash('msg',__('messages.pass_incorrecta'));
            session()->flash('tipoAlert','danger');
          }

          return redirect()->route('configuracion');

        }    //fin cambiar pass






}  //fin controlador
