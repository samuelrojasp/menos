<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    protected $fillable = [
        'nombre',
        'user_id',
        'tipo_cuenta_id',
        'saldo'
    ];

    public function tipoCuenta()
    {
        return $this->hasOne('App\TipoCuenta');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Movimiento');
    }


    public function transacciones()
    {
        return $this->hasManyThrough('App\Transaccion', 'App\Movimiento');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
