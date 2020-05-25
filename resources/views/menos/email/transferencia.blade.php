@extends('menos.email.layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1>Transferencia exitosa</h1>
        </div>
        <div class="card-body">
            @foreach($transaccion->movimientos as $m)
            <code>@json($m)</code>
            @endforeach
        </div>
    </div>
</div>
@endsection