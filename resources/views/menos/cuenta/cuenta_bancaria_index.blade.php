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
                    @if($user->cuenta_bancaria)
                    <table class="table table-hover">
                        <tr>
                            <th><strong>Nombre Titular</strong></th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th><strong>RUT Titular</strong></th>
                            <td>{{ $user->rut }}</td>
                        <tr>
                        <tr>
                            <th><strong>Banco</strong></th>
                            <td>{{ $user->cuenta_bancaria->banco->nombre }}</td>
                        </tr>
                        <tr>
                            <th><strong>Número Cuenta</strong></th>
                            <td>{{ $user->cuenta_bancaria->numero_cuenta }}</td>
                        </tr>
                        <tr>
                            <th><strong>Tipo Cuenta</strong></th>
                            <td>{{ $user->cuenta_bancaria->tipo_cuenta }}</td>
                        </tr>
                        <tr>
                            <th><strong>Correo Electrónico</strong></th>
                            <td>{{ $user->email }} 
                        </tr>
                    </table>
                    <form action="/mi_cuenta/cuenta_bancaria/{{$user->cuenta_bancaria->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="/mi_cuenta/cuenta_bancaria/{{$user->cuenta_bancaria->id}}/edit" class="btn btn-primary">Cambiar datos</a>
                        <input type="submit" class="btn btn-secondary" value="Eliminar Cuenta" />
                    </form>
                    
                    @else
                        <a class="btn btn-primary" href="/mi_cuenta/cuenta_bancaria/create">Agrega tu cuenta bancaria</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
