@extends('menos.office.app')

@section('content')
    <h2>Colocar Afiliado en Arbol Binario</h2>
    <table class="table">
        <tr>
            <td>Nombre</td>
            <td>email</td>
            <td>telefono</td>
            <td>Ubicar bajo:</td>
        </tr>
        @forelse($afiliados as $afiliado)
        <tr>
            <td>{{ $afiliado->name }}</td>
            <td>{{ $afiliado->email }}</td>
            <td>{{ $afiliado->telephone }}</td>
            <td>
                <form action="/business/binaria/ubicar-afiliado" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $afiliado->id }}" />
                    <select class="form-control" name="binary_parent_id" id="binary_parent_id" required>
                        <option selected disabled>Selecciona un afiliado...</option>
                        @foreach($binary_parents as $binary_parent)
                        <option value="{{ $binary_parent->id }}">{{ $binary_parent->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control" name="binary_side" id="binary_side" required>
                        <option selected disabled>Seleciona un lado...</option>
                    </select>
                    <input type="submit" class="btn btn-primary" value="Ubicar" />
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No tienes afiliados que no hayan sido ubicados</td>
        </tr>
        @endforelse
    </table>
    <script>
        var $binary_available_parent = document.querySelector('#binary_parent_id');
        var $binary_side = document.querySelector('#binary_side');

        $binary_available_parent.addEventListener('change', function(){
            
            fetch('/api/binary_child_available_side/' + this.value)
                .then(response => response.json())
                .then(function(res){
                    $binary_side.options.length = 0;
                    var $options = `<option selected disabled>Selecciona un lado...</option>`;
                    res.forEach(function(item, index, arr){
                        $options += `<option value="${index}">${item}</option>`;
                    });

                    $binary_side.innerHTML = $options;
                });
        });

    </script>
@endsection