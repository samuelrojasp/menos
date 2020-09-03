@extends('menos.office.app')

@section('content')
    <h2>Prospectos</h2>
    <br />
    <a href="/business/prospectos/create" class="btn btn-primary">Invitar nuevo Prospecto</a>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Teléfono</th>
            
            <th>Acciones</th>
        </tr>
        @forelse($prospectos as $prospecto)
        <tr>
            <td>{{ $prospecto->name }}</td>
            <td>{{ $prospecto->email }}</td>
            <td>{{ $prospecto->telephone }}</td>
            
        <td>
            <a class="btn btn-primary" href="/business/prospectos/{{ $prospecto->id }}/actividades-de-prospectos">Registro de actividades</a>
        </td>
        </tr>
        @empty
        <tr>
            <td>No tienes prospectos</td>
        </tr>
        @endforelse
    </table>
@endsection