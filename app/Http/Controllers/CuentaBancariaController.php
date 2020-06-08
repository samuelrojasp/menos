<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banco;
use App\CuentaBancaria;

class CuentaBancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $cuentas = CuentaBancaria::where('user_id', $user->id)->get();

        return view('menos.cuenta.cuenta_bancaria_index', [
            'user' => $user,
            'cuentas' => $cuentas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        
        $bancos = Banco::where('tipo', 'Bancos')->get();

        return view('menos.cuenta.cuenta_bancaria_create',[
            'bancos' => $bancos,
            'user' => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $cuenta_bancaria = new CuentaBancaria();
        $cuenta_bancaria->fill($request->all());
        $cuenta_bancaria->user_id = $user->id;
        $cuenta_bancaria->save();

        return redirect('/mi_cuenta/cuenta_bancaria');
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
        $user = auth()->user();

        $cuenta = CuentaBancaria::where('user_id', $user->id)
                        ->where('id', $id)
                        ->first();

        if($cuenta){
            $bancos = Banco::where('tipo', 'Bancos')->get();

            return view('menos.cuenta.cuenta_bancaria_edit',[
                'bancos' => $bancos,
                'user' => $user,
                'cuenta_bancaria' => $cuenta
            ]);
        }else{
            return redirect('/mi_cuenta/cuenta_bancaria')->with(['error' => 'Ha ocurrido un error']);
        }
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
        $user = auth()->user();

        $cuenta_bancaria = $user->cuenta_bancaria->where('id', $id)->first();

        if($cuenta_bancaria){
            $cuenta_bancaria->fill($request->all());
            $cuenta_bancaria->save();

            return redirect('/mi_cuenta/cuenta_bancaria');
        }else{
            return redirect('/mi_cuenta/cuenta_bancaria')->with(['error' => 'Ha ocurrido un error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $cuenta_bancaria = $user->cuenta_bancaria->where('id', $id)->first();

        if($cuenta_bancaria){
            $cuenta_bancaria->delete();

            return redirect('/mi_cuenta/cuenta_bancaria');
        }else{
            return redirect('/mi cuenta/cuenta_bancaria')->with(['error' => 'Ha ocurrido un error']);
        }
    }
}
