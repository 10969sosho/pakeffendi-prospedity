@extends('public.layouts.app')

@section('title', 'Featured Properties - BALI Properties')

@section('content')
<!-- Hero Section - Only show if no filter is active (filter banner will show instead) -->
@if(!isset($filterInfo) || (!request()->has('property_type') && !request()->has('location') && !request()->has('property_status') && !request()->has('search_type')))
@php
    $hasHeroBackground = isset($homeSetting) && $homeSetting && $homeSetting->hero_background;
    $defaultHeroTitle = 'FEATURED VILLAS, APARTMENTS & HOUSES';
    $defaultHeroSubtitle = '<strong>Prospedity Digital Properties</strong> presents our exclusive selection of featured properties in Bali. These hand-picked villas, apartments, and houses represent the finest investment opportunities and vacation homes available. Explore our curated collection to find your dream property in paradise.';
@endphp

<section
    id="hero-section"
    class="relative py-20 md:py-28 {{ $hasHeroBackground ? 'bg-cover bg-center' : 'bg-white' }}"
    data-hero-bg="{{ $hasHeroBackground ? asset('storage/' . $homeSetting->hero_background) : '' }}"
>
    @if($hasHeroBackground)
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 {{ $hasHeroBackground ? 'text-white' : 'text-gray-900' }}">
                {{ $homeSetting && $homeSetting->hero_title ? $homeSetting->hero_title : $defaultHeroTitle }}
            </h1>
            <p class="text-lg max-w-4xl mx-auto leading-relaxed {{ $hasHeroBackground ? 'text-gray-100' : 'text-gray-700' }}">
                {!! $homeSetting && $homeSetting->hero_subtitle
                    ? nl2br(e($homeSetting->hero_subtitle))
                    : $defaultHeroSubtitle !!}
            </p>
        </div>
    </div>
</section>
@endif

