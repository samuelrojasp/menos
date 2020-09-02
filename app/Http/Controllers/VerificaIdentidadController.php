<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Identificacion;
use App\IdentificacionMedia;
use App\Media;

class VerificaIdentidadController extends Controller
{
    public function showIdentificationVerificationForm()
    {
        return view('menos.cuenta.identification_verification_form');
    }

    public function uploadsFiles(Request $request)
    {
        $user = auth()->user();
        $filename = date('YmdHis').'_'.$user->rut;

        $anverso = new Media();
        $anverso->filename = $filename.'_anverso.'.$request->anverso->extension();
        $anverso->description = 'Anverso cédula '.$user->name." RUT ".$user->rut;

        $reverso = new Media();
        $reverso->filename = $filename.'_reverso.'.$request->reverso->extension();
        $reverso->description = 'Reverso cédula '.$user->name." RUT ".$user->rut;

        $request->anverso->storeAs('/', $anverso->filename);
        $request->reverso->storeAs('/', $reverso->filename);

        $anverso->save();
        $reverso->save();

        $identificacion = new Identificacion();
        $identificacion->user_id = $user->id;
        $identificacion->descripcion = "Verificación cédula ".$user->name." RUT ".$user->rut;
        $identificacion->save();

        $id_media_anverso = new IdentificacionMedia();
        $id_media_anverso->media_id = $anverso->id;
        $id_media_anverso->identificacion_id = $identificacion->id;
        $id_media_anverso->save();

        $id_media_reverso = new IdentificacionMedia();
        $id_media_reverso->media_id = $reverso->id;
        $id_media_reverso->identificacion_id = $identificacion->id;
        $id_media_reverso->save();

        return redirect('/mi_cuenta/resumen')->with('success', 'Tu cédula se encuentra en revisión, serás notificado cuando sea validada');
    }
}
