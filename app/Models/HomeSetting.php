<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_background',
        'hero_logo',
        'facebook_url',
        'instagram_url',
        'whatsapp_url',
        'tiktok_url',
        'email',
        'contact_title',
        'contact_description',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];
}


