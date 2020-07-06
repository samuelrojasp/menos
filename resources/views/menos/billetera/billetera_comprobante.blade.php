@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Comprobante transacción</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="/billetera/transferir">
                        @csrf
                        <table class="table">
                            <tr>
                                <th>Código de la transacción</th>
                                <td>{{ $transaccion->encoded_id }}</td>
                            </tr>
                            @if($transaccion->cuenta_abono)
                            <tr>
                                <th>Cuenta Abono</th>
                                <td>{{ $transaccion->cuenta_abono }}</td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td>{{ $transaccion->nombre_abono }}</td>
                            </tr>
                            @endif
                            @if($transaccion->cuenta_cargo)
                            <tr>
                                <th>Cuenta Cargo</th>
                                <td>{{ $transaccion->cuenta_cargo }}</td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td>{{ $transaccion->nombre_cargo }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Glosa</th>
                                <td>{{ $transaccion->glosa }}</td>
                            </tr>

                            <tr>
                                <th>Importe</th>
                                <td>{{ number_format($transaccion->importe,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <th>Fecha Transaccion</th>
                                <td>{{ $transaccion->created_at }}</td>
                            </tr>

                        </table>    
                        
                        <div class="text-center">
                            <a href="/billetera/resumen" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
