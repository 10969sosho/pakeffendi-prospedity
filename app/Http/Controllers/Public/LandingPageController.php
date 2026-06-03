<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Models\Property;
use App\Models\PropertyType;

class LandingPageController extends Controller
{
    /**
     * All landing page definitions.
     * Each entry: route name, URL, canonical URL, SEO title, meta description, H1, query filter
     */
    protected array $landingPages = [
        'landing.villas-sale' => [
            'url' => '/villas-for-sale-in-bali',
            'title' => 'Villas for Sale in Bali — Luxury Properties | Prospedity',
            'description' => 'Explore premium villas for sale in Bali. Discover luxury freehold and leasehold properties in Canggu, Seminyak, Ubud, and more. Expert guidance from Prospedity Digital Properties.',
            'h1' => 'Villas for Sale in Bali',
            'subtitle' => 'Your guide to finding the perfect villa in paradise',
            'filter' => ['property_type' => 'villas', 'search_type' => 'sale'],
            'view' => 'public.landing-page',
            'section_key' => 'villas-sale-content',
        ],
        'landing.villas-rent' => [
            'url' => '/villas-for-rent-in-bali',
            'title' => 'Villas for Rent in Bali — Long Term & Monthly Rentals | Prospedity',
            'description' => 'Find your perfect rental villa in Bali. Browse long-term and monthly rental properties in Canggu, Seminyak, Ubud and beyond. Trusted by expats and digital nomads.',
            'h1' => 'Villas for Rent in Bali',
            'subtitle' => 'Long-term and monthly rental villas across Bali',
            'filter' => ['property_type' => 'villas', 'search_type' => 'rental'],
            'view' => 'public.landing-page',
            'section_key' => 'villas-rent-content',
        ],
        'landing.land-sale' => [
            'url' => '/land-for-sale-in-bali',
            'title' => 'Land for Sale in Bali — Freehold & Leasehold Plots | Prospedity',
            'description' => 'Invest in Bali land. Browse freehold and leasehold land plots for sale in Canggu, Pererenan, Uluwatu, and beyond. Prime locations for villas and commercial development.',
            'h1' => 'Land for Sale in Bali',
            'subtitle' => 'Premium land plots for investment and development',
            'filter' => ['property_type' => 'land', 'search_type' => 'sale'],
            'view' => 'public.landing-page',
            'section_key' => 'land-sale-content',
        ],
        'landing.property-canggu' => [
            'url' => '/property-in-canggu',
            'title' => 'Property in Canggu — Villas, Land & Rentals | Prospedity',
            'description' => 'Discover properties in Canggu, Bali. Browse villas for sale, land plots, and rental properties in Canggu, Berawa, Pererenan, and Batu Bolong. Your Canggu property experts.',
            'h1' => 'Property in Canggu',
            'subtitle' => 'Villas, land, and rentals in Bali\'s most vibrant neighborhood',
            'filter' => ['location' => 'Canggu'],
            'view' => 'public.landing-page',
            'section_key' => 'canggu-content',
        ],
        'landing.property-seminyak' => [
            'url' => '/property-in-seminyak',
            'title' => 'Property in Seminyak — Luxury Villas & Investments | Prospedity',
            'description' => 'Explore properties in Seminyak, Bali. Premium villas for sale and rent in Seminyak, Petitenget, and Batu Belig. Bali\'s most cosmopolitan neighborhood awaits.',
            'h1' => 'Property in Seminyak',
            'subtitle' => 'Premium properties in Bali\'s cosmopolitan heart',
            'filter' => ['location' => 'Seminyak'],
            'view' => 'public.landing-page',
            'section_key' => 'seminyak-content',
        ],
        'landing.property-ubud' => [
            'url' => '/property-in-ubud',
            'title' => 'Property in Ubud — Villas & Land in Bali\'s Cultural Heart | Prospedity',
            'description' => 'Find properties in Ubud, Bali. Serene villas and land for sale surrounded by rice terraces, jungle, and Bali\'s rich cultural heritage. Your Ubud property specialists.',
            'h1' => 'Property in Ubud',
            'subtitle' => 'Tranquil properties in Bali\'s cultural and spiritual center',
            'filter' => ['location' => 'Ubud'],
            'view' => 'public.landing-page',
            'section_key' => 'ubud-content',
        ],
    ];

    /**
     * Generic landing page handler — uses the route name to lookup page config.
     */
    public function show(string $routeName)
    {
        $config = $this->landingPages[$routeName] ?? null;
        if (!$config) {
            abort(404);
        }

        $homeSetting = HomeSetting::first();

        // Query filtered properties
        $query = $this->basePropertyQuery();
        $this->applyFilter($query, $config['filter']);

        $totalCount = $query->count();
        $properties = $query->latest()->paginate(12);

        $canonical = url($config['url']);

        return view($config['view'], [
            'config' => $config,
            'properties' => $properties,
            'totalCount' => $totalCount,
            'canonical' => $canonical,
            'homeSetting' => $homeSetting,
        ]);
    }

    /**
     * Get all landing page URLs for sitemap generation.
     */
    public static function getSitemapUrls(): array
    {
        $instance = new self();
        $urls = [];
        foreach ($instance->landingPages as $routeName => $config) {
            $urls[] = [
                'loc' => url($config['url']),
                'lastmod' => now()->tz('Asia/Jakarta')->format('Y-m-d\TH:i:sP'),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];
        }
        return $urls;
    }

    /**
     * Get all route definitions for web.php registration.
     */
    public static function getRoutes(): array
    {
        $instance = new self();
        $routes = [];
        foreach ($instance->landingPages as $routeName => $config) {
            $routes[] = [
                'url' => $config['url'],
                'name' => $routeName,
                'action' => [LandingPageController::class, 'show'],
                'params' => ['routeName' => $routeName],
            ];
        }
        return $routes;
    }

    protected function basePropertyQuery()
    {
        return Property::query()
            ->where(function ($q) {
                $q->where('property_status', 'AVAILABLE')
                    ->orWhereNull('property_status');
            })
            ->where(function ($q) {
                $q->whereNull('expired_date')
                    ->orWhere('expired_date', '>=', now()->toDateString());
            })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            });
    }

    protected function applyFilter($query, array $filter): void
    {
        if (!empty($filter['property_type'])) {
            $type = $filter['property_type'];
            $propertyType = PropertyType::where('slug', $type)->first();

            if ($propertyType) {
                $query->where('property_type_id', $propertyType->id);
            } else {
                if ($type === 'villas') {
                    $query->whereIn('property_type', ['villas', 'houses']);
                } elseif ($type === 'land') {
                    $query->where('property_type', 'land');
                } else {
                    $query->where('property_type', $type);
                }
            }
        }

        if (!empty($filter['search_type'])) {
            if ($filter['search_type'] === 'rental') {
                $query->where(function ($q) {
                    $q->where('has_monthly', true)
                        ->orWhere('has_yearly', true);
                });
            } else {
                $query->where(function ($q) {
                    $q->where(function ($sub) {
                        $sub->whereNotNull('price_freehold')->where('price_freehold', '>', 0);
                    })->orWhere(function ($sub) {
                        $sub->whereNotNull('price_leasehold')->where('price_leasehold', '>', 0);
                    })->orWhere(function ($sub) {
                        $sub->whereNotNull('price')->where('price', '>', 0);
                    });
                });
            }
        }

        if (!empty($filter['location'])) {
            $query->where('area', 'like', '%' . $filter['location'] . '%');
        }
    }
}