<!-- Error Message -->
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Search Properties Section -->
<section class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#96A480] text-white p-4 rounded-t-lg">
            <div class="flex items-center justify-center">
                <h2 class="text-lg font-bold uppercase">SEARCH FEATURED PROPERTIES</h2>
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" onclick="toggleSearch()">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        
        <form action="{{ route('featured-properties') }}" method="GET" class="bg-white border border-gray-200 border-t-0 rounded-b-lg p-6">
            <input type="hidden" name="search_type" id="search_type" value="{{ request('search_type', 'sale') }}">
            
            <!-- First Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <!-- Property Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">PROPERTY TYPE</label>
                    <select name="property_type" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select</option>
                        <option value="villas" {{ request('property_type') === 'villas' ? 'selected' : '' }}>VILLA & HOUSES</option>
                        <option value="apartments" {{ request('property_type') === 'apartments' ? 'selected' : '' }}>APARTMENTS</option>
                        <option value="land" {{ request('property_type') === 'land' ? 'selected' : '' }}>LANDS</option>
                        <option value="commercials" {{ request('property_type') === 'commercials' ? 'selected' : '' }}>COMMERCIALS</option>
                    </select>
                </div>
                
                <!-- Property Categories -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">PROPERTY CATEGORIES</label>
                    <select name="property_category" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select</option>
                        <option value="LEASEHOLD" {{ request('property_category') === 'LEASEHOLD' ? 'selected' : '' }}>LEASEHOLD</option>
                        <option value="FREEHOLD" {{ request('property_category') === 'FREEHOLD' ? 'selected' : '' }}>FREEHOLD</option>
                        <option value="RENT_YEARLY" {{ request('property_category') === 'RENT_YEARLY' ? 'selected' : '' }}>RENT YEARLY</option>
                        <option value="RENT_MONTHLY" {{ request('property_category') === 'RENT_MONTHLY' ? 'selected' : '' }}>RENT MONTHLY</option>
                    </select>
                </div>
                
                <!-- Area/Location -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Area</label>
                    <select name="location" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select Area</option>
                        @if(isset($locations))
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Bedroom -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bedroom</label>
                    <select name="bedroom" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}" {{ request('bedroom') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            
            <!-- Third Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Price <span class="text-xs text-gray-500 font-normal ml-1">(Min value > 0)</span>
                    </label>
                    <div class="flex gap-2">
                        <select name="currency" class="border border-gray-300 rounded px-3 py-2 h-[42px]">
                            <option value="IDR" {{ request('currency', 'IDR') === 'IDR' ? 'selected' : '' }}>IDR</option>
                            <option value="USD" {{ request('currency') === 'USD' ? 'selected' : '' }}>USD</option>
                        </select>
                        <div class="flex-1 grid grid-cols-2 gap-2">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs font-medium">Min</span>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0" class="w-full border border-gray-300 rounded px-3 py-2 pl-10 text-sm h-[42px] focus:ring-[#96A480] focus:border-[#96A480] outline-none">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-xs font-medium">Max</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Any" class="w-full border border-gray-300 rounded px-3 py-2 pl-10 text-sm h-[42px] focus:ring-[#96A480] focus:border-[#96A480] outline-none">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Property Tag -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Property Tag</label>
                    <select name="property_tag" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">Select...</option>
                        <option value="new" {{ request('property_tag') === 'new' ? 'selected' : '' }}>New</option>
                        <option value="featured" {{ request('property_tag') === 'featured' ? 'selected' : '' }}>Featured</option>
                        @if(isset($tags))
                            @foreach($tags as $tag)
                                <option value="{{ $tag->slug }}" {{ request('property_tag') === $tag->slug ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            
            <!-- Advanced Search -->
            <div class="mb-4">
                <div class="bg-[#96A480] text-white p-3 rounded flex items-center justify-between cursor-pointer" onclick="toggleAdvancedSearch()">
                    <span class="font-semibold">Advanced Search</span>
                    <svg id="advanced-search-arrow" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div id="advanced-search-content" class="hidden border border-gray-200 border-t-0 rounded-b-lg p-4 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Land Size</label>
                            <select name="land_size" class="w-full border border-gray-300 rounded px-3 py-2">
                                <option value="">Select...</option>
                                <option value="0-50" {{ request('land_size') === '0-50' ? 'selected' : '' }}>0 - 50 m²</option>
                                <option value="50-100" {{ request('land_size') === '50-100' ? 'selected' : '' }}>50 - 100 m²</option>
                                <option value="100-200" {{ request('land_size') === '100-200' ? 'selected' : '' }}>100 - 200 m²</option>
                                <option value="200-" {{ request('land_size') === '200-' ? 'selected' : '' }}>200+ m²</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search by PIC REF NUMBER</label>
                            <input type="text" name="pic_ref_number" value="{{ request('pic_ref_number') }}" placeholder="Enter PIC REF NUMBER" class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Enter Keyword</label>
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Enter keyword" class="w-full border border-gray-300 rounded px-3 py-2">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <button type="button" onclick="clearSearch()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Clear
                </button>
                <button type="submit" class="bg-[#96A480] hover:bg-[#7A8A6A] text-white px-6 py-2 rounded font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search Property
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Property Listing Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($properties as $property)
                    <a href="{{ route('property.show', $property->property_number ?? $property->slug) }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow block cursor-pointer">
                        <!-- Image Carousel -->
                        <div class="relative bg-gray-200 group" style="aspect-ratio: 4 / 3;">
                            @php
                                $photos = $property->getMedia('photos');
                            @endphp
                            @if($photos->count() > 0)
                                <div class="relative h-full" id="carousel-{{ $property->id }}">
                                    @php
                                        $coverPhoto = $property->coverPhoto();
                                        $displayPhoto = $coverPhoto ?? $photos->first();
                                        $imageUrl = '/storage/' . $displayPhoto->id . '/' . $displayPhoto->file_name;
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $property->title }}" class="w-full h-full object-cover carousel-image" data-index="0">
                                    
                                    <!-- Navigation Arrows -->
                                    @if($photos->count() > 1)
                                        <button onclick="event.stopPropagation(); prevImage('{{ $property->id }}', '{{ $photos->count() }}')" class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <button onclick="event.stopPropagation(); nextImage('{{ $property->id }}', '{{ $photos->count() }}')" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-70 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col space-y-2">
                                @php
                                    // Collect all available price types with their data
                                    $priceTypes = [];
                                    if ($property->price_freehold && $property->price_freehold > 0) {
                                        $priceTypes[] = ['type' => 'FREEHOLD', 'price' => $property->price_freehold, 'label' => 'Freehold'];
                                    }
                                    if ($property->price_leasehold && $property->price_leasehold > 0) {
                                        $priceTypes[] = ['type' => 'LEASEHOLD', 'price' => $property->price_leasehold, 'label' => 'Leasehold'];
                                    }
                                    if ($property->price_monthly && $property->price_monthly > 0) {
                                        $priceTypes[] = ['type' => 'MONTHLY', 'price' => $property->price_monthly, 'label' => '/month'];
                                    }
                                    if ($property->price_yearly && $property->price_yearly > 0) {
                                        $priceTypes[] = ['type' => 'YEARLY', 'price' => $property->price_yearly, 'label' => '/year'];
                                    }
                                @endphp
                                
                                @if(count($priceTypes) > 0)
                                <div class="flex flex-wrap gap-1 bg-white rounded overflow-hidden shadow-sm p-1" onclick="event.stopPropagation(); event.preventDefault(); return false;">
                                    @foreach($priceTypes as $priceData)
                                    <button 
                                        type="button"
                                        class="price-badge px-2 py-1 text-xs font-semibold bg-[#96A480] text-white rounded z-10 hover:bg-[#7A8A6A] transition-colors cursor-pointer"
                                        data-property-id="{{ $property->id }}"
                                        data-price-type="{{ $priceData['type'] }}"
                                        data-price="{{ $priceData['price'] }}"
                                        data-label="{{ $priceData['label'] }}"
                                        onclick="handlePriceUpdate(event, this)"
                                        onmousedown="event.stopPropagation();"
                                        onmouseup="event.stopPropagation();"
                                    >
                                        {{ $priceData['type'] }}
                                    </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>

                            <div class="absolute top-3 right-3 flex flex-col items-end space-y-2">
                                @if($property->property_status === 'SOLD')
                                    <span class="bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold shadow-sm">SOLD</span>
                                @elseif($property->property_status === 'RENTED')
                                    <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs font-semibold shadow-sm">RENTED</span>
                                @endif
                                @php
                                    $styleMap = [
                                        'new' => 'bg-[#96A480] text-white',
                                        'featured' => 'bg-yellow-500 text-white',
                                        'best-deal' => 'bg-orange-500 text-white',
                                        'best deal' => 'bg-orange-500 text-white',
                                        'hot' => 'bg-red-600 text-white',
                                    ];
                                @endphp
                                @foreach($property->tags->take(3) as $tag)
                                    @php
                                        $slugOrName = strtolower($tag->slug ?? $tag->name);
                                        $cls = $styleMap[$slugOrName] ?? 'bg-gray-800 text-white';
                                    @endphp
                                    <span class="{{ $cls }} px-2 py-1 rounded text-xs font-semibold shadow-sm">{{ strtoupper($tag->name) }}</span>
                                @endforeach
                                @if($property->tags->count() > 3)
                                    <span class="bg-gray-800 text-white px-2 py-1 rounded text-xs font-semibold shadow-sm">+{{ $property->tags->count() - 3 }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ strtoupper($property->title) }}
                            </h3>
                            
                            <!-- Location/Reference and brief details -->
                            <p class="text-sm text-gray-600 mb-4 font-medium">
                                @if($property->property_number)
                                    <span class="font-bold text-[#96A480]">{{ $property->property_number }}</span>
                                    <span class="mx-2">|</span>
                                @endif
                                @if($property->area)
                                    {{ strtoupper($property->area) }}
                                @else
                                    BALI
                                @endif
                                @if($property->bedroom)
                                    <span class="mx-2">|</span>
                                    <span class="font-semibold">{{ $property->bedroom }} bedroom(s)</span>
                                @endif
                                @if($property->furniture)
                                    <span class="mx-2">|</span>
                                    <span>{{ $property->furniture }}</span>
                                @endif
                            </p>

                            <!-- Tags -->
                            @if($property->tags->count() > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($property->tags->take(3) as $tag)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                    @if($property->tags->count() > 3)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                            +{{ $property->tags->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            <!-- Price -->
                            <div class="pt-4 border-t border-gray-200">
                                @php
                                    $displayPrice = null;
                                    $priceLabel = '';
                                    $defaultPriceType = '';

                                    // Check if price filter is active
                                    $minPrice = request()->filled('min_price') ? (float)request('min_price') : 0;
                                    $maxPrice = request()->filled('max_price') ? (float)request('max_price') : 999999999999999;
                                    $hasPriceFilter = request()->filled('min_price') || request()->filled('max_price');
                                    $searchType = request('search_type', 'sale');

                                    // Determine priority based on search type and filter
                                    if ($hasPriceFilter) {
                                        if ($searchType === 'rental') {
                                            if ($property->price_yearly && $property->price_yearly > 0 && $property->price_yearly >= $minPrice && $property->price_yearly <= $maxPrice) {
                                                $displayPrice = $property->price_yearly;
                                                $priceLabel = '/year';
                                                $defaultPriceType = 'YEARLY';
                                            } elseif ($property->price_monthly && $property->price_monthly > 0 && $property->price_monthly >= $minPrice && $property->price_monthly <= $maxPrice) {
                                                $displayPrice = $property->price_monthly;
                                                $priceLabel = '/month';
                                                $defaultPriceType = 'MONTHLY';
                                            }
                                        } else {
                                            if ($property->price_freehold && $property->price_freehold > 0 && $property->price_freehold >= $minPrice && $property->price_freehold <= $maxPrice) {
                                                $displayPrice = $property->price_freehold;
                                                $priceLabel = 'Freehold';
                                                $defaultPriceType = 'FREEHOLD';
                                            } elseif ($property->price_leasehold && $property->price_leasehold > 0 && $property->price_leasehold >= $minPrice && $property->price_leasehold <= $maxPrice) {
                                                $displayPrice = $property->price_leasehold;
                                                $priceLabel = 'Leasehold';
                                                $defaultPriceType = 'LEASEHOLD';
                                            }
                                        }
                                    }

                                    // Fallback if no filter or no match in preferred type
                                    if (!$displayPrice) {
                                        if ($searchType === 'rental') {
                                            if ($property->price_yearly && $property->price_yearly > 0) {
                                                $displayPrice = $property->price_yearly;
                                                $priceLabel = '/year';
                                                $defaultPriceType = 'YEARLY';
                                            } elseif ($property->price_monthly && $property->price_monthly > 0) {
                                                $displayPrice = $property->price_monthly;
                                                $priceLabel = '/month';
                                                $defaultPriceType = 'MONTHLY';
                                            } elseif ($property->price_freehold && $property->price_freehold > 0) {
                                                $displayPrice = $property->price_freehold;
                                                $priceLabel = 'Freehold';
                                                $defaultPriceType = 'FREEHOLD';
                                            } elseif ($property->price_leasehold && $property->price_leasehold > 0) {
                                                $displayPrice = $property->price_leasehold;
                                                $priceLabel = 'Leasehold';
                                                $defaultPriceType = 'LEASEHOLD';
                                            }
                                        } else {
                                            if ($property->price_freehold && $property->price_freehold > 0) {
                                                $displayPrice = $property->price_freehold;
                                                $priceLabel = 'Freehold';
                                                $defaultPriceType = 'FREEHOLD';
                                            } elseif ($property->price_leasehold && $property->price_leasehold > 0) {
                                                $displayPrice = $property->price_leasehold;
                                                $priceLabel = 'Leasehold';
                                                $defaultPriceType = 'LEASEHOLD';
                                            } elseif ($property->price_yearly && $property->price_yearly > 0) {
                                                $displayPrice = $property->price_yearly;
                                                $priceLabel = '/year';
                                                $defaultPriceType = 'YEARLY';
                                            } elseif ($property->price_monthly && $property->price_monthly > 0) {
                                                $displayPrice = $property->price_monthly;
                                                $priceLabel = '/month';
                                                $defaultPriceType = 'MONTHLY';
                                            }
                                        }
                                    }
                                @endphp
                                @if($displayPrice)
                                    <p id="price-display-{{ $property->id }}" class="text-2xl font-bold text-[#96A480]">
                                        IDR {{ number_format($displayPrice, 0, ',', '.') }}
                                        @if($priceLabel)
                                            <span class="text-base font-normal text-gray-600 price-label-{{ $property->id }}">{{ $priceLabel }}</span>
                                        @endif
                                    </p>
                                @else
                                    <p id="price-display-{{ $property->id }}" class="text-2xl font-bold text-[#96A480]">Price on Request</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $properties->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">No properties available at the moment.</p>
            </div>
        @endif
    </div>
</section>

<!-- Chat Widget -->
<div class="fixed bottom-6 right-6 z-50">
    <div class="bg-[#96A480] text-white rounded-full p-4 shadow-2xl cursor-pointer hover:bg-[#7A8A6A] transition-colors group">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <div class="hidden group-hover:block">
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium">Online</span>
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $carouselImagesData = [];
    $defaultPriceTypes = [];
    
    foreach($properties as $property) {
        $photos = $property->getMedia('photos');
        if($photos->count() > 0) {
            $coverPhoto = $property->coverPhoto();
            $urls = [];

            if ($coverPhoto) {
                $urls[] = '/storage/' . $coverPhoto->id . '/' . $coverPhoto->file_name;
            }

            foreach($photos as $photo) {
                if ($coverPhoto && $photo->id === $coverPhoto->id) {
                    continue;
                }

                $urls[] = '/storage/' . $photo->id . '/' . $photo->file_name;
            }

            $carouselImagesData[$property->id] = $urls;
        }

        // Default Price Type Data
        if ($property->price_freehold && $property->price_freehold > 0) {
            $defaultPriceTypes[$property->id] = 'FREEHOLD';
        } elseif ($property->price_leasehold && $property->price_leasehold > 0) {
            $defaultPriceTypes[$property->id] = 'LEASEHOLD';
        } elseif ($property->price_monthly && $property->price_monthly > 0) {
            $defaultPriceTypes[$property->id] = 'MONTHLY';
        } elseif ($property->price_yearly && $property->price_yearly > 0) {
            $defaultPriceTypes[$property->id] = 'YEARLY';
        }
    }
@endphp
<div id="page-data" 
    data-carousel-images="{{ json_encode($carouselImagesData) }}"
    data-default-price-types="{{ json_encode($defaultPriceTypes) }}"
    style="display:none;"></div>
<script>
    const dataEl = document.getElementById('page-data');
    const carouselImages = JSON.parse(dataEl.dataset.carouselImages);
    const defaultPriceTypes = JSON.parse(dataEl.dataset.defaultPriceTypes);

    function nextImage(propertyId, totalImages) {
        const carousel = document.getElementById('carousel-' + propertyId);
        const img = carousel.querySelector('.carousel-image');
        const currentIndex = parseInt(img.dataset.index);
        const nextIndex = (currentIndex + 1) % totalImages;
        img.src = carouselImages[propertyId][nextIndex];
        img.dataset.index = nextIndex;
    }

    function prevImage(propertyId, totalImages) {
        const carousel = document.getElementById('carousel-' + propertyId);
        const img = carousel.querySelector('.carousel-image');
        const currentIndex = parseInt(img.dataset.index);
        const prevIndex = (currentIndex - 1 + totalImages) % totalImages;
        img.src = carouselImages[propertyId][prevIndex];
        img.dataset.index = prevIndex;
    }

    // Search functionality
    function switchSearchTab(tab) {
        document.getElementById('search_type').value = tab;
        document.querySelectorAll('.search-tab').forEach(btn => {
            if (btn.dataset.tab === tab) {
                btn.classList.add('bg-[#96A480]', 'text-white');
                btn.classList.remove('bg-white', 'text-gray-700');
            } else {
                btn.classList.remove('bg-[#96A480]', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700');
            }
        });
    }

    function toggleAdvancedSearch() {
        const content = document.getElementById('advanced-search-content');
        const arrow = document.getElementById('advanced-search-arrow');
        content.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function toggleSearch() {
        const form = document.querySelector('form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function clearSearch() {
        window.location.href = '{{ route("featured-properties") }}';
    }

    function handlePriceUpdate(event, element) {
        event.stopPropagation();
        event.preventDefault();
        
        const propertyId = element.dataset.propertyId;
        const priceType = element.dataset.priceType;
        const price = element.dataset.price;
        const label = element.dataset.label;
        
        updatePropertyPrice(propertyId, priceType, price, label);
        return false;
    }

    // Function to update property price when badge is clicked
    function updatePropertyPrice(propertyId, priceType, price, label) {
        const priceDisplay = document.getElementById('price-display-' + propertyId);
        if (!priceDisplay) return;

        // Format the price with Indonesian number format
        const formattedPrice = new Intl.NumberFormat('id-ID').format(price);
        
        // Update the price display
        priceDisplay.innerHTML = `IDR ${formattedPrice}<span class="text-base font-normal text-gray-600 price-label-${propertyId}">${label}</span>`;

        // Update badge active state
        const propertyCard = priceDisplay.closest('.bg-white.rounded-lg');
        if (propertyCard) {
            const badges = propertyCard.querySelectorAll('.price-badge[data-property-id="' + propertyId + '"]');
            badges.forEach(badge => {
                if (badge.dataset.priceType === priceType) {
                    badge.classList.add('bg-[#7A8A6A]');
                    badge.classList.remove('bg-[#96A480]');
                } else {
                    badge.classList.remove('bg-[#7A8A6A]');
                    badge.classList.add('bg-[#96A480]');
                }
            });
        }
    }

    // Initialize active badge state on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Hero Background
        const heroSection = document.getElementById('hero-section');
        if (heroSection && heroSection.dataset.heroBg) {
            heroSection.style.backgroundImage = `url('${heroSection.dataset.heroBg}')`;
        }

        // Initialize Badges
        Object.entries(defaultPriceTypes).forEach(([propertyId, type]) => {
            const badges = document.querySelectorAll(`.price-badge[data-property-id="${propertyId}"]`);
            badges.forEach(badge => {
                if (badge.dataset.priceType === type) {
                    badge.classList.add('bg-[#7A8A6A]');
                    badge.classList.remove('bg-[#96A480]');
                }
            });
        });
    });
</script>
@endsection
