@extends ('layouts.app')
@section('content')
<div class="container">
<a href="{{url('/empleados')}}" class="btn btn-danger">Regresar</a>
<form action="{{url('/empleados/'.$empleado->id)}}" method="post" enctype="multipart/form-data">
@csrf
{{method_field('PATCH')}}
@include('empleados.form', ['modo'=>'Actiualizar']);
</form>
</div>
@endsection
