@extends ('layouts.app')
@section('content')
<div class="container">
<a href="{{url('/empleados/create')}}" class="btn btn-success"> Registrar Nuevo Empleado</a>
{{-- // rcibe la funcion mensaje desde el controler para mostrar para mostrara un mensaje de confirmacion --}}
@if(Session::has('mensaje'))
<div class="alert alert-success alert-dismissible" role="alert">
{{Session::get('mensaje')}}
</div>
@endif

<table class="table table-striped">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>P. Apellido</th>
            <th>S. Apellido</th>
            <th>Correo</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $datos)
        <tr>
            <td>{{$datos->id}}</td>
            <td><img src="{{asset('storage').'/'.$datos->Foto}}" alt="100" width="100"></td>
            <td>{{$datos->Nombres}}</td>
            <td>{{$datos->PrimerApel}}</td>
            <td>{{$datos->SegundoApel}}</td>
            <td>{{$datos->Correo}}</td>
            <td>
                <a href="{{url('/empleados/'.$datos->id.'/edit')}}" class="btn btn-warning">Editar</a>
                ┃
                <form action="{{url('/empleados/'.$datos->id)}}" method="POST">
                    @csrf
                    {{method_field('DELETE')}}
                    <input type="submit" onclick="return confirm('¿Deseas Eliminar?')"  class="btn btn-danger" value="Eliminar">
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $empleados->Links() !!}
</div>
@endsection
