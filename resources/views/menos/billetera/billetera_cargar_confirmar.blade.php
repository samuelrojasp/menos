@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Cargar Saldo</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/billetera/depositar" method="POST">
                        @csrf
                        <h4>Depositar el monto a:</h4>
                        <table class="table">
                            <tr>
                                <th>Numero de cuenta</th>
                                <td>1234-5678-0</td>
                            </tr>
                            <tr>
                                <th>Banco</th>
                                <td>Banco de Chile</td>
                            </tr>
                            <tr>
                                <th>a Nombre de</th>
                                <td>Menos SpA</td>
                            </tr>
                            <tr>
                                <th>RUT</th>
                                <td>78.765.432-1</td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td>depositos@menos.cl</td>
                            </tr>
                            <tr>
                                <th>Monto a cargar</th>
                                <td>{{ number_format($importe,0,',','.') }}</td>
                            </tr>
                        </table>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password">PIN 4 digitos</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" value="" placeholder="4 dígitos" required />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="otro_mail">Email confirmación</label>
                                <input id="otro_mail" type="email"
                                    class="form-control @error('otro_mail') is-invalid @enderror"
                                    name="otro_mail" value="" placeholder="ejemplo@ejemplo.cl" />
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <a href="/billetera/resumen" class="btn btn-secondary">Cancelar</a>
                            <input type="submit" class="btn btn-primary" value="Cargar" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
