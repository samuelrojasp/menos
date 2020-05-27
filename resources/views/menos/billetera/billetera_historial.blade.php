@extends('menos.layouts.app')



@section('content')
<div class="container">
    <h1 class="text-center">Historial</h1>
    <div class="row justify-content-center">     
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @foreach($cuentas as $c)
                        
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Hora</th>
                                    <th class="text-center">Glosa </th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-center">Saldo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($c->movimientos->sortByDesc('created_at') as $m)
                                    <tr>
                                        <td class="text-center">{{ $m->human_date }}</td>
                                        <td class="text-center">{{ $m->human_hour }}</td>
                                        <td>{{$m->glosa}}</td>
                                        <td class="text-right">{{ number_format($m->importe, 0, ',', '.')}}</td>
                                        <td class="text-right">{{ number_format($m->saldo_cuenta, 0, ',', '.')}}</td>
                                        <td class="text-center"><a href="#">Ver</a></td>
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
