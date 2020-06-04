@extends('menos.layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Cuenta Bancaria</h3>
                </div>
                <div class="card-body">
                    <form action="/mi_cuenta/cuenta_bancaria/{{ $cuenta_bancaria->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <table class="table table-hover">
                            <tr>
                                <th><strong>Nombre Titular</strong></th>
                                <td class="text-muted">{{ $user->name }} (La cuenta debe estar a tu nombre)</td>
                            </tr>
                            <tr>
                                <th><strong>RUT Titular</strong></th>
                                <td class="text-muted">{{ $user->formatted_rut }}</td>
                            <tr>
                            <tr>
                                <th><strong>Banco</strong></th>
                                <td>
                                    <select class="form-control" id="banco_id" name="banco_id" required>
                                        <option disabled selected>Seleccione un banco</option>
                                        @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}" {{ $banco->id == $cuenta_bancaria->banco_id ? 'selected' : ''}}>{{ $banco->nombre }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><strong>Tipo Cuenta</strong></th>
                                <td>
                                    <select class="form-control" id="tipo_cuenta" name="tipo_cuenta" required>
                                        <option disabled selected>Selecciona...</option>
                                        <option value="1" {{ $cuenta_bancaria->getRawOriginal('tipo_cuenta') == "1" ? 'selected' : '' }}>Cuenta Corriente</option>
                                        <option value="2" {{ $cuenta_bancaria->getRawOriginal('tipo_cuenta') == "2" ? 'selected' : '' }}>Cuenta Vista</option>
                                        <option value="3" {{ $cuenta_bancaria->getRawOriginal('tipo_cuenta') == "3" ? 'selected' : '' }}>Cuenta Ahorro</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><strong>Número Cuenta</strong></th>
                                <td><input type="text" class="form-control" name="numero_cuenta" id="numero_cuenta" value="{{ $cuenta_bancaria->numero_cuenta }}" required /></td>
                            </tr>
                            
                            <tr>
                                <th><strong>Correo Electrónico</strong></th>
                                <td class="text-muted">{{ $user->email }}</td>
                            </tr>
                        </table>
                        <input type="submit" class="btn btn-primary" value="Actualizar Cuenta" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
