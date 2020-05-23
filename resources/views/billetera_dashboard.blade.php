@extends('layouts.app')

@section('menu')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a href="/admin2/dashboard" class="nav-link text-secondary">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/depositar" class="nav-link">Depositar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/transferir" class="nav-link">Transferir</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/retirar" class="nav-link">Retirar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/comprar" class="nav-link">Comprar (SOLO PRUEBAS)</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/historial" class="nav-link">Historial</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/tipos_cuenta" class="nav-link">Tipos Cuentas</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/tipos_transaccion" class="nav-link">Tipos Transacción</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
            @foreach($cuentas as $cuenta)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Saldo {{$cuenta->nombre}}</div>
                    <div class="card-body">
                        <h1 class="text-right">$ {{ number_format($cuenta->saldo, 0, ',', '.') }}</h1>
                    </div>
                </div>
            </div>
            @endforeach

            <br><br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Ultimos Movimientos</div>

                <div class="card-body">
                    @foreach($cuentas as $c)
                        
                        <strong>Movimientos cuenta {{ $c->nombre }}</strong>
                        <table class="table-responsive table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Glosa </th>
                                    <th>Monto</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($c->movimientos as $m)
                                    <tr>
                                        <td>{{$m->created_at}}</td>
                                        <td>{{$m->glosa}}</td>
                                        <td class="text-right">{{ number_format($m->importe, 0, ',', '.')}}</td>
                                        <td class="text-right">{{ number_format($m->saldo_cuenta, 0, ',', '.')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
