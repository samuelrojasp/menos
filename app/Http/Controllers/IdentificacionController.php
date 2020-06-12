<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Identificacion;
use App\Notificacion;

class IdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $verificaciones = Identificacion::all();

        return view('menos.admin.verificaciones_pendientes', [
            'user' => $user,
            'verificaciones' => $verificaciones
        ]);
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
        $verificacion = Identificacion::find($id);

        return view('menos.admin.verificaciones_pendientes_show', [
            'verificacion' => $verificacion
        ]);
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

        $verificacion = Identificacion::find($id);

        return view('menos.admin.verificaciones_pendientes_edit', [
            'user' => $user,
            'verificacion' => $verificacion
        ]);
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

        $verificacion = Identificacion::find($id);

        if(isset($request->verificado)){
            $verificacion->verified_at = date('Y-m-d H:i:s');
            $verificacion->verificada_id = $user->id;
            $verificacion->save();

            Notificacion::create([
                'text' => 'Tu identidad ha sido verificada',
                'leido' => 0,
                'user_id' => $verificacion->user->id
            ]);
        }else{
            $mensaje = $request->descripcion;
            $verificacion->verificada_id = $user->id;
            $verificacion->descripcion = $verificacion->descripcion." OBS: ".$mensaje;
            $verificacion->save();

            Notificacion::create([
                'text' => 'Tu identidad no pudo ser verificada. Motivo: '.$mensaje,
                'leido' => 0,
                'user_id' => $verificacion->user->id
            ]);
        }

        return redirect('/administracion/verifica_identidad');
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
}
