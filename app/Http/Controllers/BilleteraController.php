<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use App\Movimiento;
use App\User;

class BilleteraController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $cuentas = Cuenta::where('user_id', $user->id)->get();
        $movimientos = collect([]);
        
        foreach($cuentas as $c){
            $movimientos = $c->movimientos()->get();
        }

        //return $movimientos;

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

    public function transferir()
    {
        $user = auth()->user();

        $usuarios = User::where('is_verified', 1)->where('id', '!=', $user->id)->get();

        return view('billetera_transferir', [
            'usuario' => $user,
            'usuarios' => $usuarios
        ]);
    }

    public function retirar()
    {
        $user = auth()->user();

        return view('billetera_retirar', [
            'usuario' => $user
        ]);
    }
}
