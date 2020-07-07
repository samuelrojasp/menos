@extends('menos.office.app')

@section('content')
    <h2>Colocar Afiliado en Arbol Binario</h2>
    <table class="table">
        <tr>
            <td>Nombre</td>
            <td>email</td>
            <td>telefono</td>
            <td>Ubicar bajo:</td>
        </tr>
        @forelse($afiliados as $afiliado)
        <tr>
            <td>{{ $afiliado->name }}</td>
            <td>{{ $afiliado->email }}</td>
            <td>{{ $afiliado->telephone }}</td>
            <td>
                <form action="/business/binaria/ubicar-afiliado" method="post">
                    @csrf
                    <select class="form-control" name="binary_parent_id" required>
                        <option disabled>Selecciona un afiliado...</option>
                        @foreach($binary_parents as $binary_parent)
                        <option value="{{ $binary_parent->id }}">{{ $binary_parent->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control" name="binary_side" required>
                        <option disabled>Seleciona un lado...</option>
                    </select>
                    <input type="submit" class="btn btn-primary" value="Ubicar" />
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No tienes afiliados que no hayan sido ubicados</td>
        </tr>
        @endforelse
    </table>

@endsection