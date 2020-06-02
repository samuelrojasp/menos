@extends('menos.layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3>Nueva Dirección</h3>
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

                    <form action="/mi_cuenta/direcciones/nueva" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Título </label>
                            <select class="form-control" id="salutation" name="salutation">
                                <option value="">Seleccione una opción</option>
                                <option>Sr.</option>
                                <option>Sra.</option>
                                <option>Srta.</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="firstname">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="{{ old('firstname') }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Apellido(s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="address1">Dirección 1 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address1" name="address1" placeholder="Calle, numero" value="{{ old('address1') }}"  required/>
                        </div>
                        <div class="form-group">
                            <label for="address2">Dirección 2</label>
                            <input type="text" class="form-control" id="address2" name="address2" placeholder="Mza, Pobl., Villa" value="{{ old('address2') }}"/>
                        </div>
                        <div class="form-group">
                            <label for="address3">Dirección 2</label>
                            <input type="text" class="form-control" id="address3" name="address3" value="{{ old('address3') }}"/>
                        </div>

                        <div class="form-group">
                            <label for="postal">Código Postal</label>
                            <input type="text" class="form-control" id="postal" name="postal" value="{{ old('postal') }}"/>
                        </div>

                        <div class="form-group">
                            <label for="city">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="" value="{{ old('city') }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="state">Estado o Región <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="" value="{{ old('state') }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="countryid">Pais <span class="text-danger">*</span></label>
                            <select class="form-control" id="countryid" name="countryid" required>
                                <option>Selecciona un pais...</option>
                                @foreach($countries as $country)
                                <option value="{{ $country->countryid }}" {{ $country->countryid }}>{{ $country->nicename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="" value="{{ old('telephone') }}" required/>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="" value="{{ old('email') }}" required/>
                        </div>
                        <a href="/mi_cuenta/direcciones" class="btn btn-secondary">Volver</a>
                        <input type="submit" class="btn btn-primary" value="Guardar" />
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
