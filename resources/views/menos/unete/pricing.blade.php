@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="#">Business</a></li>
    <li class="breadcrumb-item">Únete</li>
@stop

@section('content')

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Únete</h1>
    <p class="lead">Suscríbete a nuestro sistema de recompensas y funcionalidades de la cuenta premium</p>
  </div>

  <div class="container">
    <div class="card-deck mb-3 text-center">
      <div class="card mb-4 box-shadow">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">Gratis</h4>
        </div>
        <div class="card-body">
          <h1 class="card-title pricing-card-title">$0 <small class="text-muted"></small></h1>
          <ul class="list-unstyled mt-3 mb-4">
            <li>Billetera Digital</li>
            <li>Transferencias</li>
            <li>Pago QR</li>
            <li>Delibery Cash</li>
            <li>Compras en nuestra tienda</li>
          </ul>
          <!--button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button-->
        </div>
      </div>
      
      <div class="card mb-4 box-shadow">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">Afiliado</h4>
        </div>
        <div class="card-body">
          <h1 class="card-title pricing-card-title">$ {{ number_format($subscription_value, 0, ',', '.') }} <small class="text-muted"></small></h1>
          <ul class="list-unstyled mt-3 mb-4">
            <li>Invita a otros usuarios</li>
            <li>Atractivo sistema de comisiones</li>
            <li>Tu propia tienda en linea</li>
            <li>Herramientas de marketing avanzado</li>
          </ul>
          <a href="plan-checkout{{ isset($prospecto) ? '?prospecto='.$prospecto : "" }}" class="btn btn-lg btn-block btn-primary">Comprar</a>
        </div>
      </div>
     
    </div>
@endsection