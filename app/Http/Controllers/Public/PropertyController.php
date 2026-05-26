<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Tag;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        // Only show AVAILABLE properties (or null status) on public site
        $query->where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        });

        // Filter out expired properties
        $query->where(function ($q) {
            $q->whereNull('expired_date')
                ->orWhere('expired_date', '>=', now()->toDateString());
        });

        // Property quality filter - only show properties with valid data
        $query->whereNotNull('title')
            ->where('title', '!=', '')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            });

        // Search filters
        if ($request->filled('property_type')) {
            $type = $request->property_type;

            // Try to find by slug first
            $propertyType = PropertyType::where('slug', $type)->first();

            if ($propertyType) {
                $query->where('property_type_id', $propertyType->id);
            } else {
                // Fallback for backward compatibility
                if ($type === 'villas') {
                    $query->whereIn('property_type', ['villas', 'houses']);
                } elseif ($type === 'lands' || $type === 'land') {
                    $query->where('property_type', 'land');
                } else {
                    $query->where('property_type', $type);
                }
            }
        }

        if ($request->filled('property_category')) {
            $category = $request->property_category;
            if ($category === 'LEASEHOLD') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_leasehold')
                        ->where('price_leasehold', '>', 0);
                });
            } elseif ($category === 'FREEHOLD') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_freehold')
                        ->where('price_freehold', '>', 0);
                });
            } elseif ($category === 'RENT_YEARLY') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_yearly')
                        ->where('price_yearly', '>', 0);
                });
            } elseif ($category === 'RENT_MONTHLY') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_monthly')
                        ->where('price_monthly', '>', 0);
                });
            }
        }

        if ($request->filled('location')) {
            $query->where('area', 'like', '%'.$request->location.'%');
        }

        if ($request->filled('bedroom')) {
            $bed = (int) $request->bedroom;
            if ($bed > 0) {
                $query->where('bedroom', $bed);
            }
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = $request->filled('min_price') ? (float) $request->min_price : 0;
            $max = $request->filled('max_price') ? (float) $request->max_price : 999999999999999;
            $searchType = $request->get('search_type', 'sale');

            // Check price fields based on search type
            $query->where(function ($q) use ($min, $max, $searchType) {
                if ($searchType === 'rental') {
                    $q->whereBetween('price_yearly', [$min, $max])
                        ->orWhereBetween('price_monthly', [$min, $max]);
                } else {
                    // Default to sale
                    $q->whereBetween('price', [$min, $max])
                        ->orWhereBetween('price_freehold', [$min, $max])
                        ->orWhereBetween('price_leasehold', [$min, $max]);
                }
            });
        } elseif ($request->filled('price_range')) {
            $range = explode('-', $request->price_range);
            if (count($range) === 2) {
                $min = (float) $range[0];
                $max = $range[1] === '' ? 999999999999999 : (float) $range[1];
                $searchType = $request->get('search_type', 'sale');

                // Check price fields based on search type
                $query->where(function ($q) use ($min, $max, $searchType) {
                    if ($searchType === 'rental') {
                        $q->whereBetween('price_yearly', [$min, $max])
                            ->orWhereBetween('price_monthly', [$min, $max]);
                    } else {
                        // Default to sale
                        $q->whereBetween('price', [$min, $max])
                            ->orWhereBetween('price_freehold', [$min, $max])
                            ->orWhereBetween('price_leasehold', [$min, $max]);
                    }
                });
            }
        }

        if ($request->filled('property_tag')) {
            if ($request->property_tag === 'new') {
                $query->where('created_at', '>=', now()->subDays(30));
            } elseif ($request->property_tag === 'featured') {
                $query->where('is_featured', true);
            } else {
                $tagSlug = $request->property_tag;
                $query->whereHas('tags', function ($q) use ($tagSlug) {
                    $q->where('slug', $tagSlug);
                });
            }
        }

        if ($request->filled('land_size')) {
            $range = explode('-', $request->land_size);
            if (count($range) === 2) {
                if ($range[1] === '') {
                    $query->where('land_size', '>=', $range[0]);
                } else {
                    $query->whereBetween('land_size', [$range[0], $range[1]]);
                }
            }
        }

        if ($request->filled('pic_ref_number')) {
            $query->where('pic_ref_number', 'like', '%'.$request->pic_ref_number.'%');
        }

        if ($request->filled('property_number')) {
            $query->where('property_number', 'like', '%'.$request->property_number.'%');
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('description', 'like', '%'.$keyword.'%')
                    ->orWhere('location_text', 'like', '%'.$keyword.'%');
            });
        }

        // Search type filter
        $searchType = $request->get('search_type', 'sale');

        if ($searchType === 'rental') {
            $query->where(function ($q) {
                $q->where('has_monthly', true)
                    ->orWhere('has_yearly', true);
            });
        } else {
            // Sale (default)
            $query->where(function ($q) {
                $q->where(function ($subQ) {
                    $subQ->whereNotNull('price_freehold')
                        ->where('price_freehold', '>', 0);
                })->orWhere(function ($subQ) {
                    $subQ->whereNotNull('price_leasehold')
                        ->where('price_leasehold', '>', 0);
                })->orWhere(function ($subQ) {
                    $subQ->whereNotNull('price')
                        ->where('price', '>', 0);
                });
            });
        }

        // Get total count for banner (before pagination)
        $totalCount = $query->count();

        $properties = $query->latest()->paginate(12)->withQueryString();

        // Build filter info for banner
        $filterInfo = [
            'property_type' => $request->property_type,
            'location' => $request->location,
            'search_type' => $request->search_type ?? 'sale',
            'total_count' => $totalCount,
        ];

        $homeSetting = HomeSetting::first();

        // Get filter data
        $locations = Property::select('area')
            ->whereNotNull('area')
            ->where('area', '!=', '')
            ->distinct()
            ->orderBy('area')
            ->pluck('area');

        $tags = Tag::all();
        $propertyTypes = PropertyType::orderBy('name')->get();

        return view('public.index', compact('properties', 'filterInfo', 'homeSetting', 'locations', 'tags', 'propertyTypes'));
    }

    public function featured(Request $request)
    {
        $query = Property::query();

        // Only show AVAILABLE properties (or null status) on public site
        $query->where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        });

        // Filter out expired properties
        $query->where(function ($q) {
            $q->whereNull('expired_date')
                ->orWhere('expired_date', '>=', now()->toDateString());
        });

        // Property quality filter
        $query->whereNotNull('title')
            ->where('title', '!=', '')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            });

        // Force featured
        $query->where('is_featured', true);

        // Search filters
        if ($request->filled('property_type')) {
            $type = $request->property_type;
            if ($type === 'villas') {
                $query->whereIn('property_type', ['villas', 'houses']);
            } elseif ($type === 'lands' || $type === 'land') {
                $query->where('property_type', 'land');
            } else {
                $query->where('property_type', $type);
            }
        }

        if ($request->filled('property_category')) {
            $category = $request->property_category;
            if ($category === 'LEASEHOLD') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_leasehold')
                        ->where('price_leasehold', '>', 0);
                });
            } elseif ($category === 'FREEHOLD') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_freehold')
                        ->where('price_freehold', '>', 0);
                });
            } elseif ($category === 'RENT_YEARLY') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_yearly')
                        ->where('price_yearly', '>', 0);
                });
            } elseif ($category === 'RENT_MONTHLY') {
                $query->where(function ($q) {
                    $q->whereNotNull('price_monthly')
                        ->where('price_monthly', '>', 0);
                });
            }
        }

        if ($request->filled('location')) {
            $query->where('location_text', 'like', '%'.$request->location.'%');
        }

        if ($request->filled('bedroom')) {
            $bed = (int) $request->bedroom;
            if ($bed > 0) {
                $query->where('bedroom', $bed);
            }
        }

        if ($request->filled('min_price') || $request->filled('max_price')) {
            $min = $request->filled('min_price') ? (float) $request->min_price : 0;
            $max = $request->filled('max_price') ? (float) $request->max_price : 999999999999999;
            $searchType = $request->get('search_type', 'sale');

            // Check price fields based on search type
            $query->where(function ($q) use ($min, $max, $searchType) {
                if ($searchType === 'rental') {
                    $q->whereBetween('price_yearly', [$min, $max])
                        ->orWhereBetween('price_monthly', [$min, $max]);
                } else {
                    // Default to sale
                    $q->whereBetween('price', [$min, $max])
                        ->orWhereBetween('price_freehold', [$min, $max])
                        ->orWhereBetween('price_leasehold', [$min, $max]);
                }
            });
        } elseif ($request->filled('price_range')) {
            $range = explode('-', $request->price_range);
            if (count($range) === 2) {
                $min = (float) $range[0];
                $max = $range[1] === '' ? 999999999999999 : (float) $range[1];
                $searchType = $request->get('search_type', 'sale');

                // Check price fields based on search type
                $query->where(function ($q) use ($min, $max, $searchType) {
                    if ($searchType === 'rental') {
                        $q->whereBetween('price_yearly', [$min, $max])
                            ->orWhereBetween('price_monthly', [$min, $max]);
                    } else {
                        // Default to sale
                        $q->whereBetween('price', [$min, $max])
                            ->orWhereBetween('price_freehold', [$min, $max])
                            ->orWhereBetween('price_leasehold', [$min, $max]);
                    }
                });
            }
        }

        if ($request->filled('land_size')) {
            $range = explode('-', $request->land_size);
            if (count($range) === 2) {
                if ($range[1] === '') {
                    $query->where('land_size', '>=', $range[0]);
                } else {
                    $query->whereBetween('land_size', [$range[0], $range[1]]);
                }
            }
        }

        if ($request->filled('pic_ref_number')) {
            $query->where('pic_ref_number', 'like', '%'.$request->pic_ref_number.'%');
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%'.$keyword.'%')
                    ->orWhere('description', 'like', '%'.$keyword.'%')
                    ->orWhere('location_text', 'like', '%'.$keyword.'%');
            });
        }

        // Search type filter
        $searchType = $request->get('search_type', 'sale');

        if ($searchType === 'rental') {
            $query->where(function ($q) {
                $q->where('has_monthly', true)
                    ->orWhere('has_yearly', true);
            });
        } else {
            // Sale (default)
            $query->where(function ($q) {
                $q->where(function ($subQ) {
                    $subQ->whereNotNull('price_freehold')
                        ->where('price_freehold', '>', 0);
                })->orWhere(function ($subQ) {
                    $subQ->whereNotNull('price_leasehold')
                        ->where('price_leasehold', '>', 0);
                })->orWhere(function ($subQ) {
                    $subQ->whereNotNull('price')
                        ->where('price', '>', 0);
                });
            });
        }

        // Ordering: featured_order ASC, then updated_at DESC
        $query->orderBy('featured_order', 'asc')
            ->orderBy('updated_at', 'desc');

        // Get total count for banner (before pagination)
        $totalCount = $query->count();

        $properties = $query->paginate(12)->withQueryString();

        // Build filter info for banner
        $filterInfo = [
            'property_type' => $request->property_type,
            'location' => $request->location,
            'search_type' => $request->search_type ?? 'sale',
            'total_count' => $totalCount,
        ];

        $homeSetting = HomeSetting::first();

        // Get filter data
        $locations = Property::select('location_text')
            ->whereNotNull('location_text')
            ->distinct()
            ->orderBy('location_text')
            ->pluck('location_text');

        $tags = Tag::all();

        return view('public.featured-properties', compact('properties', 'filterInfo', 'homeSetting', 'locations', 'tags'));
    }

    public function show($identifier)
    {
        $baseQuery = Property::query()
            ->where(function ($q) {
                $q->whereIn('property_status', ['AVAILABLE', 'SOLD', 'RENTED'])
                    ->orWhereNull('property_status');
            })
            ->where(function ($q) {
                $q->whereIn('property_status', ['SOLD', 'RENTED'])
                    ->orWhere(function ($sub) {
                        $sub->whereNull('expired_date')
                            ->orWhere('expired_date', '>=', now()->toDateString());
                    });
            });

        $property = (clone $baseQuery)->where('property_number', $identifier)->first();

        if (!$property) {
            $property = (clone $baseQuery)->where('slug', $identifier)->firstOrFail();

            if (!empty($property->property_number) && $property->property_number !== $identifier) {
                return redirect()->route('property.show', $property->property_number);
            }
        }

        // Property quality validation - if property has no images or empty title, return 404
        $photos = $property->getMedia('photos');
        $hasValidImage = $photos->count() > 0;
        $hasValidTitle = !empty(trim($property->title));
        $hasValidDescription = !empty(trim($property->description ?? ''));

        if (!$hasValidImage || !$hasValidTitle || !$hasValidDescription) {
            abort(404);
        }

        // Increment views counter
        $property->increment('views');

        // Get all properties with coordinates for map (only available)
        $allProperties = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('expired_date')
                    ->orWhere('expired_date', '>=', now()->toDateString());
            })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            })
            ->select('id', 'title', 'property_number', 'latitude', 'longitude', 'location_text', 'area', 'price_freehold', 'price_leasehold', 'price_monthly', 'price_yearly')
            ->get();

        // Related properties (same area or type, excluding current)
        $relatedProperties = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('expired_date')
                    ->orWhere('expired_date', '>=', now()->toDateString());
            })
            ->where('id', '!=', $property->id)
            ->where(function ($q) use ($property) {
                if ($property->area) {
                    $q->where('area', $property->area);
                }
                if ($property->property_type) {
                    $q->orWhere('property_type', $property->property_type);
                }
            })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('public.property.show', compact('property', 'allProperties', 'relatedProperties'));
    }

    public function successfulProperties(Request $request)
    {
        $query = Property::query();

        // Property quality filter
        $query->whereNotNull('title')
            ->where('title', '!=', '')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            });

        // Filter by property status - show SOLD or RENTED, or both if not specified
        if ($request->filled('property_status')) {
            $query->where('property_status', $request->property_status);
        } else {
            // Only show SOLD or RENTED properties if no specific status filter
            $query->whereIn('property_status', ['SOLD', 'RENTED']);
        }

        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        // Filter by Location (Area) - matching Home page behavior
        if ($request->filled('location')) {
            $query->where('location_text', $request->location);
        }

        // Filter by PIC REF NUMBER
        if ($request->filled('pic_ref_number')) {
            $query->where('pic_ref_number', 'like', '%'.$request->pic_ref_number.'%');
        }

        $properties = $query->latest()->paginate(12)->withQueryString();

        $homeSetting = HomeSetting::first();

        // Get locations from SOLD/RENTED properties for filter - matching Home page behavior (using location_text)
        $locations = Property::select('location_text')
            ->whereIn('property_status', ['SOLD', 'RENTED'])
            ->whereNotNull('location_text')
            ->where('location_text', '!=', '')
            ->distinct()
            ->orderBy('location_text')
            ->pluck('location_text');

        return view('public.successful-properties', compact('properties', 'homeSetting', 'locations'));
    }
}
