<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identificacion extends Model
{
    protected $table = "identificaciones";

    protected $fillable = [
        'user_id',
        'descripcion',
        'verified_at',
        'verificada_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function verificador()
    {
        return $this->belongsTo('App\User', 'verificada_id');
    }

    public function identificacionMedia()
    {
        return $this->hasMany('App\IdentificacionMedia');
    }
}
