@extends('admin.layouts.app')

@section('title', 'New Package')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.service-packages.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to List
    </a>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
    <h1 class="text-2xl font-bold text-slate-900 mb-6">New Package</h1>

    <form action="{{ route('admin.service-packages.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="short_description" id="short_description" rows="5"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">{{ old('short_description') }}</textarea>
                @error('short_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="normal_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Normal</label>
                    <input type="number" step="0.01" name="normal_price" id="normal_price" value="{{ old('normal_price') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                    @error('normal_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Diskon (opsional)</label>
                    <input type="number" step="0.01" name="discount_price" id="discount_price" value="{{ old('discount_price') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                    @error('discount_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-[#96A480] shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="bg-[#96A480] text-white px-6 py-2 rounded-lg hover:bg-[#7A8A6A] transition-colors font-semibold shadow-sm">
                    Create Package
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
