@extends('public.layouts.app')

@section('title', 'Notary and Law Services | PROSPEDITY')

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
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">NOTARY AND LAW SERVICES</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-center">
            <p class="text-gray-700 leading-relaxed mb-6">
                PROSPEDITY provides our clients with the opportunity to work with our notary team and our appointed law team when required.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-12">
                This includes document legalisation and certification, property due diligence and land zoning verification. Notary services can include notary consultation, purchase of leasehold property, power of attorney, legalizing inventory, watermark documents and due diligence. The services of our lawyers can include litigation and non-litigation needs, civil and criminal law services.
            </p>
        </div>
    </div>
</section>
@endsection

