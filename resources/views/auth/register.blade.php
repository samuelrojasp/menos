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

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select name="phonecode" id="phonecode">
                                    @foreach( $countries as $country )
                                    <option value="{{ $country->phonecode }}" {{ $country->phonecode == '56' ? 'selected' : '' }}>+{{ $country->phonecode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input id="telephone" type="tel" placeholder="Escribe tu número" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="telephone">                            
                        </div>
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
