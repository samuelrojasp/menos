@extends('appshell::layouts.default')

@section('title')
    {{ __('Comisiones') }}
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary" href="/administracion/comisiones/create">Nuevo Bono</a>
                    <br />
                    <br />
                    <table class="table table-hover table-condensed">
                        <tr>
                            <th>Nombre</th>
                            <th>Requerimientos</th>
                            <th>Rango Mínimo</th>
                            <th>Detalles</th>
                            <th>Forma de Pago</th>
                            <th>Método de Cálculo</th>
                            <th>Acciones</th>
                        </tr>

                        @forelse($bonuses as $bonus)
                        <tr>
                            <th class="text-nowrap">{{ $bonus->name }}</th>
                            <td>{{ $bonus->requirements }}</td>
                            <td class="text-right">{{ $bonus->rank->name }}</td>
                            <td class="text-center">{{ $bonus->bonus_details }}</td>
                            <td class="text-center">{{ $bonus->bonus_payment }}</td>
                            <td class="text-center">{{ $bonus->calc_method }}</td>
                            <td>Editar</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">No hay comisiones</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
