<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use App\Movimiento;
use App\User;
use App\Country;
use App\CodigoVerificacion;

class BilleteraController extends Controller
{
    public function resumen()
    {
        $user = auth()->user();
        $cuentas = Cuenta::where('user_id', $user->id)->get();
        
        return view('menos.billetera.billetera_dashboard', [
            'usuario' => $user,
            'cuentas' => $cuentas,
        ]);      
    }

    public function depositar()
    {
        $user = auth()->user();

        return view('menos.billetera.billetera_depositar', [
            'usuario' => $user
        ]);
    }

    public function confirmarCarga(Request $request)
    {
        $user = auth()->user();
        
        session(['n_tarjeta_credito' => $request->n_tarjeta_credito,
                'nombre_tarjeta_credito' => $request->nombre_tarjeta_credito,
                'importe' => $request->importe,
        ]);
        
        return view('menos.billetera.billetera_cargar_confirmar', [
            'importe' => $request->importe,
            'user' => $user,
        ]);
    }

    public function transferir()
    {
        $user = auth()->user();

        $cuenta = Cuenta::where('user_id', $user->id)->first();

        $countries = Country::all();

        if($cuenta->saldo <= 0)
        {
            return redirect('/billetera/resumen')->with('error', 'No dispone de saldo para esta operación');
        }

        $usuarios = User::where('is_verified', 1)->where('id', '!=', $user->id)->get();

        return view('menos.billetera.billetera_transferir', [
            'usuario' => $user,
            'cuenta' => $cuenta,
            'countries' => $countries
        ]);
    }

    public function confirmarTransferencia(Request $request)
    {
        $pagador = auth()->user();

        $beneficiario = User::where('telephone', $request->telephone)->first();
        
        if(!$beneficiario){
            return back()->with(['error', 'El numero no corresponde a ningun usuario']);
        }
        
        session(['beneficiario_id' => $beneficiario->id]);
        session(['importe' => $request->importe]);
        
        return view('menos.billetera.billetera_confirmar_transferencia', [
            'beneficiario' => $beneficiario,
            'importe' => $request->importe
        ]);
    }

    public function confirmarRetiro(Request $request)
    {
        $user = auth()->user();
        $cuenta_bancaria = $user->cuenta_bancaria;
        
        if($cuenta_bancaria == null)
        {
            return redirect('billetera/resumen')->with(['error' => 'Debes configurar una cuenta bancaria']);
        }

        session(['importe' => $request->importe]);
        
        return view('menos.billetera.billetera_retirar_confirmar', [
            'importe' => $request->importe,
            'user' => $user,
            'cuenta_bancaria' => $cuenta_bancaria->first()
        ]);
    }




    public function retirar()
    {
        $user = auth()->user();

        $cuenta = Cuenta::where('user_id', $user->id)->first();

        if($cuenta->saldo <= 0)
        {
            return redirect('/billetera/resumen')->with('error', 'No dispone de saldo para esta operación');
        }

        return view('menos.billetera.billetera_retirar', [
            'usuario' => $user,
            'cuenta' => $cuenta
        ]);
    }

    public function historial()
    {
        $user = auth()->user();

        $cuentas = Cuenta::where('user_id', $user->id)->get();
        
        return view('menos.billetera.billetera_historial', [
            'usuario' => $user,
            'cuentas' => $cuentas,
        ]);      
    }
}
