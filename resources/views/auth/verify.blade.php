@extends('layouts.app')
@section('content')
<div class="container">
    <p class="text-center">Iniciar sesión</p>
    <h1 class="text-center">{{ $telephone }}</h1>
    <p class="text-center text-danger">¿Este no es su número?</p>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{session('error')}}
                    </div>
                    @endif
                    <form action="{{route('verify')}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="hidden" name="telephone" value="{{ $telephone }}">
                                <input id="verification_code" type="tel"
                                    class="form-control @error('verification_code') is-invalid @enderror"
                                    name="verification_code" value="" placeholder="Código de verificación" required>
                                @error('verification_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Verificar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-muted">{{ $codigo }}
        </div>
    </div>
</div>
@endsection
