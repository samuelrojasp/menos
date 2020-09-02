@extends('menos.office.app')

@section('content')
<h2>Registro de actividades</h2>
<h3>Nombre prospecto: {{ $prospect->name }}</h3>
    <br />
    <a class="btn btn-primary" href="/business/prospectos/{{ $prospect->id }}/actividades-de-prospectos/create">Registrar de actividad</a>
    <br />
    <table class="table">
        <tr>
            <th>Tipo Actividad</th>
            <th>Notas</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
        @forelse($prospect->prospect_activities as $activity)
        <tr>
            <td>{{ config('menos.mlm_settings.prospect_activity_type')[$activity->type] }}</td>
            <td>{{ $activity->notes }}</td>
            <td>{{ $activity->created_at }}</td>
            
            <td></td>
        </tr>
        @empty
        <tr>
            <td>No hay actividad</td>
        </tr>
        @endforelse
    </table>
@endsection