<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'inquiry_number',
        'name',
        'email',
        'whatsapp',
        'subject',
        'property_number',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inquiry) {
            // Auto-generate inquiry number if not set
            if (empty($inquiry->inquiry_number)) {
                $inquiry->inquiry_number = self::generateInquiryNumber();
            }
        });
    }

    /**
     * Generate inquiry number with format: CE + YY + MM + NNNNN
     * Example: CE251200001 (Contact/Enquiry 2025 Month 12 Sequence 1)
     */
    public static function generateInquiryNumber(): string
    {
        $year = date('y'); // 2-digit year (25 for 2025)
        $month = date('m'); // 2-digit month (12 for December)
        
        // Get the last inquiry number for this month
        $lastInquiry = self::where('inquiry_number', 'like', "CE{$year}{$month}%")
            ->orderBy('inquiry_number', 'desc')
            ->first();
        
        if ($lastInquiry && $lastInquiry->inquiry_number) {
            // Extract sequence number from last inquiry number
            $lastSequence = (int) substr($lastInquiry->inquiry_number, -5);
            $sequence = $lastSequence + 1;
        } else {
            // First inquiry of the month
            $sequence = 1;
        }
        
        // Format: CE + YY + MM + NNNNN (5 digits)
        return sprintf('CE%s%s%05d', $year, $month, $sequence);
    }
}
