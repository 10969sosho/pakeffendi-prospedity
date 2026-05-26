@extends('public.layouts.app')

@php
    use Illuminate\Support\Str;
    $bedroomText = $property->bedroom ? $property->bedroom . ' Bedroom ' : '';
    $areaText = $property->area ? ' in ' . $property->area : ' in Bali';
    $propertyTitle = $bedroomText . $property->title;
    $metaDesc = $property->description
        ? Str::limit(strip_tags($property->description), 160)
        : ($bedroomText . 'property for sale' . $areaText . '. ' . ($property->land_size ? 'Land size: ' . $property->land_size . ' m².' : '') . ($property->building_size ? ' Building size: ' . $property->building_size . ' m².' : ''));
    $canonical = url('/property/' . ($property->property_number ?? $property->slug));
    $ogImage = $property->getMedia('photos')->first()
        ? url('/storage/' . $property->getMedia('photos')->first()->id . '/' . $property->getMedia('photos')->first()->file_name)
        : asset('images/og-default.jpg');
@endphp

@section('title', $propertyTitle . ' | Prospedity')

@section('meta_description', $metaDesc)

@section('head_extra')
@php
    $photos = $property->getMedia('photos');
    $photoUrls = $photos->map(fn($p) => url('/storage/' . $p->id . '/' . $p->file_name))->toArray();
    $mainPrice = null;
    if ($property->price_freehold && $property->price_freehold > 0) $mainPrice = $property->price_freehold;
    elseif ($property->price_leasehold && $property->price_leasehold > 0) $mainPrice = $property->price_leasehold;
    elseif ($property->price_yearly && $property->price_yearly > 0) $mainPrice = $property->price_yearly;
    elseif ($property->price_monthly && $property->price_monthly > 0) $mainPrice = $property->price_monthly;

    $listingSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'RealEstateListing',
        'name' => $property->title,
        'description' => $metaDesc,
        'url' => $canonical,
        'image' => !empty($photoUrls) ? $photoUrls : [asset('images/og-default.jpg')],
        'datePosted' => $property->created_at ? $property->created_at->toIso8601String() : date('c'),
    ];
    if ($mainPrice) {
        $listingSchema['offers'] = [
            '@type' => 'Offer',
            'price' => $mainPrice,
            'priceCurrency' => 'IDR',
        ];
    }

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Properties', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $property->title],
        ],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($listingSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8 mt-0 sm:mt-8 property-detail-container">
    <!-- Breadcrumb -->
    <nav class="mb-4 sm:mb-6">
        <ol class="flex items-center space-x-2 text-xs sm:text-sm text-gray-600 flex-wrap">
            <li><a href="{{ route('home') }}" class="hover:text-[#96A480]">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('home') }}" class="hover:text-[#96A480]">Properties</a></li>
            <li>/</li>
            <li class="text-gray-900 truncate max-w-[150px] sm:max-w-none">{{ $property->title }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Image Gallery -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                @php
                    $photos = $property->getMedia('photos');
                @endphp
                @if($photos->count() > 0)
                    <div class="relative">
                        @php
                            $coverPhoto = $property->coverPhoto();
                            $mainPhoto = $coverPhoto ?? $photos->first();
                            $mainImageUrl = '/storage/' . $mainPhoto->id . '/' . $mainPhoto->file_name;
                        @endphp
                        <img src="{{ $mainImageUrl }}" alt="{{ $property->title }}" class="w-full object-cover" style="aspect-ratio: 4 / 3;" id="mainImage" loading="lazy">
                        @if($photos->count() > 1)
                            <div class="absolute bottom-2 sm:bottom-4 left-2 sm:left-4 right-2 sm:right-4 flex space-x-2 overflow-x-auto pb-2">
                                @foreach($photos as $photo)
                                    @php
                                        $thumbUrl = '/storage/' . $photo->id . '/' . $photo->file_name;
                                    @endphp
                                    <img src="{{ $thumbUrl }}" alt="Thumbnail" class="w-12 h-12 sm:w-20 sm:h-20 object-cover rounded cursor-pointer border-4 border-[#96A480] hover:border-[#7A8A6A] flex-shrink-0 shadow-md hover:shadow-lg transition-all" onclick="document.getElementById('mainImage').src='{{ $thumbUrl }}'">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Property Details -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6">
                @php
                    $placeholder = '-';
                    $displayText = function ($value) use ($placeholder) {
                        if ($value === null) {
                            return $placeholder;
                        }
                        if (is_string($value) && trim($value) === '') {
                            return $placeholder;
                        }
                        return $value;
                    };
                    $displayYesNo = function ($value) {
                        if ($value === null) {
                            return 'Not specified';
                        }
                        return $value ? 'Yes' : 'No';
                    };
                @endphp
                <div class="mb-3 flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center gap-2 sm:gap-4">
                    @if($property->property_number)
                        <div class="text-xs sm:text-sm">
                            <span class="font-semibold text-gray-500">Property Number:</span>
                            <span class="font-bold text-[#96A480] ml-2">{{ $property->property_number }}</span>
                        </div>
                    @endif
                    @if($property->pic_ref_number)
                        <div class="text-xs sm:text-sm">
                            <span class="font-semibold text-gray-500">PIC REF NUMBER:</span>
                            <span class="font-bold text-[#96A480] ml-2">{{ $property->pic_ref_number }}</span>
                        </div>
                    @endif
                    <div class="flex items-center text-xs sm:text-sm text-gray-500 sm:ml-auto">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ number_format($property->views ?? 0) }} views
                    </div>
                </div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">{{ $property->title }}</h1>
                @if($property->area)
                    <p class="text-sm sm:text-base text-gray-800 font-semibold mb-1 sm:mb-2">{{ $property->area }}</p>
                @endif
                
                <!-- Tags -->
                @if($property->tags->count() > 0)
                    <div class="flex flex-wrap gap-2 mb-4 sm:mb-6">
                        @foreach($property->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-[#96A480]/10 text-[#96A480] border border-[#96A480]/20">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 sm:gap-4 mb-4 sm:mb-6">
                    @if($property->bedroom)
                        <div class="text-center p-3 sm:p-4 bg-gray-50 rounded">
                            <div class="text-xl sm:text-2xl font-bold text-[#96A480]">{{ $property->bedroom }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Bedroom{{ $property->bedroom > 1 ? 's' : '' }}</div>
                        </div>
                    @endif
                    @php
                        $totalBathrooms = ($property->bathroom ?? 0) + ($property->ensuite_bathroom ?? 0);
                    @endphp
                    @if($totalBathrooms > 0)
                        <div class="text-center p-3 sm:p-4 bg-gray-50 rounded">
                            <div class="text-xl sm:text-2xl font-bold text-[#96A480]">{{ $totalBathrooms }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Bathroom{{ $totalBathrooms > 1 ? 's' : '' }}</div>
                        </div>
                    @endif
                    @if($property->land_size)
                        <div class="text-center p-3 sm:p-4 bg-gray-50 rounded">
                            <div class="text-xl sm:text-2xl font-bold text-[#96A480]">{{ $property->land_size }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Land Size (m²)</div>
                        </div>
                    @endif
                    @if($property->building_size)
                        <div class="text-center p-3 sm:p-4 bg-gray-50 rounded">
                            <div class="text-xl sm:text-2xl font-bold text-[#96A480]">{{ $property->building_size }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Building Size (m²)</div>
                        </div>
                    @endif
                    @if($property->dimension)
                        <div class="text-center p-3 sm:p-4 bg-gray-50 rounded">
                            <div class="text-xl sm:text-2xl font-bold text-[#96A480]">{{ $property->dimension }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Dimension / Dimensi</div>
                        </div>
                    @endif
                    @if($property->direction)
                        @php
                            $directionMap = [
                                'North' => 'North (Utara)',
                                'Northeast' => 'Northeast (Timur Laut)',
                                'East' => 'East (Timur)',
                                'Southeast' => 'Southeast (Tenggara)',
                                'South' => 'South (Selatan)',
                                'Southwest' => 'Southwest (Barat Daya)',
                                'West' => 'West (Barat)',
                                'Northwest' => 'Northwest (Barat Laut)'
                            ];
                            $directionDisplay = $directionMap[$property->direction] ?? $property->direction;
                        @endphp
                        <div class="text-center p-3 sm:p-4 bg-gray-50 rounded">
                            <div class="text-base sm:text-lg font-bold text-[#96A480]">{{ $directionDisplay }}</div>
                            <div class="text-xs sm:text-sm text-gray-600">Direction / Arah Mata Angin</div>
                        </div>
                    @endif
                </div>

                @if($property->description)
                    <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-description">
                        <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">{{ __('property.description') }}</h2>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                            </svg>
                        </button>
                        <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                            <div class="text-sm sm:text-base text-gray-700 prose max-w-none">
                                {!! nl2br(e($property->description)) !!}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Features -->
                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-features">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">{{ __('property.features') }}</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 sm:gap-3">
                        @if($property->swimming_pool)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-[#d4af37] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Swimming Pool
                            </div>
                        @endif
                        @if($property->terrace)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-[#d4af37] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Terrace
                            </div>
                        @endif
                        @if($property->balcony)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-[#d4af37] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Balcony
                            </div>
                        @endif
                        @if($property->shower)
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 text-[#d4af37] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Outdoor Shower
                            </div>
                        @endif
                    </div>
                </div>
                </div>

                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-building">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">Building & Legal</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Property Type :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->property_type) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Property Status :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->property_status) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Year of Build :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->year_of_build) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Floor Level :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->floor_level) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">View :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->view) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Style Design :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->style_design) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Surrounding :</span>
                            <span class="font-semibold text-black text-right ml-4 whitespace-pre-line">{{ $displayText($property->surrounding) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">IMB :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->imb) }}</span>
                        </div>
                    </div>
                </div>
                </div>

                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-room">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">Room Configuration</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Living room type :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->living_room_type) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Dining room type :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->dining_room_type) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Kitchen type :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->kitchen_type) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Powder room :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->bathroom) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Ensuite bathroom :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->ensuite_bathroom) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Extra room/Laundry room :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->extra_room) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Storage :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->storage) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Outdoor shower :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->shower) }}</span>
                        </div>
                    </div>
                </div>
                </div>

                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-utilities">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">Utilities & Parking</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Furniture :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->furniture) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Electricity power :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->electricity_power) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">AC count :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->ac_count) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Water source :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->water_source) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Internet :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->internet) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Parking type :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->parking_type) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Parking size :</span>
                            <span class="font-semibold text-black">{{ $displayText($property->parking_size) }}</span>
                        </div>
                    </div>
                </div>
                </div>

                @if($property->show_monthly_cost ?? true)
                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-monthly">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">Monthly Cost</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="bg-gray-50 rounded p-3 sm:p-4 mb-3">
                        <div class="text-sm sm:text-base text-gray-700 prose max-w-none">
                            @if($property->monthly_cost_included)
                                {!! nl2br(e($property->monthly_cost_included)) !!}
                            @else
                                {{ $placeholder }}
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Banjar Security :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->banjar_security) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Cleaning Service :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->cleaning_service) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Pool Maintenance :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->pool_maintenance) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Garden Maintenance :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->garden_maintenance) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Bin Collection :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->bin_collection) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Electricity included :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->electricity_included) }}</span>
                        </div>
                        <div class="flex justify-between text-sm bg-gray-50 rounded p-3">
                            <span class="text-gray-600">Internet included :</span>
                            <span class="font-semibold text-black">{{ $displayYesNo($property->internet_included) }}</span>
                        </div>
                    </div>
                </div>
                </div>
                @endif

                <!-- Advisor Notes -->
                @if($property->advisor_notes)
                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-advisor">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">ADVISOR NOTES</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-3 sm:p-4 rounded">
                            <div class="text-sm sm:text-base text-gray-700 prose max-w-none">
                                {!! nl2br(e($property->advisor_notes)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Zone Information -->
                @if($property->zone)
                <div class="mb-4 sm:mb-6 border-b border-gray-100 pb-4 toggle-section" id="section-zone">
                    <button type="button" data-toggle-section="1" class="flex items-center justify-between w-full group focus:outline-none mb-2 sm:mb-3">
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-[#96A480] transition-colors">ZONE</h2>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div class="toggle-content overflow-hidden transition-all duration-300 ease-in-out origin-top opacity-100 max-h-[1000px]">
                        <div class="flex items-center gap-2 sm:gap-3">
                        @if($property->zone == 'GREEN')
                            <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-green-500 text-white rounded-lg font-bold text-sm sm:text-lg">GREEN ZONE</span>
                        @elseif($property->zone == 'YELLOW')
                            <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-yellow-500 text-white rounded-lg font-bold text-sm sm:text-lg">YELLOW ZONE</span>
                        @elseif($property->zone == 'PINK')
                            <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-pink-500 text-white rounded-lg font-bold text-sm sm:text-lg">PINK ZONE</span>
                        @elseif($property->zone == 'RED')
                            <span class="px-3 sm:px-4 py-1.5 sm:py-2 bg-red-500 text-white rounded-lg font-bold text-sm sm:text-lg">RED ZONE</span>
                        @endif
                    </div>
                </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Property Info Card -->
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-4 sm:mb-6 sticky top-20">
                <!-- Contact Buttons -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-2 mb-4 sm:mb-6">
                    <button onclick="openContactModal()" class="flex-1 border border-gray-300 bg-white hover:bg-gray-50 text-black font-bold py-2.5 sm:py-2 px-4 rounded flex items-center justify-center gap-2 transition-colors text-sm sm:text-base">
                        <span>Contact Us</span>
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                    <div class="flex gap-2">
                    @php
                        $whatsappNumber = $property->pic_whatsapp_number ?? ($homeSetting->whatsapp_url ?? '');
                        $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
                        $whatsappMessage = "Hello, I'm interested in property PN: " . ($property->property_number ?? $property->title);
                    @endphp
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($whatsappMessage) }}" target="_blank" class="flex-1 sm:w-12 sm:h-12 h-12 border border-gray-300 bg-white hover:bg-gray-50 rounded flex items-center justify-center transition-colors" title="WhatsApp">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                    </a>
                    </div>
                </div>

                <!-- Location -->
                <div class="flex items-start sm:items-center gap-2 mb-3 sm:mb-4">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-black flex-shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm text-black flex-1">
                        @if($property->area)
                            {{ $property->area }}
                        @else
                            {{ $property->location_text }}
                        @endif
                    </span>
                    <span class="text-xs sm:text-sm text-black font-semibold ml-2 flex-shrink-0">IDR</span>
                </div>

                <!-- Price Section -->
                @php
                    // Collect all available prices
                    $availablePrices = [];
                    
                    // Freehold Price
                    if ($property->price_freehold && $property->price_freehold > 0) {
                        $availablePrices['freehold'] = [
                            'label' => 'Freehold',
                            'value' => $property->price_freehold,
                            'period' => 'Freehold'
                        ];
                    }
                    
                    // Leasehold Price
                    if ($property->price_leasehold && $property->price_leasehold > 0) {
                        $availablePrices['leasehold'] = [
                            'label' => 'Leasehold',
                            'value' => $property->price_leasehold,
                            'period' => 'Leasehold' . ($property->leasehold_period ? ' (' . $property->leasehold_period . ' years)' : '')
                        ];
                    }
                    
                    // Monthly Rental Price
                    if ($property->price_monthly && $property->price_monthly > 0) {
                        $availablePrices['monthly'] = [
                            'label' => 'Monthly',
                            'value' => $property->price_monthly,
                            'period' => '/month'
                        ];
                    }
                    
                    // Yearly Rental Price
                    if ($property->price_yearly && $property->price_yearly > 0) {
                        $availablePrices['yearly'] = [
                            'label' => 'Yearly',
                            'value' => $property->price_yearly,
                            'period' => '/year'
                        ];
                    }
                    
                    // Get the first available price as main display
                    $mainPrice = !empty($availablePrices) ? reset($availablePrices) : null;
                    $mainPriceKey = !empty($availablePrices) ? array_key_first($availablePrices) : null;
                @endphp

                <!-- Classification Buttons -->
                @if(count($availablePrices) > 1)
                    <div class="mb-3 sm:mb-4">
                        <div class="flex flex-wrap gap-1.5 sm:gap-2">
                            @foreach($availablePrices as $key => $priceInfo)
                                <button 
                                    onclick="selectPriceType('{{ $key }}')" 
                                    id="price-btn-{{ $key }}"
                                    class="price-type-btn px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-semibold transition-colors {{ $key === $mainPriceKey ? 'bg-[#96A480] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                                    data-price-type="{{ $key }}"
                                    data-price-value="{{ $priceInfo['value'] }}"
                                    data-price-period="{{ $priceInfo['period'] }}">
                                    {{ $priceInfo['label'] }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Main Price Display -->
                @if($mainPrice)
                    <div class="mb-3 sm:mb-4" id="price-display">
                        <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-black mb-1 sm:mb-2 break-words" id="price-value">
                            IDR {{ number_format($mainPrice['value'], 0, ',', '.') }}
                        </div>
                        <div class="text-xs sm:text-sm text-gray-600" id="price-period">
                            {{ $mainPrice['period'] }}
                        </div>
                    </div>
                @endif
                <div id="price-data" data-json='@json($availablePrices)'></div>

                <!-- Property Details -->
                <div class="border-t border-gray-200 pt-4 mb-4 space-y-2">
                    @if($property->bedroom)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ __('property.bedroom') }} :</span>
                            <span class="font-semibold text-black">{{ $property->bedroom }}</span>
                        </div>
                    @endif
                    @if(($totalBathrooms ?? 0) > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ __('property.bathroom') }} :</span>
                            <span class="font-semibold text-black">{{ $totalBathrooms }}</span>
                        </div>
                    @endif
                    @if($property->land_size)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ __('property.land_size') }} :</span>
                            <span class="font-semibold text-black">{{ $property->land_size }} m²</span>
                        </div>
                    @endif
                    @if($property->building_size)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ __('property.building_size') }} :</span>
                            <span class="font-semibold text-black">{{ $property->building_size }} m²</span>
                        </div>
                    @endif
                    @if($property->dimension)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Dimension / Dimensi :</span>
                            <span class="font-semibold text-black">{{ $property->dimension }}</span>
                        </div>
                    @endif
                    @if($property->direction)
                        @php
                            $directionMap = [
                                'North' => 'North (Utara)',
                                'Northeast' => 'Northeast (Timur Laut)',
                                'East' => 'East (Timur)',
                                'Southeast' => 'Southeast (Tenggara)',
                                'South' => 'South (Selatan)',
                                'Southwest' => 'Southwest (Barat Daya)',
                                'West' => 'West (Barat)',
                                'Northwest' => 'Northwest (Barat Laut)'
                            ];
                            $directionDisplay = $directionMap[$property->direction] ?? $property->direction;
                        @endphp
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Direction / Arah Mata Angin :</span>
                            <span class="font-semibold text-black">{{ $directionDisplay }}</span>
                        </div>
                    @endif
                    @if($property->leasehold_period)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ __('property.leasehold_period') }} :</span>
                            <span class="font-semibold text-black">{{ $property->leasehold_period }} {{ __('property.year') }}(s)</span>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button class="flex-1 border border-gray-300 bg-white hover:bg-gray-50 rounded p-3 flex items-center justify-center transition-colors" title="{{ __('property.print') }}" onclick="window.print()">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                    </button>
                    <button class="flex-1 border border-gray-300 bg-white hover:bg-gray-50 rounded p-3 flex items-center justify-center transition-colors" title="{{ __('property.share') }}" onclick="shareProperty()">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="mt-6 sm:mt-12">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">{{ __('property.location_map') }}</h2>
            @php
                $currentData = [
                    'lat' => $property->latitude ?? -7.2756,
                    'lng' => $property->longitude ?? 112.7942,
                    'title' => $property->title,
                    'location' => $property->area ?? $property->location_text,
                    'property_number' => $property->property_number ?? null,
                    'id' => $property->id,
                    'description' => $property->description,
                ];
            @endphp
            <div
                id="map"
                class="w-full rounded-lg h-[420px] sm:h-[600px]"
                data-current='{{ json_encode($currentData) }}'
            ></div>
            <div id="all-properties-data" data-json='@json($allProperties)'></div>
        </div>
    </div>

    <!-- Related Properties -->
    @if(isset($relatedProperties) && $relatedProperties->count() > 0)
    <section class="mt-12 sm:mt-16">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Related Properties</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($relatedProperties as $related)
                @php
                    $relPhotos = $related->getMedia('photos');
                    $relCover = $related->coverPhoto() ?? $relPhotos->first();
                    $relImageUrl = $relCover ? '/storage/' . $relCover->id . '/' . $relCover->file_name : null;
                    $relPrice = $related->price_freehold ?: $related->price_leasehold ?: $related->price_yearly ?: $related->price_monthly;
                @endphp
                <a href="{{ route('property.show', $related->property_number ?? $related->slug) }}" class="group block">
                    <div class="aspect-[4/3] bg-gray-200 rounded-lg overflow-hidden mb-3">
                        @if($relImageUrl)
                        <img src="{{ $relImageUrl }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 group-hover:text-[#96A480] transition-colors line-clamp-2">{{ $related->title }}</h3>
                    @if($related->area)
                    <p class="text-xs text-gray-600 mt-1">{{ $related->area }}</p>
                    @endif
                    @if($relPrice)
                    <p class="text-sm font-bold text-[#96A480] mt-1">IDR {{ number_format($relPrice, 0, ',', '.') }}</p>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const priceData = JSON.parse(document.getElementById('price-data').getAttribute('data-json') || '{}');
    const currentProperty = JSON.parse(document.getElementById('map').getAttribute('data-current') || '{}');
    const allProperties = JSON.parse(document.getElementById('all-properties-data').getAttribute('data-json') || '[]');

    // Select price type function
    function selectPriceType(type) {
        if (!priceData || !priceData[type]) {
            return;
        }

        const priceInfo = priceData[type];
        
        // Update price display
        const priceValueEl = document.getElementById('price-value');
        const pricePeriodEl = document.getElementById('price-period');
        
        if (priceValueEl) {
            priceValueEl.textContent = 'IDR ' + new Intl.NumberFormat('id-ID').format(priceInfo.value);
        }
        
        if (pricePeriodEl) {
            pricePeriodEl.textContent = priceInfo.period;
        }

        // Update button states
        document.querySelectorAll('.price-type-btn').forEach(btn => {
            const btnType = btn.getAttribute('data-price-type');
            if (btnType === type) {
                btn.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                btn.classList.add('bg-[#96A480]', 'text-white');
            } else {
                btn.classList.remove('bg-[#96A480]', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            }
        });
    }

    // Share property
    function shareProperty() {
        if (navigator.share) {
            navigator.share({
                title: currentProperty.title || '',
                text: currentProperty.description || '',
                url: window.location.href
            }).catch(err => console.log('Error sharing', err));
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
            });
        }
    }

    // Initialize map centered on current property

    function getToggleState(key) {
        try {
            return localStorage.getItem(key);
        } catch (e) {
            return null;
        }
    }

    function setToggleState(key, value) {
        try {
            localStorage.setItem(key, value);
        } catch (e) {
            return;
        }
    }

    function toggleSection(button) {
        const section = button.closest('.toggle-section');
        if (!section) return;
        
        const content = section.querySelector('.toggle-content');
        const icon = section.querySelector('.toggle-icon');
        const sectionId = section.id;
        if (!content || !icon || !sectionId) return;
        
        const isCollapsed = content.classList.contains('collapsed');
        
        if (!isCollapsed) {
            content.style.maxHeight = content.scrollHeight + 'px';
            void content.offsetWidth;
            requestAnimationFrame(() => {
                content.style.maxHeight = '0px';
                content.classList.remove('opacity-100');
                content.classList.add('opacity-0', 'collapsed');
                icon.classList.add('rotate-180');
            });

            button.setAttribute('aria-expanded', 'false');
            setToggleState('toggle_state_' + sectionId, 'collapsed');
        } else {
            content.classList.remove('collapsed');
            content.classList.remove('opacity-0');
            content.classList.add('opacity-100');
            icon.classList.remove('rotate-180');
            content.style.maxHeight = content.scrollHeight + 'px';
            setTimeout(() => {
                if (!content.classList.contains('collapsed')) {
                    content.style.maxHeight = 'none';
                }
            }, 300);

            button.setAttribute('aria-expanded', 'true');
            setToggleState('toggle_state_' + sectionId, 'expanded');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            const toggleButton = e.target.closest('button[data-toggle-section]');
            if (!toggleButton) return;
            toggleSection(toggleButton);
        });

        document.querySelectorAll('.toggle-section').forEach(section => {
            const sectionId = section.id;
            const content = section.querySelector('.toggle-content');
            const icon = section.querySelector('.toggle-icon');
            const button = section.querySelector('button[data-toggle-section]');
            
            if (!sectionId || !content || !icon || !button) return;
            
            const state = getToggleState('toggle_state_' + sectionId);
            
            if (state === 'collapsed') {
                content.style.maxHeight = '0px';
                content.classList.remove('opacity-100');
                content.classList.add('opacity-0', 'collapsed');
                icon.classList.add('rotate-180');
                button.setAttribute('aria-expanded', 'false');
            } else {
                content.style.maxHeight = 'none';
                content.classList.add('opacity-100');
                content.classList.remove('opacity-0', 'collapsed');
                icon.classList.remove('rotate-180');
                button.setAttribute('aria-expanded', 'true');
            }
        });
    });

    // Initialize map with scroll wheel disabled to prevent scrolling over navbar
    const map = L.map('map', {
        scrollWheelZoom: false,
        dragging: true,
        touchZoom: true,
        doubleClickZoom: true,
        boxZoom: true,
        keyboard: true
    }).setView([currentProperty.lat, currentProperty.lng], 12);

    // Re-enable scroll wheel zoom when map is clicked/focused
    map.on('click', function() {
        map.scrollWheelZoom.enable();
    });

    // Disable scroll wheel zoom when mouse leaves map
    map.getContainer().addEventListener('mouseleave', function() {
        map.scrollWheelZoom.disable();
    });

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Helper function to get display price
    function getDisplayPrice(property) {
        if (property.price_freehold && property.price_freehold > 0) {
            return { value: property.price_freehold, label: 'Freehold' };
        }
        if (property.price_leasehold && property.price_leasehold > 0) {
            return { value: property.price_leasehold, label: 'Leasehold' };
        }
        if (property.price_monthly && property.price_monthly > 0) {
            return { value: property.price_monthly, label: 'Monthly' };
        }
        if (property.price_yearly && property.price_yearly > 0) {
            return { value: property.price_yearly, label: 'Yearly' };
        }
        return null;
    }

    // Create markers for all properties
    allProperties.forEach(function(property) {
        const isCurrentProperty = property.id === currentProperty.id;
        
        // Custom icon for current property (red) and others (blue)
        const iconColor = isCurrentProperty ? 'red' : '#96A480';
        const iconSize = isCurrentProperty ? [32, 32] : [25, 25];
        
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="
                background-color: ${iconColor};
                width: ${iconSize[0]}px;
                height: ${iconSize[1]}px;
                border-radius: 50% 50% 50% 0;
                transform: rotate(-45deg);
                border: 3px solid white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            "></div>`,
            iconSize: iconSize,
            iconAnchor: [iconSize[0]/2, iconSize[1]/2],
            popupAnchor: [0, -iconSize[1]/2]
        });

        // Create marker
        const marker = L.marker([parseFloat(property.latitude), parseFloat(property.longitude)], {
            icon: customIcon
        }).addTo(map);

        // Get display price
        const priceInfo = getDisplayPrice(property);
        const priceDisplay = priceInfo 
            ? `IDR ${new Intl.NumberFormat('id-ID').format(priceInfo.value)} (${priceInfo.label})`
            : 'Price on Request';

        // Create popup content
        const popupContent = `
            <div style="min-width: 200px;">
                <h3 style="font-weight: bold; margin-bottom: 8px; color: #96A480; font-size: 14px;">${property.title}</h3>
                <p style="margin: 4px 0; color: #666; font-size: 12px;">${property.area || property.location_text}</p>
                <p style="margin: 4px 0; color: #96A480; font-weight: bold; font-size: 13px;">${priceDisplay}</p>
                <a href="{{ url('/property') }}/${property.property_number || property.slug || property.id}" style="
                    display: inline-block;
                    margin-top: 8px;
                    padding: 6px 12px;
                    background-color: #96A480;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    font-size: 12px;
                    transition: background-color 0.2s;
                " onmouseover="this.style.backgroundColor='#7A8A6A'" onmouseout="this.style.backgroundColor='#96A480'">View Details</a>
            </div>
        `;

        marker.bindPopup(popupContent);

        // If this is the current property, open its popup and zoom to it
        if (isCurrentProperty) {
            marker.openPopup();
            map.setView([parseFloat(property.latitude), parseFloat(property.longitude)], 14);
        }
    });

    // Fit map to show all markers, but prioritize current property
    if (allProperties.length > 0) {
        // First, fit bounds to show all properties
        const bounds = allProperties.map(p => [parseFloat(p.latitude), parseFloat(p.longitude)]);
        map.fitBounds(bounds, { padding: [50, 50] });
        
        // Then after a short delay, zoom to current property if it has coordinates
        if (currentProperty.lat && currentProperty.lng && !isNaN(currentProperty.lat) && !isNaN(currentProperty.lng)) {
            setTimeout(() => {
                map.setView([currentProperty.lat, currentProperty.lng], 14);
            }, 1000);
        }
    } else if (currentProperty.lat && currentProperty.lng && !isNaN(currentProperty.lat) && !isNaN(currentProperty.lng)) {
        // If no other properties, just show current property
        map.setView([currentProperty.lat, currentProperty.lng], 14);
    }
