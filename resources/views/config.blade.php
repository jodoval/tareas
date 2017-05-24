@extends('layouts.app')

@section('content')

<div class="container">
  <h1>{{__('messages.configuracion')}}</h1>
  <hr>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h1 class="panel-title">{{__('messages.cambiar_contraseña')}}</h1>
    </div>
    <div class="panel-body">
      <form  action="{{route ('cambiar.pass')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
          <label for="oldPass">{{__('messages.anterior_contraseña')}}</label>
          <input type="password" name="oldPass" class="form-control">
        </div>
        <div class="form-group">
          <label for="newPass1">{{__('messages.nueva_contraseña')}}</label>
          <input type="password" name="newPass1" class="form-control">
        </div>
        <div class="form-group">
          <label for="newPass2">{{__('messages.confirmar_contraseña')}}</label>
          <input type="password" name="newPass2" class="form-control">
        </div>
       <div class="form-group">
         <input type="submit" class="btn btn-primary" value="{{__('messages.salvar')}}">

       </div>

      </form>
    </div>
  </div>

</div>


@endsection
