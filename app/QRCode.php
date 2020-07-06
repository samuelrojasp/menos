<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    protected $fillable = [
        'message',
        'used_at'
    ];

    protected $table = "qr_codes";
}
