<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoTransaccion extends Model
{
    protected $table = "tipos_transaccion";
    
    protected $fillable = [
        'nombre'
    ];

    public function transacciones()
    {
        return $this->hasMany('App\Transaccion');
    }
}
