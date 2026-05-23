@extends('admin.layouts.app')

@section('title', 'Service Packages')

@section('content')
@php
    $formatPrice = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };
@endphp

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Service Packages</h1>
    <a href="{{ route('admin.service-packages.create') }}"
       class="inline-flex items-center px-4 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-semibold rounded-md shadow-sm">
        + New Package
    </a>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="w-16 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Normal</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($packages as $index => $package)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-center text-gray-500 text-sm">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $package->name }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($package->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $formatPrice($package->normal_price) }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        @if($package->discount_price !== null)
                            {{ $formatPrice($package->discount_price) }}
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $package->slug }}</td>
                    <td class="px-4 py-3 text-sm text-right space-x-2">
                        <a href="{{ route('admin.service-packages.edit', $package) }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Edit
                        </a>
                        <form action="{{ route('admin.service-packages.destroy', $package) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus paket ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-red-300 text-red-700 hover:bg-red-50">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">
                        Belum ada paket. Klik "New Package" untuk menambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
