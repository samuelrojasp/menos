@extends('menos.office.app')

@section('content')
    <h2>Nuevo Registro de Actividad</h2>
    <form action="/business/prospectos/{{ $prospect->id }}/actividades-de-prospectos" method="post">
        @csrf
        <input type="hidden" name="prospect_id" value="{{ $prospect->id }}" />
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
        <div class="card col-md-6">
            <br />
            <div class="form-group">
                <label for="activity_type">Nombre</label>
                <select class="form-control" name="type" required>
                    @foreach(config('menos.mlm_settings.prospect_activity_type') as $key => $type)
                    <option value="{{ $key }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="notes">Notas</label>
                <textarea class="form-control" required name="notes"></textarea>
            </div>
            <a href="/business/prospectos{{ $prospect->id }}/actividades-de-prospectos" class="btn btn-secondary">Volver</a>
            <br />
            <button type="submit" class="btn btn-primary">Registrar Actividad</button>
            <br />
        </div>
    </form>
@endsection