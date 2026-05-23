@extends('public.layouts.app')

@section('title', 'Advisor Guide - PROSPEDITY')

@section('content')
<!-- Hero Section -->
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background) 
        ? asset('storage/' . $homeSetting->hero_background) 
        : null;
@endphp
<section class="relative h-96 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">ADVISOR GUIDE</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <p class="text-lg text-gray-700 leading-relaxed">
                Koleksi artikel dan panduan dari advisor kami terkait investasi dan properti di Bali.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($guides as $guide)
                <a href="{{ route('advisor-guide.show', $guide) }}" class="block bg-white rounded-lg shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow group">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2 group-hover:text-[#5B6A49] transition-colors">
                        {{ $guide->title }}
                    </h2>
                    @if($guide->published_at)
                        <p class="text-sm text-gray-500">
                            Published on {{ $guide->published_at->format('d M Y') }}
                        </p>
                    @endif
                    <p class="mt-3 text-gray-700 text-sm truncate">
                        {{ $guide->content ? \Illuminate\Support\Str::limit(preg_replace("/\r\n|\r|\n/", ' ', $guide->content), 160) : 'Klik untuk membaca detail artikel.' }}
                    </p>
                    <div class="mt-4 text-sm font-medium text-[#96A480] group-hover:text-[#7A8A6A] transition-colors">
                        Baca selengkapnya &rarr;
                    </div>
                </a>
            @empty
                <div class="text-center py-12 col-span-full">
                    <p class="text-gray-500 text-lg">
                        Belum ada artikel Advisor Guide yang dipublikasikan.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
