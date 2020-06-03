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

class TransaccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_timestamp = base_convert($id, 36, 10);
        $id = substr(strrev($id_timestamp), 14);

        $user = auth()->user();

        $transaccion = Transaccion::find($id);
        $movimientos = $transaccion->movimientos;

        $movimiento_cargo = $movimientos->where('cargo_abono', 'cargo')->first();                                                   
        $movimiento_abono = $movimientos->where('cargo_abono', 'abono')->first();                                                    

        if($movimiento_cargo){
            $transaccion->cuenta_cargo = $movimiento_cargo->cuenta->user->telephone;
            $transaccion->nombre_cargo = $movimiento_cargo->cuenta->user->name;
            $transaccion->importe = abs($movimiento_cargo->importe);
        }

        if($movimiento_abono){
            $transaccion->cuenta_abono = $movimiento_abono->cuenta->user->telephone;
            $transaccion->nombre_abono = $movimiento_abono->cuenta->user->name;
            $transaccion->importe = $movimiento_abono->importe;
        }

        

        if(in_array($user->telephone, [$transaccion->cuenta_cargo, $transaccion->cuenta_abono])){
            return view('menos.billetera.billetera_comprobante', [
                'transaccion' => $transaccion
            ]);
            
        }else{
            abort(401);
        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function depositar(Request $request)
    {
        $data = $request;

        $usuario = auth()->user();

        $cuenta = Cuenta::find($data->cuenta_id);

        $cuenta->saldo = $cuenta->saldo + abs($data->importe);

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 4;
        $transaccion->glosa = "Depósito en Efectivo";
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta->id;
        $movimiento->importe = $data->importe;
        $movimiento->saldo_cuenta = $cuenta->saldo;

        $movimiento->save();
        $cuenta->save();


        return redirect('/billetera/resumen')->with('success', 'La operación se realizó exitosamente');;
    }

    public function transferir(Request $request)
    {
        $data = $request;

        $usuario_pagador = auth()->user();
        
        $codigo_verificacion = CodigoVerificacion::where('telephone', $usuario_pagador->telephone)
                                                ->where('status', 1)
                                                ->orderBy('created_at', 'desc')
                                                ->first();

        if($request->verification_code != $codigo_verificacion->password){
            return back()->with(['error' => '¡Código de verificación erróneo!']);
        }else{
            $importe = abs($request->session()->get('importe'));

            $cuenta_pagador = Cuenta::where('user_id', $usuario_pagador->id)->first();

            $cuenta_pagador->saldo = $cuenta_pagador->saldo - $importe;

            $usuario_beneficiario = User::find($request->session()->get('beneficiario_id'));

            $cuenta_beneficiario = Cuenta::where('user_id', $usuario_beneficiario->id)->first();

            $cuenta_beneficiario->saldo = $cuenta_beneficiario->saldo + $importe;

            $transaccion = new Transaccion();

            $transaccion->tipo_transaccion_id = 4;
            $transaccion->glosa = "Transferencia entre usuarios";
            $transaccion->save();

            $movimiento_pagador = new Movimiento();

            $movimiento_pagador->transaccion_id = $transaccion->id;
            $movimiento_pagador->glosa = "Transferencia a ".$usuario_beneficiario->name;
            $movimiento_pagador->cuenta_id = $cuenta_pagador->id;
            $movimiento_pagador->importe = $importe * -1;
            $movimiento_pagador->saldo_cuenta = $cuenta_pagador->saldo;

            $movimiento_beneficiario = new Movimiento();

            $movimiento_beneficiario->transaccion_id = $transaccion->id;
            $movimiento_beneficiario->glosa = "Transferencia de ".$usuario_beneficiario->name;
            $movimiento_beneficiario->cuenta_id = $cuenta_beneficiario->id;
            $movimiento_beneficiario->importe = $importe;
            $movimiento_beneficiario->saldo_cuenta = $cuenta_beneficiario->saldo;
            

            $movimiento_pagador->save();
            $movimiento_beneficiario->save();
            $cuenta_pagador->save();
            $cuenta_beneficiario->save();

            Mail::to($usuario_pagador)->send(new TransferenciaRealizada($transaccion));


            return redirect('/billetera/resumen')->with('success', 'La operación se realizó exitosamente');
        }
    }

    public function retirar(Request $request)
    {
        $data = $request;

        $usuario = auth()->user();

        $cuenta = Cuenta::find($data->cuenta_id);

        $cuenta->saldo = $cuenta->saldo - abs($data->importe);

        $transaccion = new Transaccion();

        $transaccion->tipo_transaccion_id = 4;
        $transaccion->glosa = "Retiro en Efectivo";
        $transaccion->save();

        $movimiento = new Movimiento();

        $movimiento->transaccion_id = $transaccion->id;
        $movimiento->glosa = $transaccion->glosa;
        $movimiento->cuenta_id = $cuenta->id;
        $movimiento->importe = $data->importe * -1;
        $movimiento->saldo_cuenta = $cuenta->saldo;

        $movimiento->save();
        $cuenta->save();


        return redirect('/billetera/resumen')->with('success', 'La operación se realizó exitosamente');;
    }

    public function verificar()
    {
        return "vefificando";
    }
}
