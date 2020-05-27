@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Transferir</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/billetera/transferir">
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
                                <input id="verification_code" type="number"
                                    class="form-control @error('verification_code') is-invalid @enderror"
                                    name="verification_code" value="" placeholder="Código de verificación" required>
                                @error('verification_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="text-muted">{{ $password }}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-secondary">Cancelar </a>
                            <input type="submit" class="btn btn-primary" value="Transferir">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
