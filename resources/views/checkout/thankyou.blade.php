@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Todos los Productos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Carrito</a></li>
    <li class="breadcrumb-item">Pagar</li>
    <li class="breadcrumb-item">Orden Completa</li>

@stop

@section('content')
    <div class="container">
        <h1>Muchas Gracias, {{ $order->getBillpayer()->firstname }}!</h1>
        <hr>

        <div class="alert alert-success">Tu orden se ha registrado con el número
            <strong>{{ $order->getNumber() }}</strong>.
        </div>

        <h3>Siguientes Pasos</h3>

        <ol>
            <li>Tu orden sera preparada en las siguientes 24 horas.</li>
            <li>Tu envío será entregado al courier.</li>
            <li>Recibirás un E-mail con el con la información del envío.</li>
        </ol>

        <div>
            <a href="{{ route('product.index') }}" class="btn btn-info">¡Muy Bien!</a>
        </div>

    </div>
@endsection
