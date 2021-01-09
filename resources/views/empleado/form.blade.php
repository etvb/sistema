<h1>{{ $modo }} Usuario </h1>

{{--@if(count($errors)>0)--}}

@if ($errors->any())
  <div class="alert alert-danger" role="alert">
  <ul>
    @foreach($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
  </ul>

  </div>
@endif

<div class="form-group">
  <label  for="Nombre">Nombre</label>
  <input class="form-control" type="text" name="Nombre" value="{{$empleado->Nombre ?? ''}}">
</div>

<div class="form-group">
  <label>Apellido Paterno</label>
  <input class="form-control" type="text" name="ApellidoPaterno" value="{{$empleado->ApellidoPaterno ?? ''}}" >
</div>
  
<div class="form-group">
  <label>Apellido Materno</label>
  <input class="form-control" type="text" name="ApellidoMaterno" value="{{$empleado->ApellidoMaterno ?? ''}}"> 
</div>

<div class="form-group">
  <label>Correo</label>
  <input class="form-control" type="text" name="Correo" value="{{$empleado->Correo ?? ''}}">
</div>  
  
  <label>Foto</label>
  <div>
  @if(isset($empleado->Foto))
    <img src="{{ asset('storage').'/'.$empleado->Foto}}" alt="Avatar Usuario" width="100">
  @endif
  </div>
    <input type="file" name="Foto" >
  <br>
<input class="btn btn-success mt-2" type="submit" value="{{ $modo }}" >

<a class="btn btn-primary mt-2" href="{{ url('empleado') }}">regresar</a>
