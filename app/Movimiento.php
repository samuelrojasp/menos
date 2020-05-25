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

    protected $appends = [
        'human_date',
        'human_hour'
    ];

    public function transaccion()
    {
        return $this->belongsTo('App\Transaccion');
    }

    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta');
    }

    public function getHumanDateAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['created_at']));
    }

    public function getHumanHourAttribute()
    {
        return date('H:i', strtotime($this->attributes['created_at']));
    }
}
