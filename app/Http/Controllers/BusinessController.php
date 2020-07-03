<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;
use App\Movimiento;
use App\Notificacion;
use Illuminate\Support\Facades\Hash;
use App\Mail\TransferenciaRealizada;
use Illuminate\Support\Facades\Mail;
use App\User;

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

    public function userMlmAfiliation(Request $request)
    {
        $user = auth()->user();
        if(!$request->telephone){
            $sponsor = User::where('telephone', '+56953118581')->first();
        }else{
            $sponsor = User::where('telephone', $request->telephone)->first();
        }

        if(!Hash::check($request->password, $user->password)){
            return redirect()->back()->with(['error' => '¡PIN incorrecto!']);
        }

        $cuenta = $user->cuentas()->first();
        $total = 290000;

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 2;
        $transaccion->glosa = "Compra Plan de Afiliado a Business";
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta->id;
        $movimiento->importe = $total * -1;
        $movimiento->saldo_cuenta = $cuenta->saldo - $total;
        $cuenta->saldo = $cuenta->saldo - $total;
        $movimiento->cargo_abono = 'cargo';

        $movimiento->save();
        $cuenta->save();

        $user->sponsor_id = $sponsor->id;
        $user->assignRole('afiliate');
        $user->save();

        $email_recipients = array($user->email);

        Notificacion::create([
            'text' => 'Compraste un plan de Afiliación Business',
            'leido' => 0,
            'user_id' => $user->id
        ]);

        Mail::to($email_recipients)->send(new TransferenciaRealizada($transaccion));

        return view('menos.unete.thankyou', [
            'user' => $user
        ]);
    }

    public function office()
    {
        return view('menos.office.index');
    }

    public function binary()
    {

        return view('menos.office.binaria');
    }

    public function sponsors()
    {

        return view('menos.office.sponsors');
    }

    public function prospects()
    {
        return view('menos.office.prospects');
    }

    public function apiGetBinaryTreeAfiliates($id)
    {
        $user = User::find($id);

        $descendants = $user->binaryDescendants->toArray();

        $user->binary_parent_id = "";

        array_push($descendants, $user);

        return $descendants;
    }

    public function apiGetSponsorTreeAfiliates($id)
    {
        $user = User::find($id);

        $descendants = $user->sponsorDescendants->toArray();
        
        $user->sponsor_id = "";

        array_push($descendants, $user);

        return $descendants;
    }
}
