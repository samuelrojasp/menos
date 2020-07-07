@extends('menos.office.app')

@section('content')
    <h2>Nueva Tienda</h2>
    <div class="card col-md-6">
        <form action="/business/shop" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" />
            </div>

            <input type="submit" value="Crear Tienda"  class="btn btn-primary">
        </form>
    </div>
@endsection