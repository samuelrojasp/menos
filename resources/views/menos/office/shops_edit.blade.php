@extends('menos.office.app')

@section('content')
    <h2>{{ $title }}</h2>
    <div class="card col-md-6">
        <form action="/business/{{ $url }}/{{ $shop->id }}" method="post">
            @csrf
            @method('put')
            <div class="form-group">
                <br />
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" value="{{ $shop->name }}" />
                <br />
                <input type="text" class="form-control" disabled value="{{ $shop->slug }}" />
            </div>
            @if($url == 'associated')
            <div class="form-group">
                <label for="comision">Comision</label>
                <select name="comision">
                    <option value="0.0003" {{ $shop->comision == 0.0003 ? 'selected' : '' }}>0,03%</option>
                    <option value="0.0004" {{ $shop->comision == 0.0004 ? 'selected' : '' }}>0,04%</option>
                    <option value="0.0005" {{ $shop->comision == 0.0005 ? 'selected' : '' }}>0,05%</option>
                </select>
            </div>
            @endif
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