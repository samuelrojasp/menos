@extends('appshell::layouts.default')

@section('title')
    {{ __('Rangos') }}
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary" href="/administracion/rangos/create">Nuevo rango</a>
                    <br />
                    <br />
                    <table class="table table-hover table-condensed">
                        <tr>
                            <th>Nombre</th>
                            <th>Rango Asociados Req.</th>
                            <th>Nº Asociados Req.</th>
                            <th>Compra Mensual Eq. Inferior</th>
                            <th>Consumo Requerido</th>
                            <th>Monto Bono Rango</th>
                            <th>Generación Pago Bono Liderazgo</th>
                            <th>% pagado bono liderazgo</th>
                            <th>Nivel del Rango</th>
                            <th>Acciones</th>
                        </tr>

                        @forelse($ranks as $rank)
                        <tr>
                            <th class="text-nowrap" style="{{ 'background: '.$rank->background.'; ' ?? '' }}{{ 'color: '.$rank->color.';' ?? '' }}">{{ $rank->name }}</th>
                            <td>{{ $rank->required_rank->name ?? "" }}</td>
                            <td class="text-right">{{ $rank->required_rank_count }}</td>
                            <td class="text-right">{{ number_format($rank->team_bonus_required_consumption, 0, ',','.') }}</td>
                            <td class="text-right">{{ number_format($rank->required_consumption, 0, ',','.') }}</td>
                            <td class="text-right">{{ number_format($rank->rank_bonus, 0, ',','.') }}</td>
                            <td class="text-center">{{ $rank->leadership_generation }}</td>
                            <td class="text-center">{{ $rank->leadership_percentage }}</td>
                            <td class="text-center">{{ $rank->rank_level}}</td>
                            <td>Acciones</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10">No hay rangos</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
