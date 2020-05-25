@extends('menos.layouts.app')

@section('content')
<div class="col-md-10">        
    <div class="card">
        <div class="card-header">
            <h3>Cambia tú Nº de Teléfono</h3>
        </div>
        <div class="card-body">
            <form action="/mi_cuenta/seguridad/cambiar_telefono" method="post">
                @csrf
                <div class="form-group">
                    <label for="telephone">Nuevo Número</label>
                    <input type="text" class="form-control" id="telephone" name="telephone" placeholder="ej. +56912345678">
                </div>
                <div class="form-group">
                    <label class="form-check-label" for="method">Indica el método de verificación</label>
                    <select class="form-control" id="method" name="method">
                        <option value="0" selected>WhatsApp</option>
                        <option value="1">SMS</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cambiar Teléfono</button>
            </form>
        </div>
    </div>
    <br />
    <div class="card">
        <div class="card-header">
            <h3>Cambia tu e-mail</h3>
        </div>
        <div class="card-body">
            <form action="/mi_cuenta/seguridad/cambiar_email" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">Nuevo email</label>
                    <input type="email" class="form-control" name="email" placeholder="ej. ejemplo@ejemplo.com">
                </div>
                <div class="form-group">
                    <label for="email1">Repita Nuevo email</label>
                    <input type="email" class="form-control" name="email1" placeholder="ej. ejemplo@ejemplo.com">
                </div>
                <button type="submit" class="btn btn-primary">Cambiar email</button>
            </form>
        </div>
    </div>
    <br />
     <div class="card">
        <div class="card-header">
            <h3>Cambia tu contraseña</h3>
        </div>
        <div class="card-body">
            <form action="/mi_cuenta/seguridad/cambiar_contrasena" method="post">
                @csrf
                <div class="form-group">
                    <label for="old_password">Contraseña Actual</label>
                    <input type="password" class="form-control" name="old_password" placeholder="4 dígitos">
                </div>
                <div class="form-group">
                    <label for="new_password1">Nueva Contraseña</label>
                    <input type="password" class="form-control" name="new_password1" placeholder="4 dígitos">
                </div>
                <div class="form-group">
                    <label for="new_password2">Repita Nueva Contraseña</label>
                    <input type="password" class="form-control" name="new_password2" placeholder="4 dígitos">
                </div>
                <button type="submit" class="btn btn-primary">Cambiar contraseña</button>
            </form>
        </div>
    </div>
</div>
@endsection
