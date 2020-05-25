@extends('menos.layouts.app')

                    @section('content')
                    <div class="container">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Cambiar datos de Perfil</h3>
                                    </div>
                                    <div class="card-body">
                                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/mi_cuenta/cambiar_datos" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Su Nombre" value="{{ old('name') ?? $user->name }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="rut">RUT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="rut" name="rut" placeholder="ej. 12345678-9" value="{{ old('rut') ?? $user->rut }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="birthday" name="birthday" placeholder="ej. 31/05/1980" value="{{ old('birthday') ?? $user->birthday }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="address1">Dirección 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address1" name="address1" placeholder="Calle, numero" value="{{ old('address1') ?? $user->address1 }}"  required/>
                        </div>
                        <div class="form-group">
                            <label for="address2">Dirección 2</label>
                            <input type="text" class="form-control" id="address2" name="address2" placeholder="Mza, Pobl., Villa" value="{{ old('address2') ?? $user->address2 }}"/>
                        </div>
                        <div class="form-group">
                            <label for="city">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ old('city') ?? $user->city }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="state">Estado o Región <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="" value="{{ old('state') ?? $user->state }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="countryid">Pais <span class="text-danger">*</span></label>
                            <select class="form-control" id="countryid" name="countryid" required>
                                <option>Selecciona un pais...</option>
                                <option value="CL" {{ $user->countryid == 'CL' ? 'selected' : '' }}>Chile</option>
                            </select>
                        </div>
                        <a href="/mi_cuenta/resumen" class="btn btn-secondary">Volver</a>
                        <input type="submit" class="btn btn-primary" value="Actualizar Datos" />
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
