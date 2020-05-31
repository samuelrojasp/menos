@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Inicia Sesión</h1>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div>
                            <input id="phone" type="tel" placeholder="Escribe tu número" class="form-control @error('telephone') is-invalid @enderror" value="" required>                      
                        </div>
                        @error('telephone')
                        <p><small class="text-danger">Número incorrecto</small></p>
                        @enderror
                        <br />
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                        <div class="col-md-12">
                            <p class="muted">Enviaremos un mensaje a este número con un código de confirmación</p> 
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center">Si ya eres usuario ingresa <a href="/login">aquí</a></p>
        </div>
    </div>
</div>
@endsection
