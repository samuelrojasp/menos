@extends('menos.office.app')

@section('content')
    <h2>Prospectos</h2>
    <br />
    <a href="/business/prospectos/create" class="btn btn-primary">Invitar nuevo Prospecto</a>
    <table class="table">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            
            <th>Acciones</th>
        </tr>
        @forelse($prospectos as $prospecto)
        <tr>
            <td>{{ $prospecto->name }}</td>
            <td>{{ $prospecto->email }}</td>
            
            <td>Enviar e-mail</td>
        </tr>
        @empty
        <tr>
            <td>No tienes prospectos</td>
        </tr>
        @endforelse
    </table>
@endsection