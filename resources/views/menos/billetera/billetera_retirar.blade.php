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
                        <a href="/admin2/retirar" class="nav-link">Depositar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/transferir" class="nav-link">Transferir</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-secondary">Retirar</a>
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
                <div class="card-header">Retirar</div>
                <div class="card-body">
                    <form method="post" action="/admin2/retirar">
                        @csrf
                        <div class="form-group">
                            <label for="importe">Indique el monto a retirar de la cuenta</label>
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
                        <input type="submit" class="btn btn-primary" value="Retirar">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
