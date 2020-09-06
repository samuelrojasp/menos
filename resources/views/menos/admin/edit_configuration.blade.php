@extends('appshell::layouts.default')

@section('title')
    {{ __('Editar Configuración') }}
@stop
@section('content')
    <h2>Editar Configuración</h2>
    <form action="/administracion/configuraciones/{{ $configuration->id }}" method="post"> 
        @method('PUT')
        @csrf
        <div class="card col-md-6">
            <br />
            <div class="form-group">
                <label for="activity_type">Nombre de la configuracion</label>
                <input type="text" name="key" class="form-control" value="{{ $configuration->key }}" required />
            </div>
            <div class="form-group">
                <label for="notes">Valor</label>
                <input type="text" name="value" class="form-control" value="{{ $configuration->value }}" required />
            </div>
            <a href="/administracion/configuraciones" class="btn btn-secondary">Volver</a>
            <br />
            <button type="submit" class="btn btn-primary">Guardar Configuración</button>
            <br />
        </div>
    </form>
@endsection