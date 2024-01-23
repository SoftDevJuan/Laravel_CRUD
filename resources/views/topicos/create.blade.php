@extends('layouts.app')
@section('content')
<div class="container">
<div class="row">
<h2>Crear un nuevo Post</h2>
<hr>
<form action="{{ route('topicos.store') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
@csrf
@method('POST')

<!-- Protección contra ataques ya implementado en laravel
https://www.welivesecurity.com/la-es/2015/04/21/vulnerabilidad-cross-site-request-forgery-csrf/-->
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<div class="form-group">
<label for="topico_titulo">Título</label>
<input type="text" class="form-control" id="topico_titulo" name="topico_titulo" value="{{ old('topico_titulo') }}" />
</div>
<div class="form-group">
<label for="contenido">Descripción</label>
<textarea class="form-control" id="contenido" name="contenido">{{ old('description') }}</textarea>
</div>
<a href="/home" type="submit" class="btn btn-danger">Cancelar</a>
<button type="submit" class="btn btn-success">Crear Post</button>
</form>
</div>
</div>
@endsection