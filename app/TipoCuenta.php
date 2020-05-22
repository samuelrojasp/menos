<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCuenta extends Model
{
    protected $table = "tipos_cuenta";
    
    protected $fillable = [
        'nombre'
    ];

    public function cuentas()
    {
        return $this->hasMany('App\Cuenta');
    }
}
