@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <h2>Actualizar Topico</h2>
        <hr>
        <form action="/topicos/{{$topico->id}}" method="post" enctype="multipart/form-data" class="col-lg-7">
        <!-- Protección contra ataques ya implementado en laravel
        https://www.welivesecurity.com/la-es/2015/04/21/vulnerabilidad-cross-site-request-forgery-csrf/-->
        @csrf
        @method('PUT')
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
            <label for="title">Actualizar Título</label>
            <input type="text" class="form-control" id="title" name="topico_titulo" value="{{ $topico->topico_titulo }}" />
        </div>
        <div class="form-group">
            <label for="contenido">Actualizar Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido">{{ $topico->contenido }}</textarea>
        </div>
        <a href="/videos" type="submit" class="btn btn-danger">Cancelar</a>
        <button type="submit" class="btn btn-success">Actualizar Topico</button>
        </form>
    </div>
</div>
@endsection
