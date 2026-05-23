@extends('public.layouts.app')

@section('title', 'Blog | PROSPEDITY')

@section('content')
<!-- Hero Section -->
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background) 
        ? asset('storage/' . $homeSetting->hero_background) 
        : null;
@endphp
<section class="relative h-96 bg-cover bg-center" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">BLOG</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-gray-600 text-lg">Blog content coming soon...</p>
        </div>
    </div>
</section>
@endsection

