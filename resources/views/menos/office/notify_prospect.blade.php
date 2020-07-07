@extends('menos.email.layout2')

@section('content')
    Hola, {{ $prospecto->name }}

    {{ $prospecto->sponsor->name }} te ha invitado a ser afiliado Business en Menos.

    Haz click en este <a href="/business/unete?prospecto={{ $prospecto->id }}">link</a> para comenzar el proceso de afiliación.

    Atentamente,
    Menos.
@endsection