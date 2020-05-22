<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use App\Movimiento;

class BilleteraController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $cuentas = Cuenta::where('user_id', $user->id)->get();
        $movimientos = collect([]);
        
        foreach($cuentas as $c){
            $movimientos = $movimientos->push(Movimiento::where('cuenta_id', $c->id)->get());
        }

        return view('billetera_dashboard', [
            'usuario' => $user,
            'cuentas' => $cuentas,
            'movimientos' => $movimientos

        ]);      
    }

    public function depositar()
    {
        $user = auth()->user();

        return view('billetera_depositar', [
            'usuario' => $user
        ]);
    }
}
