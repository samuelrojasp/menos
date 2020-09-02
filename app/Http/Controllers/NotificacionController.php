<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notificacion;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $notificaciones = Notificacion::where('user_id', $user->id)
                                        ->orderBy('created_at', 'DESC');

        $notificaciones->update(['leido' => '1']);
                                        
        $notificaciones = $notificaciones->get();

        $request->session()->forget(['notificaciones']);

        return view('menos.cuenta.notificaciones', [
            'notificaciones' => $notificaciones
        ]);
    }
}
