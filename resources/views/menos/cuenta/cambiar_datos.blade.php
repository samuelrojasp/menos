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
                            <label for="autocomplete">Dirección</label>
                            <input type="text" class="form-control" onFocus="geolocate()" id="autocomplete" name="autocomplete" placeholder="Calle, numero" value="{{$user->address1}}"  required/>
                        </div>

                        <input type="hidden" class="form-control" id="route" name="route" placeholder="" value=""/>
                        <input type="hidden" class="form-control" id="street_number" name="street_number" placeholder="" value=""/>
                        <input type="hidden" class="form-control" id="locality" name="locality" placeholder="" value="{{ $user->city ? $user->city : '' }}" />
                        <input type="hidden" class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" placeholder="" value="{{ $user->state ? $user->state : '' }}"/>
                        <input type="hidden" class="form-control" id="country" name="country" placeholder="" value="{{ $user->countryid ? $user->countryid : '' }}"/>
                        
                        <a href="/mi_cuenta/resumen" class="btn btn-secondary">Volver</a>
                        <input type="submit" class="btn btn-primary" value="Actualizar Datos" />
                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
