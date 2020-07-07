@extends('menos.office.app')

@section('content')
    <h2>Mis Tiendas</h2>
    <table class="table">
        <table class="table">
            <tr>
                <th>id</th>
                <th>nombre</th>
                <th>slug</th>
                <th>status</th>
                <th>creado</th>
                <th>visitar</th>
                <th>acciones</th>
            </tr>
            @forelse ($shops as $shop)
            <tr>
                <td>{{ $shop->id }}</td>
                <td>{{ $shop->name }}</td>
                <td>{{ $shop->slug }}</td>
                <td>{{ $shop->status }}</td>
                <td>{{ $shop->created_at }}</td>
                <td>
                    <a href="/{{ $shop->slug }}/shop/index" target="blank">ir</a>
                </td>
                <td>
                    <a href="/business/shop/{{ $shop->id }}/edit">Editar</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">No tienes tiendas creadas</td>
            </tr>
            @endforelse
        </table>
        <br />
        <a href="/business/shop/create" class="btn btn-primary">Nueva Tienda</a>
    </table>

@endsection