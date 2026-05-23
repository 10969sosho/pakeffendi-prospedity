@extends('admin.layouts.app')

@section('title', 'View Property')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
            @if($property->area)
                <p class="mt-2 text-sm font-semibold text-gray-700">{{ $property->area }}</p>
            @endif
            <p class="mt-1 text-sm text-gray-600">{{ $property->location_text }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.properties.edit', $property->id) }}" class="inline-flex items-center px-6 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg shadow transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.properties.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-lg shadow hover:bg-gray-50 transform hover:scale-105 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="w-1 h-8 bg-[#96A480] rounded-full mr-3"></span>
                    Description
                </h2>
                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>

            <!-- Photos -->
            @if($property->getMedia('photos')->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <span class="w-1 h-8 bg-[#96A480] rounded-full mr-3"></span>
                        Photos
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($property->getMedia('photos') as $photo)
                            <div class="relative group overflow-hidden rounded-lg">
                                @php
                                    $photoUrl = '/storage/' . $photo->id . '/' . $photo->file_name;
                                @endphp
                                <img src="{{ $photoUrl }}" alt="Property photo" class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <a href="{{ $photoUrl }}" target="_blank" class="text-white">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Price Card -->
            <div class="bg-[#96A480] rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-sm font-medium text-white/80 mb-2">Price</h3>
                @php
                    $displayPrice = null;
                    if ($property->price_freehold && $property->price_freehold > 0) {
                        $displayPrice = $property->price_freehold;
                    } elseif ($property->price_leasehold && $property->price_leasehold > 0) {
                        $displayPrice = $property->price_leasehold;
                    } elseif ($property->price_monthly && $property->price_monthly > 0) {
                        $displayPrice = $property->price_monthly;
                    } elseif ($property->price_yearly && $property->price_yearly > 0) {
                        $displayPrice = $property->price_yearly;
                    }
                @endphp
                @if($displayPrice)
                    <p class="text-3xl font-bold">IDR {{ number_format($displayPrice, 0, ',', '.') }}</p>
                @else
                    <p class="text-3xl font-bold">N/A</p>
                @endif
            </div>

            <!-- Details Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <span class="w-1 h-6 bg-[#96A480] rounded-full mr-2"></span>
                    Details
                </h3>
                <dl class="space-y-3">
                    @if($property->latitude && $property->longitude)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Coordinates</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $property->latitude }}, {{ $property->longitude }}</dd>
                        </div>
                    @endif
                    @if($property->land_size)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Land Size</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $property->land_size }} m²</dd>
                        </div>
                    @endif
                    @if($property->building_size)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Building Size</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $property->building_size }} m²</dd>
                        </div>
                    @endif
                    @if($property->year_of_build)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Year Built</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $property->year_of_build }}</dd>
                        </div>
                    @endif
                    @if($property->bedroom)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Bedrooms</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $property->bedroom }}</dd>
                        </div>
                    @endif
                    @if($property->bathroom)
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Bathrooms</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $property->bathroom }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            <!-- Quick Actions -->
            <div class="bg-[#96A480] rounded-xl shadow-lg p-6 text-white">
                <h3 class="text-lg font-bold mb-4">Quick Actions</h3>
                <div class="space-y-2">
                <a href="{{ route('admin.properties.edit', $property->id) }}" class="block w-full bg-white/20 hover:bg-white/30 px-4 py-2 rounded-lg text-sm font-medium transition-colors text-center">
                    Edit Property
                </a>
                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="block w-full bg-slate-700 hover:bg-slate-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Delete Property
                    </button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
