<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $fillable = [
        'user_id',
        'banco_id',
        'tipo_cuenta',
        'numero_cuenta'
    ];

    protected $table = "cuentas_bancarias";

    public function banco()
    {
        return $this->belongsTo('App\Banco');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTipoCuentaAttribute($tipo_cuenta)
    {
        switch ($tipo_cuenta) {
            case 1:
                return "Cuenta Corriente";
                break;
            case 2:
                return "Cuenta Vista";
                break;
            case 3:
                return "Cuenta de Ahorro";
                break;
        }
    }
}
