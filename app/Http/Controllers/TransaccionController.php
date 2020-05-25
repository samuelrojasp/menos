<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;
use App\Movimiento;
use App\Cuenta;
use App\User;

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
        //
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


        return redirect('/admin2/dashboard');
    }

    public function transferir(Request $request)
    {
        $data = $request;

        $importe = abs($data->importe);

        $usuario_pagador = auth()->user();

        $cuenta_pagador = Cuenta::where('user_id', $usuario_pagador->id)->first();

        $cuenta_pagador->saldo = $cuenta_pagador->saldo - $importe;

        $usuario_beneficiario = User::find($data->user_id);

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


        return redirect('/admin2/dashboard');
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


        return redirect('/admin2/dashboard');
    }

    public function verificar()
    {
        return "vefificando";
    }
}
