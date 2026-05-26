@extends('public.layouts.app')

@php
    $hasFilters = request()->hasAny(['property_status', 'property_type', 'location', 'pic_ref_number']);
@endphp

@section('title', 'Successful Properties - Sold & Rented Properties in Bali | Prospedity')

@section('meta_description', 'Browse our portfolio of successfully sold and rented properties in Bali. See real transaction results and market proof from Prospedity Digital Properties.')

@php
    $noindex = $hasFilters;
@endphp

@section('content')
<!-- Hero Section -->
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background) 
        ? asset('storage/' . $homeSetting->hero_background) 
        : null;
@endphp
<section class="relative h-96 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 uppercase tracking-wide">
            SUCCESSFUL PROPERTIES
        </h1>
        <p class="text-base md:text-lg text-white mb-8 max-w-4xl">
            Browse our portfolio of successfully sold and rented properties
        </p>
    </div>
</section>

<!-- Property Listing Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form method="GET" action="{{ route('successful-properties') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label for="property_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="property_status" id="property_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="SOLD" {{ request('property_status') == 'SOLD' ? 'selected' : '' }}>Terjual (SOLD)</option>
                            <option value="RENTED" {{ request('property_status') == 'RENTED' ? 'selected' : '' }}>Disewa (RENTED)</option>
                        </select>
                    </div>

                    <!-- Property Type Filter -->
                    <div>
                        <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Properti
                        </label>
                        <select name="property_type" id="property_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent">
                            <option value="">Semua Tipe</option>
                            <option value="VILLA" {{ request('property_type') == 'VILLA' ? 'selected' : '' }}>Villa</option>
                            <option value="LAND" {{ request('property_type') == 'LAND' ? 'selected' : '' }}>Tanah</option>
                            <option value="HOUSE" {{ request('property_type') == 'HOUSE' ? 'selected' : '' }}>Rumah</option>
                            <option value="APARTMENT" {{ request('property_type') == 'APARTMENT' ? 'selected' : '' }}>Apartemen</option>
                        </select>
                    </div>

                    <!-- Area Filter -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                            Area
                        </label>
                        <select name="location" id="location" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent">
                            <option value="">Semua Area</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ request('location') == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PIC REF NUMBER Filter -->
                    <div>
                        <label for="pic_ref_number" class="block text-sm font-medium text-gray-700 mb-2">
                            PIC REF NUMBER
                        </label>
                        <input type="text" name="pic_ref_number" id="pic_ref_number" value="{{ request('pic_ref_number') }}" placeholder="Cari PIC REF NUMBER..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent">
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="px-6 py-2 bg-[#96A480] text-white rounded-lg hover:bg-[#7a8a66] transition-colors font-medium">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('successful-properties') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>

        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($properties as $property)
                    <a href="{{ route('property.show', $property->property_number ?? $property->slug) }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow block cursor-pointer">
                        <!-- Image Carousel -->
                        <div class="relative w-full aspect-[4/3] bg-gray-200 group">
                            @php
                                $photos = $property->getMedia('photos');
                            @endphp
                            @if($photos->count() > 0)
                                @php
                                    $coverPhoto = $property->coverPhoto();
                                    $displayPhoto = $coverPhoto ?? $photos->first();
                                    $imageUrl = '/storage/' . $displayPhoto->id . '/' . $displayPhoto->file_name;
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $property->title }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Top Right Status Badge -->
                            <div class="absolute top-3 right-3">
                                @if($property->property_status === 'SOLD')
                                <span class="bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold">
                                    SOLD
                                </span>
                                @elseif($property->property_status === 'RENTED')
                                <span class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold">
                                    RENTED
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2">
                                {{ strtoupper($property->title) }}
                            </h3>
                            
                            <!-- Location/Reference -->
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
                                - {{ $property->slug ? strtoupper($property->slug) : 'RF' . str_pad($property->id, 4, '0', STR_PAD_LEFT) }}
                            </p>
                            
                            <!-- Bedrooms & Details -->
                            <div class="flex items-center text-sm text-gray-700 mb-4">
                                @if($property->bedroom)
                                    <span class="font-semibold">{{ $property->bedroom }} bedroom(s)</span>
                                    @if($property->furniture)
                                        <span class="mx-2">|</span>
                                        <span>{{ $property->furniture }}</span>
                                    @elseif($property->year_of_build)
                                        <span class="mx-2">|</span>
                                        <span>{{ $property->year_of_build }} year(s)</span>
                                    @endif
                                @endif
                            </div>
                            
                            <!-- Price -->
                            <div class="pt-4 border-t border-gray-200">
                                @php
                                    $displayPrice = null;
                                    $priceLabel = '';
                                    if ($property->price_freehold && $property->price_freehold > 0) {
                                        $displayPrice = $property->price_freehold;
                                        $priceLabel = 'Freehold';
                                    } elseif ($property->price_leasehold && $property->price_leasehold > 0) {
                                        $displayPrice = $property->price_leasehold;
                                        $priceLabel = 'Leasehold';
                                    } elseif ($property->price_monthly && $property->price_monthly > 0) {
                                        $displayPrice = $property->price_monthly;
                                        $priceLabel = '/month';
                                    } elseif ($property->price_yearly && $property->price_yearly > 0) {
                                        $displayPrice = $property->price_yearly;
                                        $priceLabel = '/year';
                                    }
                                @endphp
                                @if($displayPrice)
                                    <p class="text-2xl font-bold text-[#96A480]">
                                        IDR {{ number_format($displayPrice, 0, ',', '.') }}
                                        @if($priceLabel)
                                            <span class="text-base font-normal text-gray-600">{{ $priceLabel }}</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-2xl font-bold text-[#96A480]">Price on Request</p>
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
                <p class="text-gray-600 text-lg">No successful properties available at the moment.</p>
            </div>
        @endif
    </div>
</section>
@endsection
