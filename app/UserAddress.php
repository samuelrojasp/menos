<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'users_address';

    protected $fillable = [
        'salutation',
        'firstname',
        'lastname',
        'address1',
        'address2',
        'address3',
        'postal',
        'city',
        'state',
        'langid',
        'countryid',
        'telephone',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
