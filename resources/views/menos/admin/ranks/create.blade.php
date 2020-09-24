@extends('appshell::layouts.default')

@section('title')
    {{ __('Nueva Configuración') }}
@stop
@section('content')
    <h2>Nuevo Rango</h2>
    <form action="/administracion/rangos" method="post">
        @csrf
        <div class="card col-md-6">
            <br />
            <div class="form-group">
                <label for="activity_type">Nombre</label>
                <input type="text" name="name" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="required_rank_id">Rango Asociados Req.</label>
                <select class="form-control" name="required_rank_id">
                    <option disabled selected>Sin rangos requeridos</option>
                    @foreach($ranks as $rank)
                    <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="required_rank_count">Nº Asociados Req.</label>
                <input class="form-control" type="number" name="required_rank_count" />
            </div>
            <div class="form-group">
                <label for="team_bonus_required_consumption">Compra Mensual Eq. Inferior</label>
                <input class="form-control" type="number" name="team_bonus_required_consumption" />
            </div>
            <div class="form-group">
                <label for="required_consumption">Consumo Requerido</label>
                <input class="form-control" type="number" name="required_consumption" />
            </div>
            <div class="form-group">
                <label for="rank_bonus">Monto Bono Rango</label>
                <input class="form-control" type="number" name="rank_bonus" />
            </div>
            <div class="form-group">
                <label for="leadership_generation">Generación Pago Bono Liderazgo</label>
                <input class="form-control" type="number" name="leadership_generation" />
            </div>
            <div class="form-group">
                <label for="leadership_percentage">% pagado bono liderazgo</label>
                <input class="form-control" type="number" name="leadership_percentage" />
            </div>
            <div class="form-group">
                <label for="rank_level">Nivel del Rango</label>
                <input class="form-control" type="number" name="rank_level" />
            </div>
            <div class="form-group">
                <label for="background">Color de Fondo</label>
                <input class="form-control" type="text" name="background" />
            </div>
            <div class="form-group">
                <label for="color">Color de texto</label>
                <input class="form-control" type="text" name="color" />
            </div>
            
            <a href="/administracion/rangos" class="btn btn-secondary">Volver</a>
            <br />
            <button type="submit" class="btn btn-primary">Guardar Rango</button>
            <br />
        </div>
    </form>
@endsection