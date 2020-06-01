@extends('menos.layouts.app')



@section('content')
<div class="container">
    <h1 class="text-center">Historial</h1>
    <div class="row justify-content-center">     
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">
                    @foreach($cuentas as $c)
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo" role="tab" aria-controls="home" aria-selected="true">Todo</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="abonos-tab" data-toggle="tab" href="#abonos" role="tab" aria-controls="abonos" aria-selected="false">Abonos</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="cargos-tab" data-toggle="tab" href="#cargos" role="tab" aria-controls="cargos" aria-selected="false">Cargos</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="todo" role="tabpanel" aria-labelledby="home-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Glosa </th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Saldo</th>
                                        <th class="text-center">Codigo Transacción</th>
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
                                            <td class="text-center"><a href="#">{{ base_convert($m->transaccion->id.$m->transaccion->created_at, 10, 36) }}</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">No hay movimientos en su cuenta</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade show" id="abonos" role="tabpanel" aria-labelledby="abonos-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Glosa </th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Codigo Transacción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($c->movimientos->where('cargo_abono','abono')->sortByDesc('created_at') as $m)
                                        <tr>
                                            <td class="text-center">{{ $m->human_date }}</td>
                                            <td class="text-center">{{ $m->human_hour }}</td>
                                            <td>{{$m->glosa}}</td>
                                            <td class="text-right">{{ number_format($m->importe, 0, ',', '.')}}</td>
                                            <td class="text-center"><a href="#">{{ base_convert($m->transaccion->id.$m->transaccion->created_at, 10, 36) }}</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">No hay movimientos en su cuenta</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade show" id="cargos" role="tabpanel" aria-labelledby="cargos-tab">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Glosa </th>
                                        <th class="text-center">Monto</th>
                                        <th class="text-center">Codigo Transacción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($c->movimientos->where('cargo_abono','cargo')->sortByDesc('created_at') as $m)
                                        <tr>
                                            <td class="text-center">{{ $m->human_date }}</td>
                                            <td class="text-center">{{ $m->human_hour }}</td>
                                            <td>{{$m->glosa}}</td>
                                            <td class="text-right">{{ number_format($m->importe, 0, ',', '.')}}</td>
                                            <td class="text-center"><a href="#">{{ base_convert($m->transaccion->id.$m->transaccion->created_at, 10, 36) }}</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="5">No hay movimientos en su cuenta</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
