@extends('public.layouts.app')

@section('title', 'Pemesanan Paket - PROSPEDITY')

@section('content')
@php
    $formatPrice = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };
@endphp

<section class="relative h-72 bg-cover bg-center mt-[220px]" style="background-color: #96A480;">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white uppercase tracking-wide">Beli Paket</h1>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
                    <div class="text-sm text-gray-500">Paket dipilih</div>
                    <h2 class="mt-2 text-xl font-semibold text-gray-900">{{ $servicePackage->name }}</h2>

                    @if($servicePackage->short_description)
                        <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                            {{ $servicePackage->short_description }}
                        </p>
                    @endif

                    <div class="mt-5">
                        @if($servicePackage->discount_price !== null)
                            <div class="text-sm text-gray-500 line-through">
                                {{ $formatPrice($servicePackage->normal_price) }}
                            </div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $formatPrice($servicePackage->discount_price) }}
                            </div>
                        @else
                            <div class="text-2xl font-bold text-gray-900">
                                {{ $formatPrice($servicePackage->normal_price) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Form Pemesanan</h2>

                    <form action="{{ route('our-services.order.store', $servicePackage) }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="customer_full_name" class="block text-sm font-medium text-gray-700 mb-2">Nama lengkap *</label>
                                <input type="text" name="customer_full_name" id="customer_full_name" value="{{ old('customer_full_name') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                                @error('customer_full_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                                @error('company_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="whatsapp_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp *</label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                                       placeholder="628xxxxxxxxxxx">
                                @error('whatsapp_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-8">
                            <label for="pic_number" class="block text-sm font-medium text-gray-700 mb-2">PIC Number (opsional)</label>
                            <input type="text" name="pic_number" id="pic_number" value="{{ old('pic_number') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                                   placeholder="Isi jika sebelumnya sudah pernah membeli">
                            @error('pic_number')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-[#96A480] hover:bg-[#7A8A6A] text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                                Kirim Pemesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
