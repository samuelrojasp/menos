<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProspectActivity extends Model
{
    protected $guarded = [];
    
    public function prospecto()
    {
        return $this->belongsTo('App\Prospecto', 'prospect_id');
    }
}
