<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PicProfile extends Model
{
    protected $fillable = [
        'ref_number',
        'name',
        'email',
        'whatsapp_number',
    ];
}
