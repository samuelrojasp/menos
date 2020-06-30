@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="/business/unete">Únete</a></li>
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
                        

                        
                            <form id="checkout" action="/business/plan-checkout" method="post">
                                @csrf

                                <hr>

                                <div class="form-group">
                                    <label class="">Numero del patrocinador</label>
                                    <input class="form-control referer" type="text" name="phone" id="phone" />
                                    <span class="text-muted" id="refererName"></span>  
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
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white">
                    <div class="card-header">Resumen</div>
                    <div class="card-body">
                        <table class="table table-borderless table-condensed">
                            <tr>
                                <th class="pl-0">Afiliación a Menos Business</th>
                                <td class="text-right">$ 290.000</td>
                            </tr>
                        </table>
                        
                        <h5>Total:</h5>
                        <h3 class="text-right">$ 290.000</h3>
                        
                        <hr>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

