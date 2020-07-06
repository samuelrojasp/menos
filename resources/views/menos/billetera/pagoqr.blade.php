@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Pago por QR</h1>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/billetera/generarQR">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a transferir (disponible: {{ number_format($cuenta->saldo, 0, ',', '.') }})</label>
                            <input type="number" max="{{ $cuenta->saldo }}" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password" name="password" id="password" placeholder="PIN 4 dígitos" />
                        </div>
                        <a href="#" class="btn btn-secondary">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Generar QR">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
