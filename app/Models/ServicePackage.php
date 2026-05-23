<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'normal_price',
        'discount_price',
        'is_active',
        'order',
    ];

    protected $casts = [
        'normal_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
