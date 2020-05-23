<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'transaccion_id',
        'cuenta_id',
        'importe',
        'saldo_cuenta'
    ];

    public function transaccion()
    {
        return $this->belongsTo('App\Transaccion');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['created_at']));
    }
}
