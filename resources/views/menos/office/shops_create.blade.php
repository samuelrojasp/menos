@extends('menos.office.app')

@section('content')
    <h2>{{ $title }}</h2>
    <div class="card col-md-6">
        <form action="/business/{{ $url }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" />
            </div>

            <input type="submit" value="Crear Tienda"  class="btn btn-primary">
        </form>
    </div>
@endsection