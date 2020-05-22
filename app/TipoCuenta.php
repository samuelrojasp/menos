<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCuenta extends Model
{
    protected $fillable = [
        'nombre'
    ];

    public function cuentas()
    {
        return $this->hasMany('App\Cuenta');
    }
}
