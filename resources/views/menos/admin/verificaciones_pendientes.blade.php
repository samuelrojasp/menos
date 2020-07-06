@extends('appshell::layouts.default')

@section('title')
    {{ __('Verificación Identidad') }}
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th>Fecha Solicitud</th>
                            <th>Usuario</th>
                            <th>RUT</th>
                            <th>Estado</th>
                            <th>Verificador</th>
                            <th>Fecha Aprobacion</th>
                            <th>Acciones</th>
                        </tr>
                        @forelse($verificaciones as $verificacion)
                        <tr>
                            <td>{{ $verificacion->created_at }}</td>
                            <td>{{ $verificacion->user->name }}</td>
                            <td>{{ $verificacion->user->rut }}</td>
                            <td>
                                @if($verificacion->verificada_id != null && $verificacion->verified_at == null)
                                <span class="text-danger">Rechazada</span>
                                @elseif($verificacion->verificada_id == null && $verificacion->verified_at == null)
                                <span class="text-primary">Pendiente</span>
                                @else
                                <span class="text-success">Aprobada</span>
                                @endif
                            </td>
                            <td>
                                {{ $verificacion->verificador ? $verificacion->verificador->name : "" }}
                            </td>
                            <td>
                                {{ $verificacion->verified_at ?? "" }}
                            </td>
                            <td>
                                @if($verificacion->verified_at == null && $verificacion->verificada_id == null)
                                <a href="/administracion/verifica_identidad/{{ $verificacion->id }}/edit">Verificar</a>
                                @else
                                <a href="/administracion/verifica_identidad/{{ $verificacion->id }}">Ver</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No hay verificaciones pendientes</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
