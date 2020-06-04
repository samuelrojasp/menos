@extends('menos.layouts.app')



@section('content')
<div class="container ">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Saldo Cuenta de Inversión</div>
                    <div class="card-body">
                        <h1 class="text-right">$ 0</h1>
                    </div>
                </div>
            </div>
    </div>
    <br />
    <div class="row justify-content-center">
            
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Historial</h3>
                    <small>Últimos 5 movimientos</small>
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
                                @forelse($c->movimientos->sortByDesc('created_at')->take(5) as $m)
                                    <tr>
                                        <td class="text-center">{{ $m->human_date }}</td>
                                        <td class="text-center">{{ $m->human_hour }}</td>
                                        <td>{{$m->glosa}}</td>
                                        <td class="text-right">{{ number_format($m->importe, 0, ',', '.')}}</td>
                                        <td class="text-right">{{ number_format($m->saldo_cuenta, 0, ',', '.')}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">No hay movimientos en su cuenta</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
