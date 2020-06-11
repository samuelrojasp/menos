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

        $request->anverso->storeAs('/', $filename.'_anverso.'.$request->anverso->extension());
        $request->reverso->storeAs('/', $filename.'_reverso.'.$request->reverso->extension());

        $anverso_file = new Media();
        $anverso_file->filename = $filename.'_anverso';
        $anverso_file->description = 'Anverso cédula '.$user->name." RUT ".$user->rut;
        $anverso_file->save();

        $reverso_file = new Media();
        $reverso_file->filename = $filename.'_reverso';
        $reverso_file->description = 'Reverso cédula '.$user->name." RUT ".$user->rut;
        $reverso_file->save();

        $id_media_anverso = new IdentificacionMedia();
        $id_media_anverso->media_id = $anverso_file->id;
        $id_media_anverso->user_id = $user->id;
        $id_media_anverso->save();

        $id_media_reverso = new IdentificacionMedia();
        $id_media_reverso->media_id = $reverso_file->id;
        $id_media_reverso->user_id = $user->id;
        $id_media_reverso->save();

        $identificacion = new Identificacion();
        $identificacion->user_id = $user->id;
        $identificacion->descripcion = "Verificación cédula ".$user->name." RUT ".$user->rut; 
        $identificacion->save();

        return redirect('/mi_cuenta/resumen')->with('success', 'Tu cédula se encuentra en revisión, serás notificado cuando sea validada');
    }
}
