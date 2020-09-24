<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $guarded = [];

    public function requiredRank()
    {
        return $this->belongsTo('App\Rank');
    }

    public function getLeadershipGenerationAttribute($value)
    {
        if ($value == '') {
            return '';
        } else {
            return $value.'º';
        }
    }

    public function getLeadershipPercentageAttribute($value)
    {
        if ($value == '') {
            return '';
        } else {
            return $value.'%';
        }
    }
}
