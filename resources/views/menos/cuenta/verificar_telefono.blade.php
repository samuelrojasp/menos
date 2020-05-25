@extends('menos.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Verifique su celular') }}</div>
                <div class="card-body">
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{session('error')}}
                    </div>
                    @endif
                    Por favor, indique el codigo de verificación de 6 dígitos que enviamos a su telefono {{ $telephone }}
                    <form action="/mi_cuenta/seguridad/verificar_telefono" method="post">
                        @csrf
                        <input type="hidden" name="telephone" value="{{ $telephone }}" />
                        <div class="form-group row">
                            <label for="verification_code"
                                class="col-md-4 col-form-label text-md-right">{{ __('Codigo de verificación') }}</label>
                            <div class="col-md-6">
                                <input id="verification_code" type="tel"
                                    class="form-control @error('verification_code') is-invalid @enderror"
                                    name="verification_code" value="{{ old('verification_code') }}" required>
                                @error('verification_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Verificar Número de Celular') }}
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
