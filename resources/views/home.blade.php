@extends('layouts.app')

@section('content')
<div class="modal fade" id="crear" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">  {{__('messages.crear_tarea')}}</h4>
      </div>
      <form action="{{route('crear.tarea')}}" method="post">
        {{csrf_field()}}
      <div class="modal-body">
            <input type="text" name="texto" class="form-control" placeholder="  {{__('messages.escribir_una_tarea')}}">

      </div>

      <div class="modal-footer">
      <input type="submit" class="btn btn-primary" value="  {{__('messages.salvar')}}">
      </div>
      </form>
    </div>
  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="text-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crear">
                  <i class="fa fa-plus"></i>
            </button>
          </div>

          <div class="panel panel-default">
                <div class="panel-heading">{{__('messages.mis_tareas')}}</div>

                <div class="panel-body">
                  <table class="table">

                    @forelse ($tareas as $tarea)
                    @if ($tarea->estado==='En proceso')
                      <tr class="success">
                    @elseif ($tarea->estado==='Completada')
                      <tr class="info">
                    @else
                        <tr>
                    @endif
                      <td>{{$tarea->texto}}</td>
                     <td>
                        @if ($tarea->estado==='Pendiente')
                            {{__('messages.pendiente')}}
                        @elseif ($tarea->estado===" En proceso")
                              {{__('messages.en_proceso')}}
                        @else
                            {{__('messages.completada')}}
                        @endif
                      </td>





                      <td class="text-right">
                        @if ($tarea->estado==='Pendiente')
                          <a href="{{route ('cambiar.estado',[$tarea->id,1])}}" class="btn btn-warning btn-xs"><i class="fa fa-play fa-fw"></i></a>
                        @endif
                        @if ($tarea->estado==='En proceso')
                          <a href="{{route('cambiar.estado',[$tarea->id,2])}}" class="btn btn-success btn-xs"><i class="fa fa-check fa-fw"></i></a>
                        @endif
                        <a href="{{route('eliminar.tarea',[$tarea->id])}}" class="btn btn-danger btn-xs"><i class="fa fa-trash fa-fw"></i></a>
                      </td>



                    </tr>
                    @empty
                     <h3>No hay tareas para mostrar</h3>
                    @endforelse
                  </table>
                </div>
            </div>
            <div class="text-center">
                {{$tareas->links()}}  {{-- indicadores de paginacion --}}
            </div>
        </div>
    </div>
</div>
@endsection
