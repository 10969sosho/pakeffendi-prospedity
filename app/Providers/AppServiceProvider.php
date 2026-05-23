<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\BankAccount;
use App\Models\Property;
use App\Models\HomeSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // FIX untuk MySQL lama di cPanel (mencegah error "Specified key was too long")
        Schema::defaultStringLength(191);

        // Share property categories, locations, and home setting to public layout
        View::composer('public.layouts.app', function ($view) {
            // Define the main property types for navbar: VILLA, LANDS, OTHER
            $navbarTypes = [
                'villas' => 'VILLA',
                'land' => 'LANDS',  // Note: database uses 'land' not 'lands'
                'other' => 'OTHER'
            ];

            // Define categories that will have submenus: LEASEHOLD, FREEHOLD, RENT YEARLY, RENT MONTHLY
            $categories = [
                'leasehold' => 'LEASEHOLD',
                'freehold' => 'FREEHOLD',
                'rent_yearly' => 'RENT YEARLY',
                'rent_monthly' => 'RENT MONTHLY'
            ];

            // Get all locations
            $allLocations = Property::select('location_text')
                ->distinct()
                ->whereNotNull('location_text')
                ->pluck('location_text')
                ->map(function ($location) {
                    $parts = explode(',', $location);
                    $city = trim($parts[0]);
                    return [
                        'full' => $location,
                        'city' => $city,
                        'slug' => strtolower(str_replace(' ', '-', $city))
                    ];
                })
                ->unique('city')
                ->sortBy('city')
                ->values();

            // Build the navbar structure
            $propertyCategories = [];
            
            foreach ($navbarTypes as $typeKey => $typeLabel) {
                if ($typeKey === 'other') {
                    // For OTHER, check for apartments, commercials, houses that are not villas or land
                    $otherTypes = ['apartments', 'commercials', 'houses'];
                    $hasOther = Property::whereIn('property_type', $otherTypes)
                        ->orWhere(function($q) use ($otherTypes) {
                            $q->whereNotNull('property_type')
                              ->whereNotIn('property_type', ['villas', 'land', 'lands']);
                        })
                        ->exists();
                    
                    if ($hasOther) {
                        $propertyCategories[] = [
                            'type' => $typeKey,
                            'label' => $typeLabel,
                            'categories' => $categories,
                            'locations' => $allLocations
                        ];
                    }
                } else {
                    // For VILLA and LANDS
                    // For lands, check both 'land' and 'lands'
                    if ($typeKey === 'land') {
                        $hasType = Property::whereIn('property_type', ['land', 'lands'])->exists();
                    } else {
                        $hasType = Property::where('property_type', $typeKey)->exists();
                    }
                    
                    if ($hasType) {
                        $propertyCategories[] = [
                            'type' => $typeKey === 'land' ? 'land' : $typeKey,  // Use 'land' for database
                            'label' => $typeLabel,
                            'categories' => $categories,
                            'locations' => $allLocations
                        ];
                    }
                }
            }

            // Get home setting for background image
            $homeSetting = HomeSetting::first();

            $view->with([
                'propertyCategories' => $propertyCategories,
                'homeSetting' => $homeSetting
            ]);
        });

        // Share home setting globally to all views (lazily to prevent DB connection during artisan commands)
        View::composer('*', function ($view) {
            $view->with('homeSetting', HomeSetting::first());
            $view->with('activeBankAccount', BankAccount::active());
        });
    }
}
