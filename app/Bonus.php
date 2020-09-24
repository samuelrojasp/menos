<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $guarded = [];

    public function rank()
    {
        return $this->belongsTo('App\Rank');
    }
}
