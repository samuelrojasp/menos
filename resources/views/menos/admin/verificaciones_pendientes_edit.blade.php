@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Validar Identificacion</h2>
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ $verificacion->user->name }}</p>
                    <p><strong>RUT:</strong> {{ $verificacion->user->rut }}</p>
                    <p><strong>Alta del Usuario:</strong> {{ $verificacion->user->created_at }}</p>
                    <p><strong>Fecha Solicitud:</strong> {{ $verificacion->created_at }}</p>
                    <p><strong>Archivos</strong>
                        @forelse($verificacion->identificacionMedia as $media)
                        <img src="https://storage.cloud.google.com/menos/{{ $media->media->filename }}" width="250" />
                        @empty
                        <div class="alert alert-info">sin archivos</div>
                        @endforelse
                    </p>
                    <form method="POST" action="/administracion/verifica_identidad/{{ $verificacion->id }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            
                            <input type="checkbox" name="verificado" id="verificado" />
                            <label for="verificado">Marcar como verificado</label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Motivo" />
                        </div>
                        <input type="submit" value="Enviar" class="btn btn-success" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
