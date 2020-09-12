@extends('menos.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Perfil</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <tr>
                            <th><strong>Nombre</strong></th>
                            <td>{{ $user->name }}</td>
                        <tr>
                        <tr>
                            <th><strong>Nombre de usuario</strong></th>
                            <td class="text-muted">{{ $user->username }}</td>
                        <tr>
                        <tr>
                            <th><strong>RUT</strong></th>
                            <td>{{ $user->rut }} 
                                @if($verificacion==null)
                                <a href="/mi_cuenta/verifica_identidad">Verificar</a>
                                @elseif($verificacion->verified_at == null && $verificacion->verificada_id == null)
                                <span class="badge badge-warning">En revisión</span>
                                @elseif($verificacion->verified_at == null && $verificacion->verificada_id != null)
                                <span class="badge badge-danger">Verificacion Rechazada</span>
                                <a href="/mi_cuenta/verifica_identidad">Verificar</a>
                                @else
                                <span class="badge badge-success">verificada</span>
                                @endif
                            </td>
                        <tr>
                        <tr>
                            <th><strong>Fecha de nacimiento</strong></th>
                            <td>{{ $user->birthday != null ? date('d-m-Y', strtotime($user->birthday)) : "" }}</td>
                        <tr>
                        <tr>
                            <th><strong>Correo Electrónico</strong></th>
                            <td>{{ $user->email }} 
                                @if($user->email_verified_at != null)
                                    <span class="text-success" title="verificado"><i class="fa fa-check-circle"></i></span>
                                @else
                                <form method="POST" action="/mi_cuenta/mail_confirmacion">
                                    @csrf
                                    <span class="text-warning badge badge-dark" title="no verificado"><i class="fa fa-exclamation-triangle"></i></span> <input class="btn btn-primary btn-sm" value="Verificar" type="submit" />
                                </form>
                                @endif
                                <a href="/mi_cuenta/seguridad">cambiar</a></td>
                        <tr>
                        <tr>
                            <th><strong>Dirección</strong></th>
                            <td>{{ $user->address1 }}</td>
                        <tr>
                        
                        <tr>
                            <th><strong>Teléfono</strong></th>
                            <td>{{ $user->telephone }} <a href="/mi_cuenta/seguridad">cambiar</a></td>
                        <tr>
                    </table>
                    <a href="/mi_cuenta/cambiar_datos" class="btn btn-primary">Cambiar datos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
