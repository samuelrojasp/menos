<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;
use App\Movimiento;
use App\Cuenta;
use App\User;
use App\Mail\TransferenciaRealizada;
use Illuminate\Support\Facades\Mail;
use App\CodigoVerificacion;
use Illuminate\Support\Facades\Hash;
use App\Notificacion;

class TransaccionController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_timestamp = strrev(base_convert($id, 36, 10));
        
        $id = substr($id_timestamp, 14, -1);

        $user = auth()->user();

        $transaccion = Transaccion::find($id);
        $movimientos = $transaccion->movimientos;

        $movimiento_cargo = $movimientos->where('cargo_abono', 'cargo')->first();
        $movimiento_abono = $movimientos->where('cargo_abono', 'abono')->first();

        if ($movimiento_cargo) {
            $transaccion->cuenta_cargo = $movimiento_cargo->cuenta->user->telephone;
            $transaccion->nombre_cargo = $movimiento_cargo->cuenta->user->name;
            $transaccion->importe = abs($movimiento_cargo->importe);
        }

        if ($movimiento_abono) {
            $transaccion->cuenta_abono = $movimiento_abono->cuenta->user->telephone;
            $transaccion->nombre_abono = $movimiento_abono->cuenta->user->name;
            $transaccion->importe = $movimiento_abono->importe;
        }

        if (in_array($user->telephone, [$transaccion->cuenta_cargo, $transaccion->cuenta_abono])) {
            return view('menos.billetera.billetera_comprobante', [
                'transaccion' => $transaccion
            ]);
        } else {
            abort(401);
        }
    }

    public function depositar(Request $request)
    {
        $data = $request;

        $data->importe = $request->session()->get('importe');

        $usuario = auth()->user();

        $cuenta = $usuario->cuentas->first();

        if (!Hash::check($request->password, $usuario->password)) {
            return redirect('/billetera/retirar')->with(['error' => '¡Password erróneo!']);
        }

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 4;
        $transaccion->glosa = "Carga $cuenta->nombre";
        $transaccion->user_id = $usuario->id;
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta->id;
        $movimiento->importe = $data->importe;
        $movimiento->saldo_cuenta = $cuenta->saldo;
        $movimiento->cargo_abono = 'abono';

        $movimiento->save();
        $cuenta->save();

        $email_recipients = array($usuario->email);

        if ($request->otro_mail != null) {
            array_push($email_recipients, $request->otro_mail);
        }

        Notificacion::create([
            'text' => "Recargaste tu $cuenta->nombre por un monto de $movimiento->importe (pendiente de confirmación)",
            'leido' => 0,
            'user_id' => $usuario->id
        ]);

        Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));

        return redirect('/billetera/transaccion/'.$transaccion->encoded_id)->with('success', 'La recarga esta pendiente de confirmación');
        ;
    }

    public function transferir(Request $request)
    {
        $data = $request;

        $usuario_pagador = auth()->user();

        if (!Hash::check($request->password, $usuario_pagador->password)) {
            return redirect('/billetera/transferir')->with('error', '¡Password erróneo!');
        } else {
            $importe = abs($request->session()->get('importe'));

            $cuenta_pagador = Cuenta::where('user_id', $usuario_pagador->id)->first();

            $cuenta_pagador->saldo = $cuenta_pagador->saldo - $importe;

            $usuario_beneficiario = User::find($request->session()->get('beneficiario_id'));

            $cuenta_beneficiario = Cuenta::where('user_id', $usuario_beneficiario->id)->first();

            $cuenta_beneficiario->saldo = $cuenta_beneficiario->saldo + $importe;

            $transaccion = new Transaccion();

            $transaccion->tipo_transaccion_id = 5;
            $transaccion->glosa = "Transferencia entre usuarios";
            $transaccion->verified_at = date('Y-m-d H:i:s');
            $transaccion->save();

            $movimiento_pagador = new Movimiento();

            $movimiento_pagador->transaccion_id = $transaccion->id;
            $movimiento_pagador->glosa = "Transferencia a ".$usuario_beneficiario->name;
            $movimiento_pagador->cuenta_id = $cuenta_pagador->id;
            $movimiento_pagador->importe = $importe * -1;
            $movimiento_pagador->saldo_cuenta = $cuenta_pagador->saldo;
            $movimiento_pagador->cargo_abono = 'cargo';

            $movimiento_beneficiario = new Movimiento();

            $movimiento_beneficiario->transaccion_id = $transaccion->id;
            $movimiento_beneficiario->glosa = "Transferencia de ".$usuario_beneficiario->name;
            $movimiento_beneficiario->cuenta_id = $cuenta_beneficiario->id;
            $movimiento_beneficiario->importe = $importe;
            $movimiento_beneficiario->saldo_cuenta = $cuenta_beneficiario->saldo;
            $movimiento_beneficiario->cargo_abono = 'abono';
            

            $movimiento_pagador->save();
            $movimiento_beneficiario->save();
            $cuenta_pagador->save();
            $cuenta_beneficiario->save();

            $movimientos = $transaccion->movimientos;

            $movimiento_cargo = $movimientos->where('cargo_abono', 'cargo')->first();
            $movimiento_abono = $movimientos->where('cargo_abono', 'abono')->first();

            if ($movimiento_cargo) {
                $transaccion->cuenta_cargo = $movimiento_cargo->cuenta->user->telephone;
                $transaccion->nombre_cargo = $movimiento_cargo->cuenta->user->name;
                $transaccion->importe = abs($movimiento_cargo->importe);
            }

            if ($movimiento_abono) {
                $transaccion->cuenta_abono = $movimiento_abono->cuenta->user->telephone;
                $transaccion->nombre_abono = $movimiento_abono->cuenta->user->name;
                $transaccion->importe = $movimiento_abono->importe;
            }

            $email_recipients = array($usuario_pagador->email, $usuario_beneficiario->email);

            if ($request->otro_mail != null) {
                array_push($email_recipients, $request->otro_mail);
            }

            $transaccion->comentario = $request->comentario ?? "";

            Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));

            $request->session()->forget(['beneficiario_id']);
            $request->session()->forget(['importe']);

            Notificacion::create([
                'text' => 'Transferiste '.$transaccion->importe.' a '.$usuario_beneficiario->name,
                'leido' => 0,
                'user_id' => $usuario_pagador->id
            ]);

            Notificacion::create([
                'text' => 'Recibiste '.$transaccion->importe.' de '.$usuario_pagador->name,
                'leido' => 0,
                'user_id' => $usuario_beneficiario->id
            ]);

            return redirect('/billetera/transaccion/'.$transaccion->encoded_id)->with('success', 'La operación se realizó exitosamente');
        }
    }

    public function retirar(Request $request)
    {
        $data = $request;

        $data->importe = $request->session()->get('importe');

        $usuario = auth()->user();

        $cuenta_bancaria = $usuario->cuenta_bancaria->first();

        if (!Hash::check($request->password, $usuario->password)) {
            return redirect('/billetera/retirar')->with(['error' => '¡Password erróneo!']);
        }

        if ($cuenta_bancaria == null) {
            return redirect('billetera/resumen')->with(['error' => 'Debes configurar una cuenta bancaria']);
        }

        $cuenta = $usuario->cuentas->first();

        $cuenta->saldo = $cuenta->saldo - abs($data->importe);

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 1;
        $transaccion->glosa = "Retiro a Cuenta Bancaria Nº ".$cuenta_bancaria->numero_cuenta." ".$cuenta_bancaria->banco->nombre;
        $transaccion->verified_at = date('Y-m-d H:i:s');
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta->id;
        $movimiento->importe = $data->importe * -1;
        $movimiento->saldo_cuenta = $cuenta->saldo;
        $movimiento->cargo_abono = 'cargo';

        $movimiento->save();
        $cuenta->save();

        $email_recipients = array($usuario->email);

        if ($request->otro_mail != null) {
            array_push($email_recipients, $request->otro_mail);
        }

        Notificacion::create([
            'text' => 'Retiraste a '.$transaccion->importe.' a tu cuenta Nº '.$cuenta_bancaria->numero_cuenta.' del '.$cuenta_bancaria->banco->nombre,
            'leido' => 0,
            'user_id' => $usuario->id
        ]);

        Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));

        return redirect('/billetera/transaccion/'.$transaccion->encoded_id)->with('success', 'La operación se realizó exitosamente');
    }

    public function verificarTransaccionIndex()
    {
        $transacciones = Transaccion::where('tipo_transaccion_id', 4)->orderBy('created_at', 'desc')->get();
        
        return view('menos.admin.verificacion_transacciones', [
            'transacciones' => $transacciones
        ]);
    }

    public function verificarTransaccionUpdate($id)
    {
        $transaccion = Transaccion::find($id);
        $movimiento = $transaccion->movimientos->first();
        $cuenta = $movimiento->cuenta;

        $saldo_anterior = $cuenta->saldo;

        $nuevo_saldo = $saldo_anterior + $movimiento->importe;
        $fecha = date('Y-m-d H:i:s');
        $verified_by = auth()->user()->id;
        
        $movimiento->saldo_cuenta = $nuevo_saldo;
        $cuenta->saldo = $nuevo_saldo;
        $transaccion->verified_at = $fecha;
        $transaccion->verified_by = $verified_by;

        $movimiento->save();
        $cuenta->save();
        $transaccion->save();

        Notificacion::create([
            'text' => "La recarga a tu $cuenta->nombre por un monto de $movimiento->importe ha sido verificada",
            'leido' => 0,
            'user_id' => $transaccion->user_id
        ]);

        Mail::to($transaccion->user->email)->send(new TransferenciaRealizada($transaccion));

        return redirect('/administracion/verifica_transacciones');
    }
}
