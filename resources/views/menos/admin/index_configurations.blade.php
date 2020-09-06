@extends('appshell::layouts.default')

@section('title')
    {{ __('Configuraciones') }}
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary" href="/administracion/configuraciones/create">Nueva configuración</a>
                    <br />
                    <br />
                    <table class="table table-hover">
                        <tr>
                            <th>Fecha configuracion</th>
                            <th>Clave</th>
                            <th>Valor</th>
                            <th>Acciones</th>
                        </tr>

                        @forelse($configurations as $configuration)
                        <tr>
                            <td>{{ date('d-m-Y', strtotime($configuration->created_at)) }}</td>
                            <td>{{ $configuration->key }}</td>
                            <td>{{ $configuration->value }}</td>
                            <td>
                                <a class="btn btn-primary" href="/administracion/configuraciones/{{ $configuration->id }}/edit">editar</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No hay configuraciones</td>
                        </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
