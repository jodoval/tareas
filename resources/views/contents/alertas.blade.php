
@if (session()->has('msg') && session()->has ('tipoAlert'))
  <div class="container">

    <div class="alert alert-{{session('tipoAlert')}} alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>{{session('msg')}}</strong>
    </div>


</div>

@endif