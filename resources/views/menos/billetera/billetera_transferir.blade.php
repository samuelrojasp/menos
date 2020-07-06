@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Transferir</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/billetera/confirmar_transferencia">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a transferir</label>
                            <input type="number" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <label for="cuenta_id">Escoga la cuenta donde quiere debitar</label>
                            <select name="cuenta_id" id="cuenta_id" class="form-control">
                                @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}">{{ $cuenta->nombre }} (saldo: {{ number_format($cuenta->saldo, 0, ',', '.') }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Indique el número del usuario al que quiere transferir</label>
                            <input type="radio" id="selector" name="selector" value="manual" checked>
                            <input id="phone" type="tel" placeholder="ej. 912345678" class="form-control @error('telephone') is-invalid @enderror seleccionable" name="phone" value="" required>
                        </div>

                        <div class="form-group">
                            <label>o seleccione un destinatario reciente</label>
                            <input type="radio" id="selector1"  name="selector" value="autocomplete">
                            <input type="text" id="ultimos" class="form-control" disabled />
                            <input type="hidden" id="user_id" name="user_id" disabled />
                        </div>
                        <a href="#" class="btn btn-default">Cancelar </a>
                        <input type="submit" class="btn btn-primary" value="Transferir">
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