</script>

<!-- Contact Modal -->
<div id="contactModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-2 sm:p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
        <div class="p-4 sm:p-6">
            <div class="flex justify-between items-center mb-4 sm:mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Contact Us</h2>
                <button onclick="closeContactModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contact-us.store') }}" method="POST">
                @csrf
                <input type="hidden" name="property_number" value="{{ $property->property_number ?? $property->slug ?? $property->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                    <div>
                        <label for="modal_name" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Nama *</label>
                        <input type="text" name="name" id="modal_name" value="{{ old('name') }}" required 
                               class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="modal_email" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Email *</label>
                        <input type="email" name="email" id="modal_email" value="{{ old('email') }}" required 
                               class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]">
                        @error('email')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                    <div>
                        <label for="modal_whatsapp" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Nomor WA *</label>
                        <input type="text" name="whatsapp" id="modal_whatsapp" value="{{ old('whatsapp') }}" required 
                               class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]"
                               placeholder="+62xxxxxxxxxxx">
                        @error('whatsapp')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="modal_property_number" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Property Number</label>
                        <input type="text" name="property_number" id="modal_property_number" value="{{ $property->property_number ?? $property->slug ?? $property->id }}" readonly
                               class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-300 rounded-lg bg-gray-100">
                    </div>
                </div>

                <div class="mb-3 sm:mb-4">
                    <label for="modal_subject" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Subject *</label>
                    <select name="subject" id="modal_subject" required
                            class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]">
                        <option value="" @selected(old('subject') === null || old('subject') === '')>Pilih Subject</option>
                        <option value="tanya properti" @selected(old('subject') === 'tanya properti')>Tanya Properti</option>
                        <option value="tanya harga" @selected(old('subject') === 'tanya harga')>Tanya Harga</option>
                    </select>
                    @error('subject')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3 sm:mb-4">
                    <label for="modal_note" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Note *</label>
                    <textarea name="note" id="modal_note" rows="4" required 
                              class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3">
                    <button type="button" onclick="closeContactModal()" 
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm sm:text-base">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white rounded-lg font-semibold transition-colors text-sm sm:text-base">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openContactModal() {
        document.getElementById('contactModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        document.getElementById('contactModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('contactModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeContactModal();
        }
    });
</script>

<style>
    .custom-marker {
        background: transparent !important;
        border: none !important;
    }
    
    /* Prevent map from scrolling over navbar */
    #map {
        position: relative;
        z-index: 1;
    }
    
    /* Ensure navbar stays on top */
    #mainNavbar {
        z-index: 9999 !important;
    }
</style>
@endsection
