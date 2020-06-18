@extends('menos.layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-10">
            <h2 class="text-center">Mis Direcciones</h2>
            <p class="text-right">
                <a href="/mi_cuenta/direcciones/nueva" class="btn btn-primary">Nueva Dirección</a>
            </p>
            <div class="accordion" id="direcciones">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#principal" aria-expanded="true" aria-controls="principal">
                                Dirección Principal
                            </button>
                        </h2>
                    </div>

                    <div id="principal" class="collapse show" aria-labelledby="headingOne" data-parent="#direcciones">
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th><strong>Nombre</strong></th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Correo Electrónico</strong></th>
                                    <td>{{ $user->email }}
                                </tr>
                                <tr>
                                    <th><strong>Dirección</strong></th>
                                    <td>{{ $user->address1 }}</td>
                                </tr>
                                
                                <tr>
                                    <th><strong>Teléfono</strong></th>
                                    <td>{{ $user->telephone }}</td>
                                </tr>
                            </table>
                            <a href="/mi_cuenta/cambiar_datos" class="btn btn-primary">
                                <i class="fa fa-pencil"></i> Modificar mis datos
                            </a>
                        </div>
                    </div>
                </div>
                @foreach($addresses as $address)
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#alternativa{{$loop->index+1}}" aria-expanded="true" aria-controls="principal">
                                Dirección Alternativa {{ $loop->index + 1 }}
                            </button>
                        </h2>
                    </div>

                    <div id="alternativa{{$loop->index+1}}" class="collapse show" aria-labelledby="headingOne" data-parent="#direcciones">
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <th><strong>Nombre</strong></th>
                                    <td>{{ $address->firstname }} {{$address->lastname }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Dirección 1</strong></th>
                                    <td>{{ $address->address1 }} {{ $address->address2 }} {{ $address->address3 }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Código Postal</strong></th>
                                    <td>{{ $address->postal }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Ciudad, Estado</strong></th>
                                    <td>{{ $address->city }} {{ $address->city!=null&&$address->state!=null ? "," : ""}} {{ $address->state }}</td>
                                </tr>
                                <tr>
                                    <th><strong>País</strong></th>
                                    <td>{{ $user->country->name }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Teléfono</strong></th>
                                    <td>{{ $user->telephone }}</td>
                                </tr>
                                <tr>
                                    <th><strong>Email</strong></th>
                                    <td>{{ $address->email }}</td>
                                </tr>
                            </table>
                            <form action="/mi_cuenta/direcciones/{{ $address->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-secondary" value="eliminar" />
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
</div>
@endsection
