@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1>Verifica tu identidad</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="/mi_cuenta/verifica_identidad" method="POST" enctype="multipart/form-data">
                        @csrf
                        <p>Súbe una imagen de tu carnet por ambos lados</p>
                        <p>Anverso:</p>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="anverso" name="anverso" required accept="image/*">
                            <label class="custom-file-label" for="anverso" data-browse="Elegir">Choose file</label>
                        </div>
                        <p>Reverso:</p>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="reverso" name="reverso" required accept="image/*">
                            <label class="custom-file-label" for="reverso" data-browse="Elegir">Choose file</label>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Subir" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
