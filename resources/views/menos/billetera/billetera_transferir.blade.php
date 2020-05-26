@extends('menos.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
           
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Transferir a otro usuario</div>
                <div class="card-body">
                    <form method="post" action="/billetera/transferir">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a transferir (disponible: {{ number_format($cuenta->saldo, 0, ',', '.') }})</label>
                            <input type="number" max="{{ $cuenta->saldo }}" class="form-control" id="importe" name="importe" />
                        </div>
                        <div class="form-group">
                            <label for="user_id">Indique el usuario al que quiere transferir</label>
                            <select class="form-control" name="user_id" id="user_id">
                                <option>Selecciones un usuario...</option>
                                @foreach($usuarios as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
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
