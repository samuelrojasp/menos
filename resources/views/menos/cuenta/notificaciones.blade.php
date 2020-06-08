@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Notificaciones</h1>
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        @forelse($notificaciones as $notificacion)
                        <tr>
                            <td>{{ $notificacion->created_at }}</td>
                            <td>{{ $notificacion->text }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2">Aun no tienes notificaciones</td>
                        </tr>    
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
