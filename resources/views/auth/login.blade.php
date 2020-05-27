@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Iniciar Sesión</h1>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group col-md-12">
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

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">Recuérdame</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center">Si no recuerdas tu contraseña, ingresa <a href="/register">aquí</a></p>
        </div>
    </div>
</div>
@endsection
