@extends('admin.layouts.app')

@section('title', 'Featured Properties')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Featured Properties</h1>
            <p class="mt-2 text-sm text-gray-600">Manage and order your featured properties (Drag to reorder)</p>
        </div>
        <a href="{{ route('admin.properties.index') }}" class="inline-flex items-center px-6 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg shadow transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Manage All Properties
        </a>
    </div>

    <!-- Properties Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#96A480]">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider w-10">Order</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Property Number</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Title</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-list" class="bg-white divide-y divide-gray-200">
                    @forelse($featuredProperties as $property)
                        <tr data-id="{{ $property->id }}" class="hover:bg-slate-50 transition-colors cursor-move">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                    <span class="order-number font-bold">{{ $loop->iteration }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-[#96A480]">{{ $property->property_number ?? '-' }}</div>
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
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full {{ $property->property_status == 'AVAILABLE' ? 'bg-green-100 text-green-600' : ($property->property_status == 'SOLD' ? 'bg-red-100 text-red-600' : 'bg-yellow-100 text-yellow-600') }}">
                                        {{ $property->property_status }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-600">AVAILABLE</span>
                                @endif
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
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.properties.edit', $property->id) }}" class="text-[#5B6A49] hover:text-[#3F4934] font-semibold">Edit</a>
                                <form action="{{ route('admin.featured-properties.destroy', $property->id) }}" method="POST" class="inline" onsubmit="return confirm('Remove from featured?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 font-semibold">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No featured properties</h3>
                                <p class="mt-1 text-sm text-gray-500">Go to properties list and mark some as featured.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('sortable-list');
        var sortable = Sortable.create(el, {
            animation: 150,
            onEnd: function (evt) {
                var order = [];
                document.querySelectorAll('#sortable-list tr').forEach(function(row, index) {
                    order.push(row.getAttribute('data-id'));
                    row.querySelector('.order-number').textContent = index + 1;
                });

                // Send update to server
                fetch('{{ route("admin.featured-properties.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Optional: show toast notification
                        console.log('Order updated');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
</script>
@endsection
