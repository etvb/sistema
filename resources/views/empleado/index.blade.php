@extends('layouts.app')
@section('content')
<div class="container ">

  @if(Session::has('mensaje'))
  <div class="alert alert-warning alert-dismissible" role="alert">
    {{Session::get('mensaje')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  @endif
  
  </div>

  <a class="btn btn-success mb-2 ml-5" href="{{url('empleado/create')}} ">Nuevo Usuario</a>
  <table class="table ml-5">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Foto</th>
        <th scope="col">Nombre</th>
        <th scope="col">Apellido Paterno</th>
        <th scope="col">Apellido Materno</th>
        <th scope="col">Correo</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>

    <tbody>
    @foreach($empleados as $empleado)
      <tr>
        <th scope="row">{{$empleado->id}}</th>
        <td>
          <img src="{{ asset('storage').'/'.$empleado->Foto }}" alt="Avatar Usuario" width="100">
        </td>
        <td>{{$empleado->Nombre}}</td>
        <td>{{$empleado->ApellidoPaterno}}</td>
        <td>{{$empleado->ApellidoMaterno}}</td>
        <td>{{$empleado->Correo}}</td>
        <td>
        <a class="btn btn-success" href="{{ url('empleado/'.$empleado->id.'/edit') }}">editar</a>
        
          <form class="d-inline" action="{{url('/empleado/'.$empleado->id)}}" method="post">
          @csrf
          <!-- {{ method_field('DELETE') }} -->
          @method('DELETE')
            <input class="btn btn-danger" type="submit" value="Borrar" onclick="return confirm('¿Quieres Borrar?')">
          </form>
        
        
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
  @endsection

