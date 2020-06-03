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
                            <label for="importe">Indique el monto a transferir (disponible: {{ number_format($cuenta->saldo, 0, ',', '.') }})</label>
                            <input type="number" max="{{ $cuenta->saldo }}" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <label for="user_id">Indique el número del usuario al que quiere transferir</label>
                            
                                
                            <input id="phone" type="tel" placeholder="ej. 912345678" class="form-control @error('telephone') is-invalid @enderror" name="phone" value="" required>                      
                            
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
