@extends('admin.layouts.app')

@section('title', 'Successful Properties')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-4 bg-[#E4E9DD] border-l-4 border-[#96A480] text-[#3F4934] p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-[#96A480]" viewBox="0 0 20 20" fill="currentColor">
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
        <div class="mb-4 bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded">
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
            <h1 class="text-3xl font-bold text-gray-900">Successful Properties</h1>
            <p class="mt-2 text-sm text-gray-600">Properties that have been sold or rented</p>
        </div>
        <a href="{{ route('admin.properties.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-lg shadow hover:bg-gray-50 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Properties
        </a>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('admin.properties.successful') }}" class="space-y-4">
            <!-- First Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter by Property Number -->
                <div>
                    <label for="property_number" class="block text-sm font-medium text-gray-700 mb-2">Property Number</label>
                    <input type="text" name="property_number" id="property_number" value="{{ request('property_number') }}" placeholder="PN251200001" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

                <!-- Filter by PIC REF NUMBER -->
                <div>
                    <label for="pic_ref_number" class="block text-sm font-medium text-gray-700 mb-2">PIC REF NUMBER</label>
                    <input type="text" name="pic_ref_number" id="pic_ref_number" value="{{ request('pic_ref_number') }}" placeholder="Search PIC REF NUMBER..." class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
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
                        <option value="VILLA" {{ request('property_type') == 'VILLA' ? 'selected' : '' }}>VILLA</option>
                        <option value="LAND" {{ request('property_type') == 'LAND' ? 'selected' : '' }}>LAND</option>
                        <option value="HOUSE" {{ request('property_type') == 'HOUSE' ? 'selected' : '' }}>HOUSE</option>
                        <option value="APARTMENT" {{ request('property_type') == 'APARTMENT' ? 'selected' : '' }}>APARTMENT</option>
                    </select>
                </div>
            </div>

            <!-- Second Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter by Status -->
                <div>
                    <label for="property_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="property_status" id="property_status" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                        <option value="">All Status</option>
                        <option value="SOLD" {{ request('property_status') == 'SOLD' ? 'selected' : '' }}>SOLD</option>
                        <option value="RENTED" {{ request('property_status') == 'RENTED' ? 'selected' : '' }}>RENTED</option>
                    </select>
                </div>

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
            </div>

            <!-- Third Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Filter by Views Max -->
                <div>
                    <label for="views_max" class="block text-sm font-medium text-gray-700 mb-2">Views (Max)</label>
                    <input type="number" name="views_max" id="views_max" value="{{ request('views_max') }}" placeholder="999999" min="0" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                </div>

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
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-6 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('admin.properties.successful') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
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
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">PIC REF NUMBER</th>
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
                                <div class="text-sm font-semibold text-gray-900">{{ $property->pic_ref_number ?? '-' }}</div>
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
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full {{ $property->property_status == 'SOLD' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600' }}">
                                        {{ $property->property_status }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.properties.show', $property->id) }}" class="inline-flex items-center px-3 py-1.5 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-semibold rounded-lg transition-colors">Detail</a>
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
                            <td colspan="11" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No successful properties</h3>
                                <p class="mt-1 text-sm text-gray-500">Properties marked as SOLD or RENTED will appear here.</p>
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

