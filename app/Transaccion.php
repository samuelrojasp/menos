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
        return $this->hasManyThrough('App\Cuentas', 'App\Movimiento');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function verified_by()
    {
        return $this->belongsTo('App\User');
    }

    public function getEncodedIdAttribute()
    {
        $cadena = $this->created_at.$this->id."1";
        $reversa = strrev($cadena);
        $base36 = base_convert($reversa, 10, 36);
        
        return $base36;
    }
}
