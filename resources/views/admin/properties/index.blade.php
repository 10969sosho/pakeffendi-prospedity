@extends('admin.layouts.app')

@section('title', 'Properties')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
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
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Properties</h1>
            <p class="mt-2 text-sm text-gray-600">Manage all your properties</p>
        </div>
        <a href="{{ route('admin.properties.create') }}" class="inline-flex items-center px-6 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg shadow transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Property
        </a>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('admin.properties.index') }}" class="space-y-4">
            <!-- First Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter by Property Number -->
                <div>
                    <label for="property_number" class="block text-sm font-medium text-gray-700 mb-2">Property Number</label>
                    <input type="text" name="property_number" id="property_number" value="{{ request('property_number') }}" placeholder="PN251200001" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by Transaction Number -->
                <div>
                    <label for="transaction_number" class="block text-sm font-medium text-gray-700 mb-2">Transaction Number</label>
                    <input type="text" name="transaction_number" id="transaction_number" value="{{ request('transaction_number') }}" placeholder="Search transaction..." class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ request('title') }}" placeholder="Search title..." class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by Type -->
                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="property_type" id="property_type" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                        <option value="">All Types</option>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->slug }}" {{ request('property_type') == $type->slug ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Status -->
                <div>
                    <label for="property_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="property_status" id="property_status" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                        <option value="">All Status</option>
                        <option value="DRAFT" {{ request('property_status') == 'DRAFT' ? 'selected' : '' }}>DRAFT</option>
                        <option value="AVAILABLE" {{ request('property_status') == 'AVAILABLE' ? 'selected' : '' }}>AVAILABLE</option>
                        <option value="SOLD" {{ request('property_status') == 'SOLD' ? 'selected' : '' }}>SOLD</option>
                        <option value="RENTED" {{ request('property_status') == 'RENTED' ? 'selected' : '' }}>RENTED</option>
                        <option value="EXPIRED" {{ request('property_status') == 'EXPIRED' ? 'selected' : '' }}>EXPIRED</option>
                    </select>
                </div>
            </div>

            <!-- Second Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter by Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" name="location" id="location" value="{{ request('location') }}" placeholder="Search location..." class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by Created By -->
                <div>
                    <label for="admin_id" class="block text-sm font-medium text-gray-700 mb-2">Created By</label>
                    <select name="admin_id" id="admin_id" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                        <option value="">All Users</option>
                        @foreach($adminUsers as $admin)
                            <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter by Views Min -->
                <div>
                    <label for="views_min" class="block text-sm font-medium text-gray-700 mb-2">Views (Min)</label>
                    <input type="number" name="views_min" id="views_min" value="{{ request('views_min') }}" placeholder="0" min="0" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by Views Max -->
                <div>
                    <label for="views_max" class="block text-sm font-medium text-gray-700 mb-2">Views (Max)</label>
                    <input type="number" name="views_max" id="views_max" value="{{ request('views_max') }}" placeholder="999999" min="0" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>
            </div>

            <!-- Third Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter by Date From -->
                <div>
                    <label for="created_from" class="block text-sm font-medium text-gray-700 mb-2">Created From</label>
                    <input type="date" name="created_from" id="created_from" value="{{ request('created_from') }}" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by Date To -->
                <div>
                    <label for="created_to" class="block text-sm font-medium text-gray-700 mb-2">Created To</label>
                    <input type="date" name="created_to" id="created_to" value="{{ request('created_to') }}" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter Buttons -->
                <div class="flex items-end gap-2 md:col-span-2">
                    <button type="submit" class="flex-1 px-6 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.properties.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Properties Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#96A480]">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Property Number</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Transaction</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Location</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Created By</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Views</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Created</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($properties as $property)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-[#96A480]">{{ $property->property_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-700">{{ $property->transaction_number ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $property->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($property->property_type)
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-[#E4E9DD] text-[#5B6A49] uppercase">
                                        {{ $property->property_type }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($property->property_status)
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full {{ $property->property_status == 'AVAILABLE' ? 'bg-green-100 text-green-600' : ($property->property_status == 'SOLD' ? 'bg-red-100 text-red-600' : ($property->property_status == 'EXPIRED' ? 'bg-gray-100 text-gray-600' : 'bg-yellow-100 text-yellow-600')) }}">
                                        {{ $property->property_status }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-600">AVAILABLE</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-600">{{ Str::limit($property->location_text, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-[#96A480] text-white">
                                        IDR {{ number_format($displayPrice, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full bg-gray-400 text-white">
                                        N/A
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-700">
                                    @if($property->admin)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="font-medium">{{ $property->admin->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ number_format($property->views ?? 0) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $property->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2 sticky right-0 bg-white z-10 shadow-[-5px_0_5px_-5px_rgba(0,0,0,0.1)]">
                                <a href="{{ route('admin.properties.show', $property->id) }}" class="text-[#5B6A49] hover:text-[#3F4934] font-semibold">View</a>
                                <a href="{{ route('admin.properties.edit', $property->id) }}" class="text-[#5B6A49] hover:text-[#3F4934] font-semibold">Edit</a>
                                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this property?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-semibold">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
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
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="bg-white rounded-xl shadow-lg p-4">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
