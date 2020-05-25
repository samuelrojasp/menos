@extends('menos.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
           
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Depositar</div>
                <div class="card-body">
                    <form method="post" action="/billetera/depositar">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a abonar a la cuenta</label>
                            <input type="number" class="form-control" id="importe" name="importe" />
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
                        <input type="submit" class="btn btn-primary" value="Depositar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
