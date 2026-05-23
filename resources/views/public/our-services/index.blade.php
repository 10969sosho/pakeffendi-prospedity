@extends('public.layouts.app')

@section('title', 'Our Services - PROSPEDITY')

@section('content')
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background)
        ? asset('storage/' . $homeSetting->hero_background)
        : null;
@endphp

<section class="relative h-96 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">OUR SERVICES</h1>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Pricelist Paket Layanan</h2>
            <p class="mt-2 text-gray-600">Pilih paket yang sesuai kebutuhan Anda dan lanjutkan pemesanan.</p>
        </div>

        @php
            $formatPrice = function ($value) {
                return 'Rp ' . number_format((float) $value, 0, ',', '.');
            };
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($packages as $package)
                <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden flex flex-col">
                    <div class="p-6 flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">{{ $package->name }}</h3>

                        @if($package->short_description)
                            <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($package->short_description, 180) }}
                            </p>
                        @endif

                        <div class="mt-5">
                            @if($package->discount_price !== null)
                                <div class="text-sm text-gray-500 line-through">
                                    {{ $formatPrice($package->normal_price) }}
                                </div>
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $formatPrice($package->discount_price) }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Harga diskon</div>
                            @else
                                <div class="text-2xl font-bold text-gray-900">
                                    {{ $formatPrice($package->normal_price) }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Harga normal</div>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 pt-0">
                        <a href="{{ route('our-services.order.create', $package) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-semibold rounded-lg transition-colors">
                            Beli Paket
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-14 bg-gray-50 rounded-xl border border-gray-200">
                        <p class="text-gray-600">Belum ada paket aktif. Silakan cek kembali nanti.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
