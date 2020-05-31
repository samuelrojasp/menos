@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Registro</h1>
    <p class="text-center">Con el teléfono {{ session('telephone') }}, previamente verificado. <a href="/register"> Cambiar el número de registro</a></p>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="/registrar_datos">
                        @csrf
                        <input type="hidden" name="telephone" id="telephone" value="{{ session('telephone') }}" />

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="name" type="text" placeholder="Tu nombre completo" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="username" type="text" placeholder="Nombre de usuario (Letras, números y _)" class="form-control @error('username') is-invalid @enderror" name="name" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="rut" type="text" placeholder="Tu RUT (ej. 12345678-0)" class="form-control @error('rut') is-invalid @enderror" name="rut" value="{{ old('rut') }}" required autocomplete="rut" autofocus>

                                @error('rut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="ej. jperez@alguncorreo.com" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="password" type="password" pattern="{0-9}*" inputmode="numeric" minlength="4" maxlength="4" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Contraseña (4 dígitos)" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" pattern="{0-9}*" inputmode="numeric" minlength="4" maxlength="4" class="form-control" name="password_confirmation" placeholder="Repita contraseña" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-groupmb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrarse') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection