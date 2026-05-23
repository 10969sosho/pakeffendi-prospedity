<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvisorGuide extends Model
{
    protected $fillable = [
        'title',
        'content',
        'reference_url',
        'reference_urls',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'reference_urls' => 'array',
    ];
}
