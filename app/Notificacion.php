<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $fillable = [
        'text',
        'leido',
        'user_id'
    ];

    protected $table = "notificaciones";

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
