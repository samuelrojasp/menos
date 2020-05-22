@extends('layouts.app')

@section('menu')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav justify-content-center">
                    <li class="nav-item">
                        <a href="/admin2/dashboard" class="nav-link">Principal</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-secondary">Depositar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/transferir" class="nav-link">Transferir</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/retirar" class="nav-link">Retirar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/comprar" class="nav-link">Comprar (SOLO PRUEBAS)</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/historial" class="nav-link">Historial</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/tipos_cuenta" class="nav-link">Tipos Cuentas</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/tipos_transaccion" class="nav-link">Tipos Transacción</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
           
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Depositar</div>
                <div class="card-body">
                    <form method="post" action="/admin2/depositar">
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
