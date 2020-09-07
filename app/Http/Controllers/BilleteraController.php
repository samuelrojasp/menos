<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuenta;
use App\Movimiento;
use App\User;
use App\Country;
use App\CodigoVerificacion;
use App\CuentaBancaria;
use App\Transaccion;
use App\Notification;
use Illuminate\Support\Arr;
use JavaScript;

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

        session(['importe' => $request->importe]);
        
        return view('menos.billetera.billetera_cargar_confirmar', [
            'importe' => $request->importe,
            'user' => $user,
        ]);
    }

    public function transferir()
    {
        $user = auth()->user();

        $cuenta = $user->cuentas->first();

        
        $movimientos = $cuenta->movimientos;

        $transacciones = array();

        foreach ($movimientos as $movimiento) {
            $trans = $movimiento->transaccion;
            $mov_abono = $trans->movimientos->where('cargo_abono', 'abono')->first();
            $beneficiario = $cuenta['user'];

            if ($beneficiario['id'] != $user->id && $beneficiario != null) {
                $beneficiario = $beneficiario->toArray();
                array_push($transacciones, $beneficiario);
            }
        }

        $ultimos_destinatarios = array_map("unserialize", array_unique(array_map("serialize", $transacciones)));

        $ultimos = Arr::pluck($transacciones, 'name', 'telephone');

        $cuentas = Cuenta::where('user_id', $user->id)->get();
        $countries = Country::all();

        JavaScript::put([
            'ultimos' => $ultimos
        ]);

        return view('menos.billetera.billetera_transferir', [
            'usuario' => $user,
            'cuentas' => $cuentas,
            'countries' => $countries,
            'ultimos_destinatarios' => $ultimos_destinatarios,

        ]);
    }

    public function confirmarTransferencia(Request $request)
    {
        $pagador = auth()->user();
        $cuenta = Cuenta::find($request->cuenta_id);

        $beneficiario = User::where('telephone', $request->user_id ?? $request->telephone)->first();
        
        if (!$beneficiario) {
            return back()->with('error', 'El numero no corresponde a ningun usuario');
        } elseif ($beneficiario == $pagador) {
            return back()->with('error', 'No puedes transferirte a ti mismo');
        } elseif ($cuenta->saldo == 0 || $cuenta->saldo <= $request->importe) {
            return back()->with('error', 'No dispones de saldo suficiente');
        }
        
        session(['beneficiario_id' => $beneficiario->id]);
        session(['importe' => $request->importe]);
        
        return view('menos.billetera.billetera_confirmar_transferencia', [
            'beneficiario' => $beneficiario,
            'importe' => $request->importe,
            'cuenta' => $cuenta
        ]);
    }

    public function confirmarRetiro(Request $request)
    {
        $user = auth()->user();
        $cuenta_bancaria = CuentaBancaria::find($request->forma_retiro);
        
        if (!$cuenta_bancaria) {
            return redirect('billetera/resumen')->with('error', 'Debes configurar una cuenta bancaria');
        }

        session(['importe' => $request->importe]);
        
        return view('menos.billetera.billetera_retirar_confirmar', [
            'importe' => $request->importe,
            'user' => $user,
            'cuenta_bancaria' => $cuenta_bancaria
        ]);
    }


    public function retirar()
    {
        $user = auth()->user();

        $cuenta = Cuenta::where('user_id', $user->id)->first();
        $cuentas_bancarias = $user->cuenta_bancaria;

        if ($cuenta->saldo <= 0) {
            return redirect('/billetera/resumen')->with('error', 'No dispone de saldo para esta operación');
        } elseif ($cuentas_bancarias->count() == 0) {
            return redirect('billetera/resumen')->with('error', 'Debes configurar una cuenta bancaria');
        }

        return view('menos.billetera.billetera_retirar', [
            'usuario' => $user,
            'cuenta' => $cuenta,
            'cuentas_bancarias' => $cuentas_bancarias
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
