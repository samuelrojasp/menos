<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\QRCode;
use App\Cuenta;

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

        if(!$qr_code){
            return redirect('/mi_cuenta/resumen')->with(['error' => 'La operación no existe o ha caducado']);
        }else{
            $qr_code->used_at = date('Y-m-d H:i:s');;

            $user = auth()->user();
            $cuenta = Cuenta::where('user_id', $user->id)->first();

            $unencrypted_message = decrypt($message);

            dd($unencrypted_message);
        }
    }
}
