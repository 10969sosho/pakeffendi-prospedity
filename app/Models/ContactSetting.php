<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'contact_title',
        'contact_description',
        'email',
        'whatsapp_url',
        'facebook_url',
        'instagram_url',
        'tiktok_url',
        'address',
        'maps_url',
        'seo_title',
        'seo_description',
        'seo_keywords',
    ];
}
