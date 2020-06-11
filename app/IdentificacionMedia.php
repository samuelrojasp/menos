<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdentificacionMedia extends Model
{
    protected $table = "identificacion_media";

    protected $fillable = [
        'media_id',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function media()
    {
        return $this->hasOne('App\Media');
    }
}
