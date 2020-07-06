@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Retirar</h1>   
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/billetera/confirmar_retiro">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a retirar</label>
                            <input type="number" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <label for="cuenta_id">Cuenta desde donde se retira</label>
                            <select class="form-control" name="cuenta_id" id="cuenta_id">
                                @foreach($usuario->cuentas as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }} (disponible: $ {{ number_format($c->saldo, 0, ',', '.') }})</option>
                                <option disabled>Cuenta de Inversión (disponible: $ 0)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="forma_retiro" id="forma_retiro">
                                @foreach($cuentas_bancarias as $cuenta_bancaria)
                                <option value="{{$cuenta_bancaria->id}}">{{ $cuenta_bancaria->banco->nombre." Nº ".$cuenta_bancaria->numero_cuenta }}</option>
                                @endforeach
                                <option disabled>Deliveri Cash (próximamente)</option>
                            </select>
                        </div>
                        <br />
                        <input type="submit" class="btn btn-primary" value="Retirar">
                        <a href="/billetera/resumen" class="btn btn-secondary">Cancelar </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
