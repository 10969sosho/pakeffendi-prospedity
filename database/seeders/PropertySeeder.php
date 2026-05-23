<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin users for created_by (admin_id)
        $adminUsers = User::whereIn('role', ['admin', 'superadmin'])->get();
        
        // If no admin users exist, create a default one
        if ($adminUsers->isEmpty()) {
            $adminUser = User::create([
                'name' => 'Default Admin',
                'email' => 'admin@baliproperty.com',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
            ]);
            $adminUsers = collect([$adminUser]);
        }
        
        // Lokasi-lokasi di Bali dengan koordinat
        $locations = [
            ['name' => 'Seminyak, Bali', 'lat' => -8.6874, 'lng' => 115.1644],
            ['name' => 'Canggu, Bali', 'lat' => -8.6500, 'lng' => 115.1333],
            ['name' => 'Ubud, Bali', 'lat' => -8.5069, 'lng' => 115.2625],
            ['name' => 'Sanur, Bali', 'lat' => -8.6900, 'lng' => 115.2600],
            ['name' => 'Nusa Dua, Bali', 'lat' => -8.7833, 'lng' => 115.2167],
            ['name' => 'Jimbaran, Bali', 'lat' => -8.8000, 'lng' => 115.1833],
            ['name' => 'Kerobokan, Bali', 'lat' => -8.6500, 'lng' => 115.1500],
            ['name' => 'Pererenan, Bali', 'lat' => -8.6333, 'lng' => 115.1167],
            ['name' => 'Tabanan, Bali', 'lat' => -8.5333, 'lng' => 115.1167],
            ['name' => 'Gianyar, Bali', 'lat' => -8.5333, 'lng' => 115.3167],
            ['name' => 'Denpasar, Bali', 'lat' => -8.6700, 'lng' => 115.2167],
            ['name' => 'Kuta, Bali', 'lat' => -8.7167, 'lng' => 115.1667],
            ['name' => 'Legian, Bali', 'lat' => -8.7000, 'lng' => 115.1667],
            ['name' => 'Uluwatu, Bali', 'lat' => -8.8333, 'lng' => 115.0833],
            ['name' => 'Amed, Bali', 'lat' => -8.3500, 'lng' => 115.6167],
            ['name' => 'Lovina, Bali', 'lat' => -8.1667, 'lng' => 115.0000],
            ['name' => 'Sidemen, Bali', 'lat' => -8.4833, 'lng' => 115.4000],
            ['name' => 'Candidasa, Bali', 'lat' => -8.5000, 'lng' => 115.5667],
            ['name' => 'Medewi, Bali', 'lat' => -8.5167, 'lng' => 114.9500],
            ['name' => 'Pecatu, Bali', 'lat' => -8.8167, 'lng' => 115.0833],
        ];

        // Data untuk generate properti random
        $propertyTypes = ['villas', 'land', 'apartments', 'houses', 'commercials'];
        $propertyStatuses = ['freehold', 'leasehold'];
        $furnitureOptions = ['Fully Furnished', 'Semi Furnished', 'Unfurnished'];
        $parkingTypes = ['Garage', 'Carport', 'Open'];
        $views = ['Ocean View', 'Garden View', 'City View', 'Mountain View', 'Rice Field View', 'Valley View'];
        $styleDesigns = ['Modern', 'Minimalist', 'Traditional', 'Contemporary', 'Tropical', 'Balinese', 'Mediterranean'];
        $livingRoomTypes = ['Open', 'Closed', 'Semi-Open'];
        $diningRoomTypes = ['Separate', 'Combined with Living Room', 'Open Kitchen'];
        $kitchenTypes = ['Modern', 'Traditional', 'Island Kitchen', 'Open Kitchen'];
        $extraRooms = ['Study Room', 'Guest Room', 'Maid Room', 'Storage Room', 'Gym Room', 'Home Office'];
        $electricityPowers = ['2200 VA', '3500 VA', '5500 VA', '6600 VA', '11000 VA'];
        $waterSources = ['PDAM + Well', 'Well Only', 'PDAM Only', 'Spring Water'];
        $internetOptions = ['Fiber Optic Available', 'Fiber Optic Installed', 'Not Available'];
        $zones = ['Residential', 'Commercial', 'Mixed Use', 'Tourism', 'Agricultural'];
        $directions = ['North', 'South', 'East', 'West', 'North-East', 'North-West', 'South-East', 'South-West'];
        
        // Nama-nama untuk PIC
        $picNames = [
            'Made Surya', 'Ketut Agung', 'Wayan Putra', 'Nyoman Kadek', 'Gede Adi',
            'Putu Dewi', 'Made Indira', 'Ketut Sari', 'Wayan Luh', 'Nyoman Ayu',
            'Gede Wira', 'Putu Bagus', 'Made Dharma', 'Ketut Yoga', 'Wayan Adi'
        ];
        
        $descriptions = [
            'Beautiful property with stunning views and modern amenities.',
            'Luxurious property perfect for families seeking comfort and elegance.',
            'Spacious property with traditional Balinese architecture and modern comforts.',
            'Contemporary design property located in prime area with excellent access.',
            'Charming property with tropical garden and peaceful surroundings.',
            'Premium property featuring high-end finishes and premium location.',
            'Eco-friendly property with sustainable features and natural design.',
            'Exclusive property in gated community with premium security.',
            'Beachfront property with direct access to pristine beaches.',
            'Mountain view property with cool climate and natural beauty.',
        ];

        // Generate 50 random properties
        for ($i = 0; $i < 50; $i++) {
            $location = $locations[array_rand($locations)];
            $propertyType = $propertyTypes[array_rand($propertyTypes)];
            $ownershipType = $propertyStatuses[array_rand($propertyStatuses)]; // freehold or leasehold for pricing
            
            // Set property_status to AVAILABLE so it shows on public site
            $propertyStatus = 'AVAILABLE';
            
            // Generate random property data
            $bedroom = $propertyType === 'land' ? 0 : rand(1, 6);
            $bathroom = $propertyType === 'land' ? 0 : ($bedroom ? max(1, $bedroom - 1) : rand(1, 4));
            $landSize = rand(100, 1000) + (rand(0, 99) / 100);
            $buildingSize = $propertyType === 'land' ? 0 : ($landSize * (0.6 + (rand(0, 30) / 100)));
            $yearOfBuild = $propertyType === 'land' ? rand(2010, 2024) : rand(2010, 2024);
            
            // Generate dimension (width x length in meters)
            $width = rand(10, 50);
            $length = rand(15, 60);
            $dimension = "{$width}m x {$length}m";
            
            // Generate direction
            $direction = $directions[array_rand($directions)];
            
            // Price calculation based on property type and ownership type
            $calculatedPrice = $landSize * rand(5000000, 25000000);
            if ($propertyType === 'villas' || $propertyType === 'houses') {
                $calculatedPrice += $buildingSize * rand(10000000, 30000000);
            }
            
            $hasMonthly = rand(0, 1);
            $hasYearly = rand(0, 1);
            $hasPool = rand(0, 1) && $propertyType !== 'land' && $propertyType !== 'apartments';
            
            // Set prices based on ownership type (freehold/leasehold)
            $price = $calculatedPrice; // Base price is required (cannot be null)
            $priceMonthly = $hasMonthly ? rand(15000000, 80000000) : 0;
            $priceYearly = $hasYearly ? rand(150000000, 800000000) : 0;
            $priceFreehold = $ownershipType === 'freehold' ? $calculatedPrice : 0;
            $priceLeasehold = $ownershipType === 'leasehold' ? $calculatedPrice : 0;
            $leaseholdPeriod = $ownershipType === 'leasehold' ? rand(20, 30) : 0;
            
            // Generate title
            $locationName = explode(',', $location['name'])[0];
            $titles = [
                "Luxury {$propertyType} in {$locationName}",
                "Modern {$propertyType} in {$locationName}",
                "Spacious {$propertyType} in {$locationName}",
                "Beautiful {$propertyType} in {$locationName}",
                "Premium {$propertyType} in {$locationName}",
                "Elegant {$propertyType} in {$locationName}",
                "Charming {$propertyType} in {$locationName}",
                "Contemporary {$propertyType} in {$locationName}",
                "Exclusive {$propertyType} in {$locationName}",
                "Stunning {$propertyType} in {$locationName}",
            ];
            $title = $titles[array_rand($titles)];
            
            // PIC data
            $picName = $picNames[array_rand($picNames)];
            $picEmail = strtolower(str_replace(' ', '.', $picName)) . '@baliproperty.com';
            $picWhatsapp = '+62' . rand(812, 899) . rand(1000000, 9999999);
            $picRefNumber = 'PIC-' . strtoupper(substr(str_replace(' ', '', $picName), 0, 3)) . '-' . rand(1000, 9999);
            
            // Randomly assign an admin user as created_by
            $adminId = $adminUsers->random()->id;
            
            // Generate property number
            $propertyNumber = Property::generatePropertyNumber();
            
            Property::create([
                'property_number' => $propertyNumber,
                'title' => $title,
                'slug' => Str::slug($title) . '-' . rand(1000, 9999),
                'description' => $descriptions[array_rand($descriptions)] . ' ' . 
                    ($bedroom ? "Features {$bedroom} bedrooms and {$bathroom} bathrooms. " : '') .
                    "Located in the heart of {$location['name']}, this property offers excellent value and potential.",
                'property_type' => $propertyType,
                'property_status' => $propertyStatus, // Set to 'AVAILABLE' to show on public site
                'pic_ref_number' => $picRefNumber,
                'pic_name' => $picName,
                'pic_email' => $picEmail,
                'pic_whatsapp_number' => $picWhatsapp,
                'price' => $price,
                'price_monthly' => $priceMonthly,
                'price_yearly' => $priceYearly,
                'price_freehold' => $priceFreehold,
                'price_leasehold' => $priceLeasehold,
                'leasehold_period' => $leaseholdPeriod,
                'has_monthly' => $hasMonthly,
                'has_yearly' => $hasYearly,
                'location_text' => $location['name'],
                'latitude' => $location['lat'] + (rand(-100, 100) / 10000),
                'longitude' => $location['lng'] + (rand(-100, 100) / 10000),
                'land_size' => round($landSize, 2),
                'building_size' => round($buildingSize, 2),
                'dimension' => $dimension,
                'direction' => $direction,
                'year_of_build' => $yearOfBuild,
                'floor_level' => $propertyType === 'apartments' ? rand(1, 20) : ($propertyType === 'land' ? 0 : rand(1, 3)),
                'view' => $views[array_rand($views)],
                'style_design' => $styleDesigns[array_rand($styleDesigns)],
                'surrounding' => 'Close to restaurants, shopping centers, beaches, and main roads. Safe and quiet neighborhood with excellent amenities.',
                'imb' => 'IMB-' . rand(1000, 9999) . '/' . date('Y'),
                'zone' => $zones[array_rand($zones)],
                'living_room_type' => $propertyType === 'land' ? 'N/A' : $livingRoomTypes[array_rand($livingRoomTypes)],
                'dining_room_type' => $propertyType === 'land' ? 'N/A' : $diningRoomTypes[array_rand($diningRoomTypes)],
                'kitchen_type' => $propertyType === 'land' ? 'N/A' : $kitchenTypes[array_rand($kitchenTypes)],
                'bedroom' => $bedroom,
                'bathroom' => $bathroom,
                'ensuite_bathroom' => $bathroom ? rand(0, min(2, $bathroom)) : 0,
                'extra_room' => $propertyType === 'land' ? 'N/A' : $extraRooms[array_rand($extraRooms)],
                'storage' => 'Built-in Storage',
                'swimming_pool' => $hasPool,
                'terrace' => rand(0, 1) && $propertyType !== 'land',
                'balcony' => rand(0, 1) && ($propertyType === 'apartments' || $propertyType === 'houses'),
                'shower' => rand(0, 1),
                'furniture' => $propertyType === 'land' ? 'N/A' : $furnitureOptions[array_rand($furnitureOptions)],
                'electricity_power' => $electricityPowers[array_rand($electricityPowers)],
                'ac_count' => $propertyType === 'land' ? 0 : rand(0, 8),
                'water_source' => $waterSources[array_rand($waterSources)],
                'internet' => $internetOptions[array_rand($internetOptions)],
                'parking_type' => $parkingTypes[array_rand($parkingTypes)],
                'parking_size' => rand(1, 5),
                'monthly_cost_included' => 'Property tax, security, maintenance, and utilities',
                'banjar_security' => rand(0, 1),
                'cleaning_service' => rand(0, 1),
                'pool_maintenance' => $hasPool ? rand(0, 1) : false,
                'garden_maintenance' => rand(0, 1),
                'bin_collection' => rand(0, 1),
                'electricity_included' => rand(0, 1),
                'internet_included' => rand(0, 1),
                'advisor_notes' => 'Great investment opportunity. Property is well-maintained and ready for immediate use.',
                'views' => rand(0, 500),
                'admin_id' => $adminId, // Set created_by
            ]);
        }

        $this->command->info('Created 50 random properties in Bali!');
    }
}

