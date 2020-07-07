@extends('menos.office.app')

@section('content')
    <h2>Nuevo Prospecto</h2>
    <form action="/business/prospectos" method="post">
        @csrf
        <div class="card col-md-6">
            <br />
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" required id="name" name="name" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" required id="email" name="email" />
            </div>
            <a href="/business/prospectos" class="btn btn-secondary">Volver</a>
            <br />
            <button type="submit" class="btn btn-primary">Enviar Invitacion</button>
            <br />
        </div>
    </form>
@endsection