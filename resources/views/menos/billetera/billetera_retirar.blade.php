@extends('menos.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
           
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Retirar en efectivo</div>
                <div class="card-body">
                    <form method="post" action="/billetera/retirar">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a retirar (disponible: {{ number_format($cuenta->saldo, 0, ',', '.') }})</label>
                            <input type="number" max="{{ $cuenta->saldo }}" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <label for="cuenta_id">Indique la cuenta donde se deposita este monto</label>
                            <select class="form-control" name="cuenta_id" id="cuenta_id">
                                @foreach($usuario->cuentas as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <a href="#" class="btn btn-default">Cancelar </a>
                        <input type="submit" class="btn btn-primary" value="Retirar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
