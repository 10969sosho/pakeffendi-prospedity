@extends('admin.layouts.app')

@section('title', 'Create Property')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Property</h1>
            <p class="mt-2 text-sm text-gray-600">Add a new property to the system</p>
        </div>
        <a href="{{ route('admin.properties.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-lg shadow hover:bg-gray-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Basic Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description *</label>
                        <textarea name="description" id="description" rows="4" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">{{ old('description') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="advisor_notes" class="block text-sm font-bold text-gray-700 mb-2">Advisor Notes</label>
                        <textarea name="advisor_notes" id="advisor_notes" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="Add advisor notes (e.g., property dekat masjid/pura, atau note lainnya)">{{ old('advisor_notes') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Notes khusus dari advisor untuk properti ini (akan tampil di halaman detail property)</p>
                    </div>

                    <div>
                        <label for="property_type_id" class="block text-sm font-bold text-gray-700 mb-2">Property Type *</label>
                        <select name="property_type_id" id="property_type_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" required>
                            <option value="">Select Type</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="property_status" class="block text-sm font-bold text-gray-700 mb-2">Property Status</label>
                        <select name="property_status" id="property_status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                            <option value="DRAFT" {{ old('property_status') == 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                            <option value="AVAILABLE" {{ old('property_status', 'AVAILABLE') == 'AVAILABLE' ? 'selected' : '' }}>AVAILABLE</option>
                            <option value="SOLD" {{ old('property_status') == 'SOLD' ? 'selected' : '' }}>SOLD</option>
                            <option value="RENTED" {{ old('property_status') == 'RENTED' ? 'selected' : '' }}>RENTED</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-8">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#96A480]/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#96A480]"></div>
                            <span class="ml-3 text-sm font-bold text-gray-700">Set as Featured Property</span>
                        </label>
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Property Tags</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($tags as $tag)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-[#96A480] border-gray-300 rounded focus:ring-[#96A480]">
                                <span class="ml-2 text-gray-700">{{ $tag->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Information -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Transaction Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="transaction_number" class="block text-sm font-bold text-gray-700 mb-2">Transaction Number *</label>
                        <input type="text" name="transaction_number" id="transaction_number" value="{{ old('transaction_number') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="Enter Transaction Number">
                        <p class="text-sm text-gray-500 mt-1">Properties with the same transaction number will be grouped together.</p>
                    </div>

                    <div>
                        <label for="validity_days" class="block text-sm font-bold text-gray-700 mb-2">Validity Period (Days) *</label>
                        <input type="number" name="validity_days" id="validity_days" value="{{ old('validity_days') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="e.g. 50">
                        <p class="text-sm text-gray-500 mt-1">The property will automatically expire after this many days.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PIC Information -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    PIC (Person In Charge) Information
                </h3>
            </div>
            <div class="p-6">
                <!-- Auto-fill from Master Data -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <label for="pic_profile_id" class="block text-sm font-bold text-gray-700 mb-2">Auto-fill from PIC Profile</label>
                    <select id="pic_profile_id" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" onchange="autoFillPic(this)">
                        <option value="">Select PIC to auto-fill...</option>
                        @foreach($picProfiles as $pic)
                            <option value="{{ $pic->id }}" 
                                data-ref="{{ $pic->ref_number }}"
                                data-name="{{ $pic->name }}"
                                data-email="{{ $pic->email }}"
                                data-whatsapp="{{ $pic->whatsapp_number }}">
                                {{ $pic->name }} ({{ $pic->ref_number }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pic_ref_number" class="block text-sm font-bold text-gray-700 mb-2">PIC REF NUMBER</label>
                        <input type="text" name="pic_ref_number" id="pic_ref_number" value="{{ old('pic_ref_number') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="Enter PIC Reference Number">
                        <p class="text-sm text-gray-500 mt-1">This will be displayed on the user page and can be used for search</p>
                    </div>

                    <div>
                        <label for="pic_name" class="block text-sm font-bold text-gray-700 mb-2">PIC NAME</label>
                        <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="Enter PIC Name">
                    </div>

                    <div>
                        <label for="pic_email" class="block text-sm font-bold text-gray-700 mb-2">PIC EMAIL</label>
                        <input type="email" name="pic_email" id="pic_email" value="{{ old('pic_email') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="Enter PIC Email">
                    </div>

                    <div>
                        <label for="pic_whatsapp_number" class="block text-sm font-bold text-gray-700 mb-2">PIC WHATSAPP NUMBER</label>
                        <input type="text" name="pic_whatsapp_number" id="pic_whatsapp_number" value="{{ old('pic_whatsapp_number') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="Enter PIC WhatsApp Number">
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Information -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Pricing Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price_freehold" class="block text-sm font-bold text-gray-700 mb-2">Price (Freehold)</label>
                        <input type="number" name="price_freehold" id="price_freehold" step="0.01" value="{{ old('price_freehold') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="price_leasehold" class="block text-sm font-bold text-gray-700 mb-2">Price (Leasehold)</label>
                        <input type="number" name="price_leasehold" id="price_leasehold" step="0.01" value="{{ old('price_leasehold') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="leasehold_period" class="block text-sm font-bold text-gray-700 mb-2">Leasehold Period (Years)</label>
                        <input type="number" name="leasehold_period" id="leasehold_period" value="{{ old('leasehold_period') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div class="md:col-span-2 border-t border-gray-200 pt-4 mt-2">
                        <h4 class="text-sm font-bold text-gray-700 mb-4">Rental Pricing</h4>
                    </div>

                    <div>
                        <label for="price_monthly" class="block text-sm font-bold text-gray-700 mb-2">Price (Monthly)</label>
                        <input type="number" name="price_monthly" id="price_monthly" step="0.01" value="{{ old('price_monthly') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="price_yearly" class="block text-sm font-bold text-gray-700 mb-2">Price (Yearly)</label>
                        <input type="number" name="price_yearly" id="price_yearly" step="0.01" value="{{ old('price_yearly') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                </div>
            </div>
        </div>

        <!-- Location -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Location
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="location_text" class="block text-sm font-bold text-gray-700 mb-2">Address *</label>
                        <input type="text" name="location_text" id="location_text" value="{{ old('location_text') }}" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label for="area" class="block text-sm font-bold text-gray-700 mb-2">Area (Region)</label>
                        <input type="text" name="area" id="area" value="{{ old('area') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="e.g. Canggu, Seminyak, Ubud">
                        <p class="text-sm text-gray-500 mt-1">Area ini akan digunakan untuk filter lokasi di halaman publik.</p>
                    </div>

                    <!-- Google Maps URL Parser -->
                    <div class="md:col-span-2">
                        <label for="google_maps_url" class="block text-sm font-bold text-gray-700 mb-2">Paste Google Maps URL (Optional)</label>
                        <div class="flex gap-2">
                            <input type="text" id="google_maps_url" placeholder="https://www.google.com/maps/place/..." class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                            <button type="button" onclick="extractCoordinates()" class="px-6 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg transition-colors">
                                Extract Coordinates
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Paste Google Maps URL dan klik Extract untuk auto-fill koordinat</p>
                    </div>

                    <div>
                        <label for="latitude" class="block text-sm font-bold text-gray-700 mb-2">Latitude</label>
                        <input type="number" name="latitude" id="latitude" step="0.00000001" value="{{ old('latitude') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="longitude" class="block text-sm font-bold text-gray-700 mb-2">Longitude</label>
                        <input type="number" name="longitude" id="longitude" step="0.00000001" value="{{ old('longitude') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                    Property Details
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="land_size" class="block text-sm font-bold text-gray-700 mb-2">Land Size (m²)</label>
                        <input type="number" name="land_size" id="land_size" step="0.01" value="{{ old('land_size') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div>
                        <label for="building_size" class="block text-sm font-bold text-gray-700 mb-2">Building Size (m²)</label>
                        <input type="number" name="building_size" id="building_size" step="0.01" value="{{ old('building_size') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div>
                        <label for="dimension" class="block text-sm font-bold text-gray-700 mb-2">Dimension / Dimensi</label>
                        <input type="text" name="dimension" id="dimension" value="{{ old('dimension') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="e.g., 10m x 15m">
                        <p class="text-sm text-gray-500 mt-1">Ukuran dimensi properti (contoh: 10m x 15m)</p>
                    </div>

                    <div>
                        <label for="direction" class="block text-sm font-bold text-gray-700 mb-2">Direction / Arah Mata Angin</label>
                        <select name="direction" id="direction" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            <option value="">Select Direction</option>
                            <option value="North" {{ old('direction') == 'North' ? 'selected' : '' }}>North (Utara)</option>
                            <option value="Northeast" {{ old('direction') == 'Northeast' ? 'selected' : '' }}>Northeast (Timur Laut)</option>
                            <option value="East" {{ old('direction') == 'East' ? 'selected' : '' }}>East (Timur)</option>
                            <option value="Southeast" {{ old('direction') == 'Southeast' ? 'selected' : '' }}>Southeast (Tenggara)</option>
                            <option value="South" {{ old('direction') == 'South' ? 'selected' : '' }}>South (Selatan)</option>
                            <option value="Southwest" {{ old('direction') == 'Southwest' ? 'selected' : '' }}>Southwest (Barat Daya)</option>
                            <option value="West" {{ old('direction') == 'West' ? 'selected' : '' }}>West (Barat)</option>
                            <option value="Northwest" {{ old('direction') == 'Northwest' ? 'selected' : '' }}>Northwest (Barat Laut)</option>
                        </select>
                    </div>

                    <div>
                        <label for="year_of_build" class="block text-sm font-bold text-gray-700 mb-2">Year of Build</label>
                        <input type="number" name="year_of_build" id="year_of_build" value="{{ old('year_of_build') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div>
                        <label for="floor_level" class="block text-sm font-bold text-gray-700 mb-2">Floor Level</label>
                        <input type="number" name="floor_level" id="floor_level" value="{{ old('floor_level') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div>
                        <label for="view" class="block text-sm font-bold text-gray-700 mb-2">View</label>
                        <input type="text" name="view" id="view" value="{{ old('view') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div>
                        <label for="style_design" class="block text-sm font-bold text-gray-700 mb-2">Style Design</label>
                        <input type="text" name="style_design" id="style_design" value="{{ old('style_design') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label for="surrounding" class="block text-sm font-bold text-gray-700 mb-2">Surrounding</label>
                        <textarea name="surrounding" id="surrounding" rows="3" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">{{ old('surrounding') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="imb" class="block text-sm font-bold text-gray-700 mb-2">IMB</label>
                        <input type="text" name="imb" id="imb" value="{{ old('imb') }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>

                    <div class="md:col-span-2">
                        <label for="zone" class="block text-sm font-bold text-gray-700 mb-2">Zone</label>
                        <select name="zone" id="zone" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                            <option value="">Select Zone</option>
                            <option value="GREEN" {{ old('zone') == 'GREEN' ? 'selected' : '' }}>GREEN</option>
                            <option value="YELLOW" {{ old('zone') == 'YELLOW' ? 'selected' : '' }}>YELLOW</option>
                            <option value="PINK" {{ old('zone') == 'PINK' ? 'selected' : '' }}>PINK</option>
                            <option value="RED" {{ old('zone') == 'RED' ? 'selected' : '' }}>RED</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Indoor -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Indoor Features
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="living_room_type" class="block text-sm font-bold text-gray-700 mb-2">Living Room Type</label>
                        <select name="living_room_type" id="living_room_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                            <option value="">Select Living Room Type</option>
                            <option value="Open" {{ old('living_room_type') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ old('living_room_type') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="Open-Closed" {{ old('living_room_type') == 'Open-Closed' ? 'selected' : '' }}>Open-Closed</option>
                        </select>
                    </div>

                    <div>
                        <label for="dining_room_type" class="block text-sm font-bold text-gray-700 mb-2">Dining Room Type</label>
                        <select name="dining_room_type" id="dining_room_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                            <option value="">Select Dining Room Type</option>
                            <option value="Open" {{ old('dining_room_type') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ old('dining_room_type') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="Open-Closed" {{ old('dining_room_type') == 'Open-Closed' ? 'selected' : '' }}>Open-Closed</option>
                        </select>
                    </div>

                    <div>
                        <label for="kitchen_type" class="block text-sm font-bold text-gray-700 mb-2">Kitchen Type</label>
                        <select name="kitchen_type" id="kitchen_type" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                            <option value="">Select Kitchen Type</option>
                            <option value="Open" {{ old('kitchen_type') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ old('kitchen_type') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="Open-Closed" {{ old('kitchen_type') == 'Open-Closed' ? 'selected' : '' }}>Open-Closed</option>
                        </select>
                    </div>

                    <div>
                        <label for="bedroom" class="block text-sm font-bold text-gray-700 mb-2">Bedroom</label>
                        <input type="number" name="bedroom" id="bedroom" value="{{ old('bedroom') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="bathroom" class="block text-sm font-bold text-gray-700 mb-2">Bathroom</label>
                        <input type="number" name="bathroom" id="bathroom" value="{{ old('bathroom') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="ensuite_bathroom" class="block text-sm font-bold text-gray-700 mb-2">Ensuite Bathroom</label>
                        <input type="number" name="ensuite_bathroom" id="ensuite_bathroom" value="{{ old('ensuite_bathroom') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="extra_room" class="block text-sm font-bold text-gray-700 mb-2">Extra Room</label>
                        <input type="text" name="extra_room" id="extra_room" value="{{ old('extra_room') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="storage" class="block text-sm font-bold text-gray-700 mb-2">Storage</label>
                        <input type="text" name="storage" id="storage" value="{{ old('storage') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>
                </div>
            </div>
        </div>

        <!-- Outdoor -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Outdoor Features
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="swimming_pool" id="swimming_pool" value="1" {{ old('swimming_pool') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-900">Swimming Pool</span>
                    </label>

                    <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="terrace" id="terrace" value="1" {{ old('terrace') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-900">Terrace</span>
                    </label>

                    <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="balcony" id="balcony" value="1" {{ old('balcony') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-900">Balcony</span>
                    </label>

                    <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="shower" id="shower" value="1" {{ old('shower') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                        <span class="text-sm font-medium text-gray-900">Outdoor Shower</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Facilities -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    Facilities
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="furniture" class="block text-sm font-bold text-gray-700 mb-2">Furniture</label>
                        <select name="furniture" id="furniture" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                            <option value="">Select Furniture</option>
                            <option value="Fully Furnished" {{ old('furniture') == 'Fully Furnished' ? 'selected' : '' }}>Fully Furnished</option>
                            <option value="Semi Furnished" {{ old('furniture') == 'Semi Furnished' ? 'selected' : '' }}>Semi Furnished</option>
                            <option value="Non Furnished" {{ old('furniture') == 'Non Furnished' ? 'selected' : '' }}>Non Furnished</option>
                        </select>
                    </div>

                    <div>
                        <label for="electricity_power" class="block text-sm font-bold text-gray-700 mb-2">Electricity Power</label>
                        <input type="text" name="electricity_power" id="electricity_power" value="{{ old('electricity_power') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="ac_count" class="block text-sm font-bold text-gray-700 mb-2">AC Count</label>
                        <input type="number" name="ac_count" id="ac_count" value="{{ old('ac_count') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="water_source" class="block text-sm font-bold text-gray-700 mb-2">Water Source</label>
                        <input type="text" name="water_source" id="water_source" value="{{ old('water_source') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="internet" class="block text-sm font-bold text-gray-700 mb-2">Internet</label>
                        <input type="text" name="internet" id="internet" value="{{ old('internet') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="parking_type" class="block text-sm font-bold text-gray-700 mb-2">Parking Type</label>
                        <input type="text" name="parking_type" id="parking_type" value="{{ old('parking_type') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                    </div>

                    <div>
                        <label for="parking_size" class="block text-sm font-bold text-gray-700 mb-2">Parking Size</label>
                        <input type="text" name="parking_size" id="parking_size" value="{{ old('parking_size') }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="e.g. 1 Car, 2 Bikes">
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Cost -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Monthly Cost
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                            <input type="hidden" name="show_monthly_cost" value="0">
                            <input type="checkbox" name="show_monthly_cost" id="show_monthly_cost" value="1" {{ old('show_monthly_cost', 1) ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                            <span class="text-sm font-medium text-gray-900">Show Monthly Cost (Public)</span>
                        </label>
                    </div>

                    <div class="md:col-span-2">
                        <label for="monthly_cost_included" class="block text-sm font-bold text-gray-700 mb-2">Monthly Cost Included</label>
                        <textarea name="monthly_cost_included" id="monthly_cost_included" rows="3" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">{{ old('monthly_cost_included') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="banjar_security" id="banjar_security" value="1" {{ old('banjar_security') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Banjar Security</span>
                            </label>

                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="cleaning_service" id="cleaning_service" value="1" {{ old('cleaning_service') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Cleaning Service</span>
                            </label>

                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="pool_maintenance" id="pool_maintenance" value="1" {{ old('pool_maintenance') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Pool Maintenance</span>
                            </label>

                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="garden_maintenance" id="garden_maintenance" value="1" {{ old('garden_maintenance') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Garden Maintenance</span>
                            </label>

                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="bin_collection" id="bin_collection" value="1" {{ old('bin_collection') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Bin Collection</span>
                            </label>

                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="electricity_included" id="electricity_included" value="1" {{ old('electricity_included') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Electricity Included</span>
                            </label>

                            <label class="flex items-center space-x-2 border rounded-lg p-3 bg-white hover:bg-gray-50 cursor-pointer">
                                <input type="checkbox" name="internet_included" id="internet_included" value="1" {{ old('internet_included') ? 'checked' : '' }} class="h-5 w-5 text-[#96A480] focus:ring-[#96A480] border-gray-300 rounded">
                                <span class="text-sm font-medium text-gray-900">Internet Included</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Photos -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Photos
                </h3>
            </div>
            <div class="p-6">
                <div>
                    <label for="photos" class="block text-sm font-bold text-gray-700 mb-2">Property Photos</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-[#96A480] transition-colors bg-slate-50">
                        <svg class="mx-auto h-12 w-12 text-[#96A480] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <input type="file" name="photos[]" id="photos" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-[#96A480] file:text-white hover:file:bg-[#7A8A6A] cursor-pointer">
                        <p class="mt-4 text-sm text-gray-600 font-medium">You can select multiple photos (JPEG, PNG, WEBP)</p>
                        <input type="hidden" name="cover_photo_index" id="cover_photo_index">
                        <div class="mt-6 pt-6 border-t border-gray-200 hidden" id="photos-preview-wrapper">
                            <p class="text-sm font-medium text-gray-700 mb-3">Selected Photos:</p>
                            <div class="grid grid-cols-3 gap-3" id="photos-preview-container"></div>
                            <p class="mt-3 text-xs text-gray-500">Use the Cover button to set the main photo.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.properties.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-lg shadow hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-8 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-bold rounded-lg shadow-lg transition-colors duration-200">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Create Property
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-fill PIC details
function autoFillPic(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    if (selectedOption.value) {
        document.getElementById('pic_ref_number').value = selectedOption.getAttribute('data-ref') || '';
        document.getElementById('pic_name').value = selectedOption.getAttribute('data-name') || '';
        document.getElementById('pic_email').value = selectedOption.getAttribute('data-email') || '';
        document.getElementById('pic_whatsapp_number').value = selectedOption.getAttribute('data-whatsapp') || '';
    }
}

// Extract coordinates from Google Maps URL
function extractCoordinates() {
    const urlInput = document.getElementById('google_maps_url');
    const url = urlInput.value.trim();
    
    if (!url) {
        alert('Please paste a Google Maps URL');
        return;
    }

    let lat = null;
    let lng = null;

    // Try to extract from different Google Maps URL formats
    // Format 1: https://www.google.com/maps/place/.../@lat,lng,zoom
    const placeMatch = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (placeMatch) {
        lat = parseFloat(placeMatch[1]);
        lng = parseFloat(placeMatch[2]);
    }
    
    // Format 2: https://maps.google.com/?q=lat,lng
    if (!lat || !lng) {
        const qMatch = url.match(/[?&]q=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
        if (qMatch) {
            lat = parseFloat(qMatch[1]);
            lng = parseFloat(qMatch[2]);
        }
    }

    // Format 3: https://www.google.com/maps/search/?api=1&query=lat,lng
    if (!lat || !lng) {
        const queryMatch = url.match(/[?&]query=(-?\d+\.?\d*),(-?\d+\.?\d*)/);
        if (queryMatch) {
            lat = parseFloat(queryMatch[1]);
            lng = parseFloat(queryMatch[2]);
        }
    }

    // Format 4: https://www.google.com/maps/@lat,lng,zoom
    if (!lat || !lng) {
        const atMatch = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*),(\d+\.?\d*)?z/);
        if (atMatch) {
            lat = parseFloat(atMatch[1]);
            lng = parseFloat(atMatch[2]);
        }
    }

    if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
        alert('Coordinates extracted successfully!');
    } else {
        alert('Could not extract coordinates from URL. Please check the URL format or enter coordinates manually.');
    }
}

const photosInput = document.getElementById('photos');
const previewWrapper = document.getElementById('photos-preview-wrapper');
const previewContainer = document.getElementById('photos-preview-container');
const coverInput = document.getElementById('cover_photo_index');

if (photosInput && previewWrapper && previewContainer && coverInput) {
    photosInput.addEventListener('change', function () {
        const files = Array.from(photosInput.files || []);

        previewContainer.innerHTML = '';
        coverInput.value = '';

        if (!files.length) {
            previewWrapper.classList.add('hidden');
            return;
        }

        previewWrapper.classList.remove('hidden');

        files.forEach((file, index) => {
            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                const item = document.createElement('div');
                item.className = 'relative group photo-item';
                item.dataset.index = String(index);

                item.innerHTML = '<img src="' + event.target.result + '" alt="Photo" class="w-full h-24 object-cover rounded-lg">' +
                    '<div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">' +
                    '<button type="button" class="px-3 py-1 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-xs font-medium rounded">Cover</button>' +
                    '</div>';

                previewContainer.appendChild(item);

                const button = item.querySelector('button');

                if (button) {
                    button.addEventListener('click', function () {
                        const items = previewContainer.querySelectorAll('.photo-item');

                        items.forEach(element => {
                            element.classList.remove('ring-4', 'ring-[#96A480]');
                            const badge = element.querySelector('.cover-badge');

                            if (badge) {
                                badge.remove();
                            }
                        });

                        item.classList.add('ring-4', 'ring-[#96A480]');

                        const badge = document.createElement('span');
                        badge.className = 'cover-badge absolute top-2 left-2 bg-[#96A480] text-white text-xs font-semibold px-2 py-1 rounded';
                        badge.textContent = 'Cover';
                        item.appendChild(badge);

                        coverInput.value = String(index);
                    });
                }
            };

            reader.readAsDataURL(file);
        });
    });
}
</script>
@endsection

@push('scripts')
<script>
    function autoFillPic(select) {
        const option = select.options[select.selectedIndex];
        if (option.value) {
            document.getElementById('pic_ref_number').value = option.dataset.ref;
            document.getElementById('pic_name').value = option.dataset.name;
            document.getElementById('pic_email').value = option.dataset.email || '';
            document.getElementById('pic_whatsapp_number').value = option.dataset.whatsapp || '';
        }
    }

    // Form Validation with Alert
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = document.querySelectorAll('[required]');
        let isValid = true;
        let missingFields = [];

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                
                // Get label text
                const label = document.querySelector(`label[for="${field.id}"]`);
                const fieldName = label ? label.innerText.replace('*', '').trim() : (field.name || field.id);
                missingFields.push(fieldName);
                
                // Remove error styling on input
                field.addEventListener('input', function() {
                    if (this.value.trim()) {
                        this.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                    }
                }, { once: true });
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in the following required fields:\n- ' + missingFields.join('\n- '));
            
            // Focus the first invalid field
            const firstInvalid = document.querySelector('.border-red-500');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
</script>
@endpush
