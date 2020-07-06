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
                        
                        <a href="/billetera/resumen" class="btn btn-default">Cancelar </a>
                        <input type="submit" class="btn btn-primary" value="Siguiente">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
