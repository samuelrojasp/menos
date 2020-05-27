<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoVerificacion extends Model
{
    protected $table = "codigos_verificacion";
    
    protected $fillable = [
        "telephone",
        "password",
        "status"
    ];
}
