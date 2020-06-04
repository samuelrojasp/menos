<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\QRCode;
use App\Cuenta;
use App\User;
use App\Movimiento;
use App\Transaccion;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransferenciaRealizada;

class QRCodeController extends Controller
{
    public function generarQR(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        if(Hash::check($data['password'], $user->password)){
            $data['user_id'] = $user->id;
            $data['password'] = null;
            
            $encrypted_message = encrypt($data);

            $data['message'] = $encrypted_message;

            $qr_code = QRCode::create($data);

            $url = route('leerQR', ['message' => $encrypted_message]);

            return view('menos.billetera.show_qr', [
                'url' => $url
            ]);
        }else{
            return back()->with(['error' => 'Contraseña incorrecta']);
        }
    }

    public function pagoQR()
    {
        $user = auth()->user();
        $cuenta = Cuenta::where('user_id', $user->id)->first();

        return view('menos.billetera.pagoqr', [
            'cuenta' => $cuenta
        ]);
    }

    public function readQR($message)
    {
        $qr_code = QRCode::where('message', $message)
                            ->where('used_at', null)
                            ->first();

        $unencrypted_message = decrypt($message);
        $user = auth()->user();

        if(!$qr_code){
            return redirect('/mi_cuenta/resumen')->with(['error' => 'La operación no existe o ha caducado']);
        }else if($unencrypted_message['user_id']==$user->id)
        {
            return redirect('/mi_cuenta/resumen')->with(['error' => 'No puede hacerse un pago QR a sí mismo']);
        }else{
            $qr_code->used_at = date('Y-m-d H:i:s');;
            $qr_code->save();
            
            $cuenta = Cuenta::where('user_id', $user->id)->first();

            $usuario_pagador = User::find($unencrypted_message['user_id']);
            
            $importe = abs($unencrypted_message['importe']);
    
            $cuenta_pagador = Cuenta::where('user_id', $usuario_pagador->id)->first();
    
            $cuenta_pagador->saldo = $cuenta_pagador->saldo - $importe;
    
            $usuario_beneficiario = auth()->user();
    
            $cuenta_beneficiario = Cuenta::where('user_id', $usuario_beneficiario->id)->first();
    
            $cuenta_beneficiario->saldo = $cuenta_beneficiario->saldo + $importe;
    
            $transaccion = new Transaccion();
    
            $transaccion->tipo_transaccion_id = 4;
            $transaccion->glosa = "Pago QR entre usuarios";
            $transaccion->save();

            $movimiento_pagador = new Movimiento();

            $movimiento_pagador->transaccion_id = $transaccion->id;
            $movimiento_pagador->glosa = "Pago QR a ".$usuario_beneficiario->name;
            $movimiento_pagador->cuenta_id = $cuenta_pagador->id;
            $movimiento_pagador->importe = $importe * -1;
            $movimiento_pagador->saldo_cuenta = $cuenta_pagador->saldo;

            $movimiento_beneficiario = new Movimiento();

            $movimiento_beneficiario->transaccion_id = $transaccion->id;
            $movimiento_beneficiario->glosa = "Pago QR de ".$usuario_pagador->name;
            $movimiento_beneficiario->cuenta_id = $cuenta_beneficiario->id;
            $movimiento_beneficiario->importe = $importe;
            $movimiento_beneficiario->saldo_cuenta = $cuenta_beneficiario->saldo;
            

            $movimiento_pagador->save();
            $movimiento_beneficiario->save();
            $cuenta_pagador->save();
            $cuenta_beneficiario->save();

            $email_recipients = array($usuario_pagador->email, $usuario_beneficiario->email);


            Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));
    
            return view('menos.billetera.pago_realizado', [
                'usuario_pagador' => $usuario_pagador,
                'movimiento_beneficiario' => $movimiento_beneficiario
            ]);
        }
    }
}
