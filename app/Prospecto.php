<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    protected $guarded = [];

    public function sponsor()
    {
        return $this->belongsTo('App\User', 'sponsor_id');
    }
}
