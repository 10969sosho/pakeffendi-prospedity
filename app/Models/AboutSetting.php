<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = [
        'hero_background',
        'hero_title',
        'page_title',
        'page_description',
    ];
}
