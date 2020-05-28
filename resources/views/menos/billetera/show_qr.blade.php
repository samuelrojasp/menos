@extends('menos.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Pago por QR</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body justify-content-center">
                {!! QrCode::size(300)->errorCorrection('L')->generate($url); !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
