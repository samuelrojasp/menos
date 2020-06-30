@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Business</a></li>
    <li class="breadcrumb-item">Únete</li>
    <li class="breadcrumb-item">Gracias</li>
@stop

@section('content')
    <div class="container">
        <h1>Muchas Gracias, {{ $user->name }}!</h1>
        <hr>

        <div class="alert alert-success">Has sido registrado como afiliado de Menos Business</div>

        <h3>Siguientes Pasos</h3>

        <ol>
            <li>Tu afiliación se revisada en las siguientes 24 horas.</li>
        </ol>

        <div>
            <a href="{{ route('product.index') }}" class="btn btn-info">¡Muy Bien!</a>
        </div>

    </div>
@endsection
