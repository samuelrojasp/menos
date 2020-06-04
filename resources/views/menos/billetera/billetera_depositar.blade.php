@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Cargar Saldo</h1>
    <div class="row justify-content-center">
           
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/billetera/confirmar_carga">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a abonar a la cuenta</label>
                            <input type="number" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <label for="cuenta_id">Indique la cuenta que cargará</label>
                            <select class="form-control" name="cuenta_id" id="cuenta_id">
                                @foreach($usuario->cuentas as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                @endforeach
                                <option disabled>Cuenta de inversión</option>
                            </select>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label for="n_tarjeta_credito">Indique el Nº de Tarjeta de Crédito</label>
                            <input type="number" class="form-control" id="n_tarjeta_credito" name="n_tarjeta_credito" placeholder="4321 4321 4321 4321" />
                        </div>
                        <div class="form-group">
                            <label for="nombre_tarjeta_credito">Titular de la tarjeta</label>
                            <input type="text" class="form-control" id="nombre_tarjeta_credito" name="nombre_tarjeta_credito" />
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="v_tarjeta_credito"><small>Fecha Venc.</small></label>
                                <input type="text" class="form-control" id="v_tarjeta_credito" name="v_tarjeta_credito" placeholder="08/25" />
                            </div>
                            <div class="form-group col-md-3">
                                <label for="cvv_tarjeta_credito"><small>CVV</small></label>
                                <input type="password" maxlength="3" minlength="3" class="form-control" id="cvv_tarjeta_credito" name="cvv_tarjeta_credito" />
                            </div>
                        </div>
                        <a href="/billetera/resumen" class="btn btn-default">Cancelar </a>
                        <input type="submit" class="btn btn-primary" value="Cargar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
