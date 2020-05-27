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
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select name="phonecode" id="phonecode">
                                        @foreach( $countries as $country )
                                        <option value="{{ $country->phonecode }}" {{ $country->phonecode == '56' ? 'selected' : '' }}>+{{ $country->phonecode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input id="telephone" type="tel" placeholder="" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="" required autocomplete="telephone">                      
                            </div>
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
