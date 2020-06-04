@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Transferir</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/billetera/transferir" method="POST">
                        @csrf    
                        <table class="table">
                            <tr>
                                <th>Código Beneficiario</th>
                                <td>{{ $beneficiario->telephone }}</td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td>{{ $beneficiario->name }}</td>
                            </tr>
                            <tr>
                                <th>RUT</th>
                                <td>{{ \Freshwork\ChileanBundle\Rut::parse($beneficiario->rut)->format() }}</td>
                            </tr>
                            <tr>
                                <th>Correo</th>
                                <td>{{ $beneficiario->email }}</td>
                            </tr>
                            <tr>
                                <th>Monto a transferir</th>
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
                            <input type="submit" class="btn btn-primary" value="Transferir" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
