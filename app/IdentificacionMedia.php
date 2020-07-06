<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdentificacionMedia extends Model
{
    protected $table = "identificacion_media";

    protected $fillable = [
        'media_id',
        'identificacion_id'
    ];

    public function identificacion()
    {
        return $this->belongsTo('App\Identificacion');
    }

    public function media()
    {
        return $this->belongsTo('App\Media');
    }
}
