@extends('appshell::layouts.default')

@section('title')
    {{ __('Verificación Transacciones') }}
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Fecha transaccion</th>
                            <th>Usuario</th>
                            <th>RUT</th>
                            <th>Monto</th>
                            <th>Status</th>
                            <th>Verificado por</th>
                            <th>Fecha Aprobacion</th>
                            <th>Acciones</th>
                        </tr>

                        @forelse($transacciones as $transaccion)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($transaccion->created_at)) }}</td>
                            <td>{{ $transaccion->user['name'] }}</td>
                            <td>{{ $transaccion->user['rut'] }}</td>
                            <td class="text-right">
                                {{ number_format($transaccion->movimientos->pluck('importe')->first(), '0', ',', '.') }}
                            </td>
                            <td>
                                @if($transaccion->verified_at == null)
                                <span class="text-warning">Pendiente</span>
                                @else
                                <span class="text-success">Verificada</span>
                                @endif
                            </td>
                            <td>
                                {{ $transaccion->verified_by ? $transaccion->verified_by : "" }}
                            </td>
                            <td>
                                {{ $transaccion->verified_at ? date('d-m-Y', strtotime($transaccion->verified_at)) : "" }}
                            </td>
                            <td>
                                @if($transaccion->verified_at == null)
                                <form action="/administracion/verifica_transaccion/{{ $transaccion->id }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="submit" class="btn btn-primary" value="Verificar" />
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No hay transacciones</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
