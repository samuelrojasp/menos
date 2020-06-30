<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function checkout()
    {
        $cuenta = auth()->user()->cuentas()->first();

        if($cuenta->saldo < 290000){
            return redirect('/shop/index')->with(['error' => 'No dispones de saldo suficiente para unirte a Menos Business.']);
        }

        return view('menos.unete.checkout');
    }
}
