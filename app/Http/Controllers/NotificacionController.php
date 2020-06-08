<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notificacion;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::all();

        return view('menos.cuenta.notificaciones', [
            'notificaciones' => $notificaciones
        ]);
    }
}
