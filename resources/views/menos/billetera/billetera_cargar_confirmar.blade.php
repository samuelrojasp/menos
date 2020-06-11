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
                        <table class="table">
                            <tr>
                                <th>Nº Tarjeta de Crédito</th>
                                <td>{{ session('n_tarjeta_credito') }}</td>
                            </tr>
                            <tr>
                                <th><strong>Titular Tarjeta</strong></th>
                                <td>{{ session('nombre_tarjeta_credito') }}</td>
                            </tr>
                            
                            <tr>
                                <th>Monto a retirar</th>
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