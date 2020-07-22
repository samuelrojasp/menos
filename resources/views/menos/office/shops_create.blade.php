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
            @if($url == 'associated')
            <div class="form-group">
                <label for="comision">Comision</label>
                <select name="comision">
                    <option value="0.0003">0,03%</option>
                    <option value="0.0004">0,04%</option>
                    <option value="0.0005">0,05%</option>
                </select>
            </div>
            @endif
            <input type="submit" value="Crear Tienda"  class="btn btn-primary">
        </form>
    </div>
@endsection