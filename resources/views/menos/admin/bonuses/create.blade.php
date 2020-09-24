@extends('appshell::layouts.default')

@section('title')
    {{ __('Nueva Comisión') }}
@stop
@section('content')
    <form action="/administracion/comisiones" method="post">
        @csrf
        <div class="card col-md-6">
            <br />
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" class="form-control" required />
            </div>
            <div class="form-group">
                <label for="requirements">Requisitos</label>
                <textarea class="form-control" name="requirements" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="rank_id">Rango Mínimo</label>
                <select class="form-control" name="rank_id">
                    <option disabled selected>Sin rangos requeridos</option>
                    @foreach($ranks as $rank)
                    <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="bonus_details">Detalles del bono</label>
                <textarea class="form-control" name="bonus_details" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="bonus_payment">Forma de Pago</label>
                <textarea class="form-control" name="bonus_payment" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="calc_method">Metodo de calculo</label>
                <textarea class="form-control" name="calc_method" cols="30" rows="10" placeholder="Solicitar al superadministrador llenar este campo" disabled></textarea>
            </div>

            <a href="/administracion/comisiones" class="btn btn-secondary">Volver</a>
            <br />
            <button type="submit" class="btn btn-primary">Guardar Bono</button>
            <br />
        </div>
    </form>
@endsection