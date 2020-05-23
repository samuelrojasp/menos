<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = "transacciones";

    protected $fillable = [
        'tipo_transaccion_id',
        'glosa',
        'mshop_order_id'
    ];

    public function tipoTransaccion()
    {
        return $this->hasOne('App\TipoTransaccion');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Movimiento');
    }

    public function cuentas()
    {
        return $this->hasMany('App\Cuentas', 'App\Movimiento');
    }
}
