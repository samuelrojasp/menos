@extends('menos.layouts.app')



@section('content')
<div class="container">
    <div class="row">
            @foreach($cuentas as $cuenta)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Saldo {{$cuenta->nombre}}</div>
                    <div class="card-body">
                        <h1 class="text-right">$ {{ number_format($cuenta->saldo, 0, ',', '.') }}</h1>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
    <br />
    <div class="row">
            
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Historial</h3>
                </div>

                <div class="card-body">
                    @foreach($cuentas as $c)
                        
                        <strong>{{ $c->nombre }}</strong>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Hora</th>
                                    <th class="text-center">Glosa </th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-center">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($c->movimientos->sortByDesc('created_at') as $m)
                                    <tr>
                                        <td class="text-center">{{ $m->human_date }}</td>
                                        <td class="text-center">{{ $m->human_hour }}</td>
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
