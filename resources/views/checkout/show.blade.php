@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Todos los Productos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">Carrito</a></li>
    <li class="breadcrumb-item">Pagar</li>

@stop

@section('content')
    <style>
        .product-image {
            max-width: 100%;
            display: block;
            margin-bottom: 2em;
        }
    </style>
    <div class="container">
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pagar</div>

                    <div class="card-body">
                        @unless ($checkout)
                            <div class="alert alert-warning">
                                <p>Oops! No hay nada que pagar.</p>
                            </div>
                        @endunless

                        @if ($checkout)
                            <form id="checkout" action="{{ route('checkout.submit') }}" method="post">
                                {{ csrf_field() }}

                                @include('checkout._billpayer', ['billpayer' => $checkout->getBillPayer()])

                                <div class="mb-4">
                                    <input type="hidden" name="ship_to_billing_address" value="0" />
                                    <div class="form-check">
                                        <input class="form-check-input" id="chk_ship_to_billing_address" type="checkbox" name="ship_to_billing_address" value="1" v-model="shipToBillingAddress">
                                        <label class="form-check-label" for="chk_ship_to_billing_address">Enviar al mismo domicilio</label>
                                    </div>
                                </div>

                                @include('checkout._shipping_address', ['address' => $checkout->getShippingAddress()])

                                <hr>

                                <div class="form-group">

                                    <label class="">{{ __('Notas de la Orden') }}</label>
                                    {{ Form::textarea('notes', null, [
                                            'class' => 'form-control' . ($errors->has('notes') ? ' is-invalid' : ''),
                                            'rows' => 3
                                        ])
                                    }}
                                    @if ($errors->has('notes'))
                                        <div class="invalid-feedback">{{ $errors->first('notes') }}</div>
                                    @endif
                                </div>
                                
                                <hr>
                                <div class="form-group col-md-4">
                                    <label for="password">Pago con Billetera Digital <span class="text-muted">(Saldo $ {{ number_format($saldo_cuenta, 0, ',','.') }})</label>
                                    <input class="form-control" type="password" placeholder="PIN 4 Dígitos" name="password" id="password" required />
                                </div>
                                <div>
                                    <button class="btn btn-lg btn-success">Enviar Orden</button>
                                </div>


                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white">
                    <div class="card-header">Resumen</div>
                    <div class="card-body">
                        @include('cart._summary')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($checkout)
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            new Vue({
                el: '#checkout',
                data: {
                    isOrganization: {{ old('billpayer.is_organization') ?: 0 }},
                    shipToBillingAddress: {{ old('ship_to_billing_address') ?? 1 }}
                }
            });
        });
    </script>
    @endif
@stop

