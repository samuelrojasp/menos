<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "menos_media";

    protected $fillable =[
        'filename',
        'descripcion',
    ];
}
