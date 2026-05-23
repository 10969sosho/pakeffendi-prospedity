<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Property;
use App\Models\ActivityLog;
use App\Models\User;

class UpdateExpiredProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:update-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status of properties that have passed their expiration date to EXPIRED';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;
        
        // Get system user or first admin for logging
        $systemUser = User::where('role', 'super_admin')->orWhere('role', 'admin')->first();
        $userId = $systemUser ? $systemUser->id : null;

        if (!$userId) {
             $this->warn('No admin user found for logging.');
        }

        // Get properties that are EXPIRED based on date but status is not yet EXPIRED
        // Use 'Asia/Jakarta' timezone for comparison to ensure date is correct based on user timezone
        $today = now()->timezone('Asia/Jakarta')->format('Y-m-d');

        $properties = Property::where('property_status', '!=', 'EXPIRED')
            ->where('property_status', '!=', 'SOLD') // Usually sold properties keep their status
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<', $today)
            ->get();

        foreach ($properties as $property) {
            $property->property_status = 'EXPIRED';
            $property->save();
            
            if ($userId) {
                ActivityLog::log('system', 'Property', $property->id, "Property automatically expired. Transaction: {$property->transaction_number}", null, $userId);
            }
            
            $count++;
        }

        $this->info("Successfully updated {$count} expired properties. (Check Date: $today)");
    }
}
