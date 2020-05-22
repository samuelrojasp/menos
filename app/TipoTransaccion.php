<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $fillable = [
        'nombre'
    ];

    public function transacciones()
    {
        return $this->hasMany('App\Transaccion');
    }
}
