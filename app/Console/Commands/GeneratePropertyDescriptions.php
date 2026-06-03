<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GeneratePropertyDescriptions extends Command
{
    protected $signature = 'seo:generate-descriptions 
                            {--dry-run : Preview only, do not save}
                            {--limit=66 : Number of properties to process}
                            {--min-chars=500 : Minimum target characters}';
    protected $description = 'Generate rich SEO descriptions from property structured data';

    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $limit = (int) $this->option('limit');
        $minChars = (int) $this->option('min-chars');

        $properties = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->where(function ($q) {
                $q->whereNull('description')
                    ->orWhere('description', '=', '')
                    ->orWhereRaw('CHAR_LENGTH(description) < 300');
            })
            ->orderByRaw('CHAR_LENGTH(description) ASC')
            ->limit($limit)
            ->get();

        $this->info("Found {$properties->count()} properties with thin content");

        $updated = 0;
        $totalNewChars = 0;
        $totalOldChars = 0;

        foreach ($properties as $property) {
            $oldDesc = $property->description ?? '';
            $oldLen = mb_strlen($oldDesc);
            $newDesc = $this->buildDescription($property);
            $newLen = mb_strlen($newDesc);

            $totalOldChars += $oldLen;
            $totalNewChars += $newLen;

            $this->line("  ID:{$property->id} | {$oldLen} → {$newLen} chars | {$property->title}");

            if (!$dryRun) {
                $property->description = $newDesc;
                $property->save();
            }

            $updated++;
        }

        $this->line('');
        $this->info("Processed: {$updated} properties");
        $this->info("Avg before: " . ($updated > 0 ? round($totalOldChars / $updated) : 0) . " chars");
        $this->info("Avg after:  " . ($updated > 0 ? round($totalNewChars / $updated) : 0) . " chars");
        $this->info("Target:     {$minChars}+ chars");

        if ($dryRun) {
            $this->warn("DRY RUN — no changes saved. Remove --dry-run to apply.");
        } else {
            $this->info("Descriptions saved to database.");
        }
    }

    private function buildDescription(Property $p): string
    {
        $parts = [];

        // 1. Opening: type + title + location
        $typeName = $p->type ? $p->type->name : 'Property';
        $typeLabel = strtolower($typeName);
        $area = $p->area ?: 'Bali';
        $parts[] = "Discover this exceptional {$typeLabel} in {$area}, {$p->title}. ";

        // 2. Location context
        if ($p->area) {
            $parts[] = "Located in the sought-after area of {$p->area}, ";
            if ($p->location_text && $p->location_text !== $p->area) {
                $parts[] = "specifically at {$p->location_text}, ";
            }
            $parts[] = "this property offers convenient access to Bali's finest dining, shopping, and lifestyle destinations. ";
        } else {
            $parts[] = "Situated in a prime location in Bali, this property provides easy access to the island's best attractions, beaches, and amenities. ";
        }

        // 3. Land & building
        if ($p->land_size && $p->land_size > 0) {
            $parts[] = "The property sits on a generous {$p->land_size} m² land plot";
            if ($p->building_size && $p->building_size > 0) {
                $parts[] = " with a {$p->building_size} m² building size";
            }
            $parts[] = ", providing ample space for comfortable tropical living. ";
        } elseif ($p->building_size && $p->building_size > 0) {
            $parts[] = "With a {$p->building_size} m² building size, this property offers generous living spaces. ";
        }

        // 4. Bedrooms & bathrooms
        if ($p->bedroom && $p->bedroom > 0) {
            $bedroomLabel = $p->bedroom > 1 ? "{$p->bedroom} bedrooms" : "{$p->bedroom} bedroom";
            $parts[] = "Featuring {$bedroomLabel}";
            if ($p->bathroom && $p->bathroom > 0) {
                $bathLabel = $p->bathroom > 1 ? "{$p->bathroom} bathrooms" : "{$p->bathroom} bathroom";
                $parts[] = " and {$bathLabel}";
            }
            if ($p->ensuite_bathroom && $p->ensuite_bathroom > 0) {
                $parts[] = " with {$p->ensuite_bathroom} en-suite";
            }
            $parts[] = ", the layout is thoughtfully designed for comfort and privacy. ";
        }

        // 5. Design & style
        if ($p->style_design) {
            $parts[] = "The property showcases a {$p->style_design} architectural style";
            if ($p->living_room_type) {
                $parts[] = " with {$p->living_room_type} living areas";
            }
            $parts[] = ", creating an atmosphere of refined elegance. ";
        }

        // 6. Key features
        $features = [];
        if ($p->swimming_pool) {
            $features[] = "a private swimming pool";
        }
        if ($p->terrace) {
            $features[] = "a spacious terrace";
        }
        if ($p->balcony) {
            $features[] = "a balcony with scenic views";
        }
        if ($p->garden_maintenance) {
            $features[] = "a beautifully maintained tropical garden";
        }
        if ($p->view) {
            $features[] = "{$p->view} views";
        }
        if (!empty($features)) {
            $parts[] = "Key features include " . implode(', ', $features) . ". ";
        }

        // 7. Kitchen & dining
        $interiorFeatures = [];
        if ($p->kitchen_type) {
            $interiorFeatures[] = "a {$p->kitchen_type} kitchen";
        }
        if ($p->dining_room_type) {
            $interiorFeatures[] = "{$p->dining_room_type} dining area";
        }
        if ($p->furniture) {
            $interiorFeatures[] = "{$p->furniture} furnishings";
        }
        if (!empty($interiorFeatures)) {
            $parts[] = "The interior boasts " . implode(', ', $interiorFeatures) . ". ";
        }

        // 8. Additional rooms
        if ($p->extra_room) {
            $parts[] = "Additional spaces include {$p->extra_room}, ";
            if ($p->storage) {
                $parts[] = "{$p->storage}, ";
            }
            $parts[] = "offering versatility for your lifestyle needs. ";
        }

        // 9. Parking
        if ($p->parking_type && $p->parking_size && $p->parking_size !== '0' && $p->parking_size !== '-') {
            $parts[] = "The property includes {$p->parking_type} parking for {$p->parking_size}, ensuring convenience for residents and guests. ";
        } elseif ($p->parking_type) {
            $parts[] = "Parking is provided with {$p->parking_type} access. ";
        }

        // 10. Utilities & infrastructure
        $utilParts = [];
        if ($p->electricity_power) {
            $utilParts[] = "electricity capacity of {$p->electricity_power}";
        }
        if ($p->water_source) {
            $utilParts[] = "water supply from {$p->water_source}";
        }
        if ($p->internet) {
            $utilParts[] = "{$p->internet} internet connectivity";
        }
        if (!empty($utilParts)) {
            $parts[] = "Utilities and infrastructure include " . implode(', ', $utilParts) . ". ";
        }

        // 11. Additional services
        $serviceParts = [];
        if ($p->cleaning_service) {
            $serviceParts[] = "cleaning";
        }
        if ($p->pool_maintenance) {
            $serviceParts[] = "pool maintenance";
        }
        if ($p->banjar_security) {
            $serviceParts[] = "security";
        }
        if ($p->bin_collection) {
            $serviceParts[] = "waste collection";
        }
        if (!empty($serviceParts)) {
            $parts[] = "Included services cover " . implode(', ', $serviceParts) . " for hassle-free living. ";
        }

        // 12. Tenure/pricing context
        $priceContexts = [];
        if ($p->price_freehold && $p->price_freehold > 0) {
            $priceContexts[] = "available as freehold at IDR " . number_format($p->price_freehold, 0, ',', '.');
        }
        if ($p->price_leasehold && $p->price_leasehold > 0) {
            $leaseText = "available as leasehold at IDR " . number_format($p->price_leasehold, 0, ',', '.');
            if ($p->leasehold_period) {
                $leaseText .= " for {$p->leasehold_period} years";
            }
            $priceContexts[] = $leaseText;
        }
        if ($p->price_yearly && $p->price_yearly > 0) {
            $priceContexts[] = "available for yearly rent at IDR " . number_format($p->price_yearly, 0, ',', '.');
        }
        if ($p->price_monthly && $p->price_monthly > 0) {
            $priceContexts[] = "available for monthly rent at IDR " . number_format($p->price_monthly, 0, ',', '.');
        }

        if (!empty($priceContexts)) {
            $parts[] = "This property is " . implode(', and ', $priceContexts) . ". ";
        }

        // 13. Investment angle
        if ($p->year_of_build) {
            $parts[] = "Built in {$p->year_of_build}, ";
            if ($p->imb) {
                $parts[] = "with {$p->imb} permitting, ";
            }
            $parts[] = "this property represents a solid investment opportunity. ";
        }

        // 14. CTA closing
        $parts[] = "Contact Prospedity today to arrange a private viewing of this exceptional {$typeLabel} in {$area}. ";
        $parts[] = "Our experienced team will guide you through every step of the acquisition process.";

        // 15. Original description (if exists)
        if (!empty($oldDesc = trim(strip_tags($p->description ?? '')))) {
            $parts[] = " Additional details: {$oldDesc}";
        }

        return implode('', $parts);
    }
}
