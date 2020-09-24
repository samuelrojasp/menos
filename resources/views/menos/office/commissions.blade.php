@extends('menos.office.app')

@section('content')
    <h2>Tabla de las comisiones</h2>
    <br />
    <table class="table table-responsive table-hover table-condensed">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Requisitos</th>
                <th>Rango Mínimo</th>
                <th>Comisión</th>
                <th>Forma de Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bonuses as $bonus)
            <tr>
                <th class="text-nowrap">{{ $bonus->name }}</th>
                <td>{{ $bonus->requirements }}</td>
                <td>{{ $bonus->rank->name }}</td>
                <td>{{ $bonus->bonus_details }}</td>
                <td>{{ $bonus->bonus_payment }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br />
    <h2>Tabla de Rangos</h2>
    <br />
    <table class="table table-bordered table-condensed table-hover table-responsive">
        <thead>
            <tr>
                <th class="text-center" rowspan="2">Rango</th>
                <th class="text-center" colspan="7">Asociados Mínimos con Rango</th>
                <th class="text-center text-vertical" rowspan="2">Consumo equipo puntaje inferior</th>
                <th class="text-center text-vertical" rowspan="2">Monto Bono Rango</th>
                <th class="text-center" colspan="2">Bono Generacion</th>
                <th class="text-center text-vertical" rowspan="2">Consumo mínimo para estar activo</th>
            </tr>
            <tr>
                @foreach($rank_names as $rank_name)
                <th>{{ $rank_name->name }}</th>
                @endforeach
                <th>Generacion</th>
                <th>%</th>
            </tr>

        </thead>
        <tbody>
            @foreach($ranks as $rank)
            <tr>
                <th class="text-nowrap" style="{{ 'background: '.$rank->background.'; ' ?? '' }}{{ 'color: '.$rank->color.';' ?? '' }}">
                    {{ $rank->name}}
                </th>
                @foreach($rank_names as $rank_name)
                <td class="text-center">
                    {{ $rank_name->id == $rank->required_rank_id ? $rank->required_rank_count : '' }}
                </td>
                @endforeach
                <td class="text-right text-nowrap">{{ '$ '.number_format($rank->team_bonus_required_consumption, 0, ',','.') }}</td>
                <td class="text-right text-nowrap">{{ '$ '.number_format($rank->rank_bonus, 0, ',','.') }}</td>
                <td class="text-center">{{ $rank->leadership_generation }}</td>
                <td class="text-center">{{ $rank->leadership_percentage }}</td>
                <td class="text-right text-nowrap">{{ '$ '.number_format($rank->required_consumption, 0, ',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <style>
        .text-vertical{
            writing-mode: vertical-rl;
            text-orientation: mixed;
        }
    </style>
@endsection