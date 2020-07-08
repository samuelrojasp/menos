@extends('menos.office.app')

@section('content')
    <h2>Edita Tienda</h2>
    <div class="card col-md-6">
        <form action="/business/shop/{{ $shop->id }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <br />
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" value="{{ $shop->name }}" />
                <br />
                <input type="text" class="form-control" disabled value="{{ $shop->slug }}" />
            </div>

            <div class="form-group">
                <label for="status"></label>
                <select name="status" id="status" class="form-control">
                    <option value="1" {{ $shop->status == 1 ? "selected" : "" }}>Activa</option>
                    <option value="0" {{ $shop->status == 0 ? "selected" : "" }}>Inactiva</option>
                </select>
            </div>

            <input type="submit" value="Actualizar Tienda"  class="btn btn-primary">
            
        </form>
        <br />
    </div>
@endsection