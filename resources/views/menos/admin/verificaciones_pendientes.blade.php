@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Verificaciones Pendientes</h2>
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Perfil</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Fecha Solicitud</th>
                            <th>Usuario</th>
                            <th>RUT</th>
                            <th>Acciones</th>
                        </tr>
                        @forelse($verificaciones as $verificacion)
                        <tr>
                            <td>{{ $verificacion->created_at }}</td>
                            <td>{{ $verificacion->user->name }}</td>
                            <td>{{ $verificacion->user->rut }}</td>
                            <td>
                                <a href="/administracion/verifica_identidad/{{ $verificacion->id }}/edit" class="btn btn-primary">Ver</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan=4>No hay verificaciones pendientes</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
