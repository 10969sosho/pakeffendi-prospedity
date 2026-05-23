@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Properties Card -->
        <div class="bg-[#96A480] rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium">Total Properties</p>
                    <p class="text-3xl font-bold mt-2">{{ $totalProperties }}</p>
                </div>
                <div class="bg-white/20 p-4 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="bg-[#7A8A6A] rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium">Quick Actions</p>
                    <p class="text-3xl font-bold mt-2">New</p>
                </div>
                <div class="bg-white/20 p-4 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
            </div>
            <a href="{{ route('admin.properties.create') }}" class="mt-4 inline-block bg-white/15 hover:bg-white/25 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Add Property →
            </a>
        </div>

        <!-- Recent Activity Card -->
        <div class="bg-[#96A480] rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium">Recent Activity</p>
                    <p class="text-3xl font-bold mt-2">{{ $recentProperties->count() }}</p>
                </div>
                <div class="bg-white/20 p-4 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- System Status Card -->
        <div class="bg-[#5B6A49] rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white/80 text-sm font-medium">System Status</p>
                    <p class="text-3xl font-bold mt-2">Active</p>
                </div>
                <div class="bg-white/15 p-4 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Properties Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-[#96A480] px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Recent Properties
                </h2>
                <a href="{{ route('admin.properties.index') }}" class="text-white/90 hover:text-white text-sm font-medium">
                    View All →
                </a>
            </div>
        </div>
        <div class="p-6">
            @forelse($recentProperties as $property)
                <div class="border-l-4 border-[#96A480] bg-slate-50 rounded-lg p-4 mb-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <a href="{{ route('admin.properties.show', $property->id) }}" class="block">
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-[#5B6A49] transition-colors">
                                    {{ $property->title }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ Str::limit($property->location_text, 60) }}
                                </p>
                            </a>
                        </div>
                        <div class="ml-4 text-right">
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
                                <p class="text-lg font-bold text-[#5B6A49]">IDR {{ number_format($displayPrice, 0, ',', '.') }}</p>
                            @else
                                <p class="text-lg font-bold text-gray-400">N/A</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">{{ $property->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center space-x-4">
                        <a href="{{ route('admin.properties.show', $property->id) }}" class="text-sm text-[#5B6A49] hover:text-[#3F4934] font-medium">View</a>
                        <a href="{{ route('admin.properties.edit', $property->id) }}" class="text-sm text-[#5B6A49] hover:text-[#3F4934] font-medium">Edit</a>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No properties</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new property.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#96A480] hover:bg-[#7A8A6A]">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Property
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
