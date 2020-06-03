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
                            <label for="autocomplete">Dirección</label>
                            <input type="text" class="form-control" onFocus="geolocate()" id="autocomplete" name="autocomplete" placeholder="Calle, numero" value=""  required/>
                        </div>

                        <input type="hidden" class="form-control" id="route" name="route" placeholder="" value=""/>
                        <input type="hidden" class="form-control" id="street_number" name="street_number" placeholder="" value=""/>
                        <input type="hidden" class="form-control" id="locality" name="locality" placeholder="" value="" />
                        <input type="hidden" class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" placeholder="" value=""/>
                        <input type="hidden" class="form-control" id="country" name="country" placeholder="" value=""/>
                        <div class="form-group">
                            <label for="postal">Código Postal</label>
                            <input type="number" class="form-control" id="postal" name="postal" />
                        </div>

                        <div class="form-group">
                            <label for="phone">Teléfono <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="" value="{{ old('telephone') }}" required/>
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
