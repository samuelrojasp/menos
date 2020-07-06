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
                        <a href="/admin2/depositar" class="nav-link">Depositar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/transferir" class="nav-link">Transferir</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/retirar" class="nav-link">Retirar</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/comprar" class="nav-link">Comprar (SOLO PRUEBAS)</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/historial" class="nav-link">Historial</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/tipos_cuenta" class="nav-link text-secondary">Tipos Cuentas</a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin2/tipos_transaccion" class="nav-link text-secondary">Tipos Transacción</a>
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
                <div class="card-header">Tipos de {{ $tipo }}</div>

                <div class="card-body">
                    <table class="table-responsive table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tipo {{ $tipo }}</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tipos as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>{{ $t->nombre }}</td>
                                <td>
                                    <a href="#">modificar</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="3">No hay información para mostrar</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <a href="#" class="btn btn-primary">Nuevo Tipo {{ $tipo }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
