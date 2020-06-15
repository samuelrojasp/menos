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
                    <p><strong>Estado:</strong> {{ $verificacion->verified_at==null ? 'Rechazada' : 'Aprobada' }}</p>
                    <p><strong>Revisor:</strong> {{ $verificacion->verificador->name }}</p>
                    <p><strong>Notas:</strong> {{ $verificacion->descripcion }}</p>
                    <p><strong>Archivos</strong>
                        @forelse($verificacion->identificacionMedia as $media)
                        <img src="{{ Storage::url($media->media->filename) }}" width="250" />
                        @empty
                        <div class="alert alert-info">sin archivos</div>
                        @endforelse
                    </p>
                    
                    <a href="/administracion/verifica_identidad" class="btn btn-secondary">Volver</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
