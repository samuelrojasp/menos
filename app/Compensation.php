<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Compensation extends Model
{
    protected $guarded = [];

    protected $table = 'compensations';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
