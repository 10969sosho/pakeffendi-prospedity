<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesOrder extends Model
{
    protected $fillable = [
        'so_number',
        'customer_full_name',
        'company_name',
        'whatsapp_number',
        'email',
        'pic_number',
        'service_package_id',
        'package_name',
        'normal_price',
        'discount_price',
        'final_price',
        'status',
    ];

    protected $casts = [
        'normal_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    public function servicePackage(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function getRouteKeyName(): string
    {
        return 'so_number';
    }
}
