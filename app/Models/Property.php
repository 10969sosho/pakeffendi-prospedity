<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Str;

class Property extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'property_number',
        'transaction_number',
        'admin_id',
        'views',
        'title',
        'slug',
        'description',
        'property_type',
        'property_type_id',
        'property_status',
        'expired_date',
        'pic_ref_number',
        'pic_name',
        'pic_email',
        'pic_whatsapp_number',
        'price',
        'price_monthly',
        'price_yearly',
        'price_freehold',
        'price_leasehold',
        'leasehold_period',
        'has_monthly',
        'has_yearly',
        'location_text',
        'area',
        'latitude',
        'longitude',
        'land_size',
        'building_size',
        'dimension',
        'direction',
        'year_of_build',
        'floor_level',
        'view',
        'style_design',
        'surrounding',
        'imb',
        'zone',
        'living_room_type',
        'dining_room_type',
        'kitchen_type',
        'bedroom',
        'bathroom',
        'ensuite_bathroom',
        'extra_room',
        'storage',
        'swimming_pool',
        'terrace',
        'balcony',
        'shower',
        'furniture',
        'electricity_power',
        'ac_count',
        'water_source',
        'internet',
        'parking_type',
        'parking_size',
        'monthly_cost_included',
        'show_monthly_cost',
        'banjar_security',
        'cleaning_service',
        'pool_maintenance',
        'garden_maintenance',
        'bin_collection',
        'electricity_included',
        'internet_included',
        'advisor_notes',
        'is_featured',
        'featured_order',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    protected $casts = [
        'price' => 'decimal:2',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'price_freehold' => 'decimal:2',
        'price_leasehold' => 'decimal:2',
        'leasehold_period' => 'integer',
        'expired_date' => 'date',
        'has_monthly' => 'boolean',
        'has_yearly' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'land_size' => 'decimal:2',
        'building_size' => 'decimal:2',
        'swimming_pool' => 'boolean',
        'terrace' => 'boolean',
        'balcony' => 'boolean',
        'shower' => 'boolean',
        'banjar_security' => 'boolean',
        'cleaning_service' => 'boolean',
        'pool_maintenance' => 'boolean',
        'garden_maintenance' => 'boolean',
        'bin_collection' => 'boolean',
        'electricity_included' => 'boolean',
        'internet_included' => 'boolean',
        'show_monthly_cost' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function coverPhoto(): ?Media
    {
        $photos = $this->getMedia('photos');

        if ($photos->isEmpty()) {
            return null;
        }

        $cover = $photos->first(function (Media $media) {
            return $media->getCustomProperty('is_cover') === true;
        });

        return $cover ?: $photos->first();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            // Auto-generate property number if not set
            if (empty($property->property_number)) {
                $property->property_number = self::generatePropertyNumber();
            }

            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });

        static::updating(function ($property) {
            if ($property->isDirty('title') && empty($property->slug)) {
                $property->slug = Str::slug($property->title);
            }
        });
    }

    /**
     * Generate property number with format: PN + YY + MM + NNNNN
     * Example: PN251200001 (Property Number 2025 Month 12 Sequence 1)
     */
    public static function generatePropertyNumber(): string
    {
        $year = date('y'); // 2-digit year (25 for 2025)
        $month = date('m'); // 2-digit month (12 for December)
        
        // Get the last property number for this month
        $lastProperty = self::where('property_number', 'like', "PN{$year}{$month}%")
            ->orderBy('property_number', 'desc')
            ->first();
        
        if ($lastProperty && $lastProperty->property_number) {
            // Extract sequence number from last property number
            $lastSequence = (int) substr($lastProperty->property_number, -5);
            $sequence = $lastSequence + 1;
        } else {
            // First property of the month
            $sequence = 1;
        }
        
        // Format: PN + YY + MM + NNNNN (5 digits)
        return sprintf('PN%s%s%05d', $year, $month, $sequence);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the admin user who created this property
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
