@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Pago Recibido</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Código Pagador</th>
                            <td>{{ $usuario_pagador->telephone }}</td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $usuario_pagador->name }}</td>
                        </tr>
                        <tr>
                            <th>RUT</th>
                            <td>{{ \Freshwork\ChileanBundle\Rut::parse($usuario_pagador->rut)->format() }}</td>
                        </tr>
                        <tr>
                            <th>Correo</th>
                            <td>{{ $usuario_pagador->email }}</td>
                        </tr>
                        <tr>
                            <th>Monto a Monto Pagado</th>
                            <td>{{ number_format($movimiento_beneficiario->importe,0,',','.') }}</td>
                        </tr>
                    </table>    
                    
                    <div class="text-center">
                        <a href="/billetera/resumen" class="btn btn-secondary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
