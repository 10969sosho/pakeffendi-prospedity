@extends('public.layouts.app')

@section('title', 'Company Presentation | PROSPEDITY')

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
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">COMPANY PRESENTATION</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- The Agency Section -->
        <div class="mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">The Agency</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY (PT. Bali Properti Kontruksi) Company Presentation Introduction:
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY (PT. Bali Properti Kontruksi) is a Licenced Property Agency (SIUP-P4) located in Bali Indonesia and has been successfully operating as a trustworthy and reputable real estate agency for the past nine years. Chris, Lucas, and Pierre make up the team of expert real estate agents who are highly familiar with all aspects of the market on the island. Long-standing partnerships and a committed, dedicated team are the driving force behind the work that takes place every day at PROSPEDITY.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    As part of the Real Estate Broker Association of Indonesia (AREBI), PROSPEDITY offers luxury real estate across the region to a local and international client base. Catering to a wide range of property requests, the team will ensure they can find a property, land, or residential listing, to match each client's requirements. Let us introduce ourselves to you.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    As the first real estate agency in Canggu Bali, our team holds the largest villa and land listing catalog, which is prepared with timely due diligence and updated every month. This provides our clients with numerous opportunities and ensures every corner of the real estate market on the island is discoverable.
                </p>
            </div>
        </div>

        <!-- Featured Section -->
        <div class="mb-16 bg-gray-50 p-8 rounded-lg text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">FEATURED PROSPEDITY ON:</h3>
            <h4 class="text-xl font-semibold text-gray-700 mb-8">INTERNATIONAL BUYERS SUSTAIN BALI'S MARKET</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 justify-items-center">
                <div>Villa Rentals</div>
                <div>Villa Sales</div>
                <div>Land Sales</div>
                <div>Notary Service</div>
                <div>Law Service</div>
                <div>Property Management</div>
                <div>Construction Consulting</div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">THE TEAM</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY has a well-versed and highly skilled team of real estate agents passionate about the island and its people. The team handles the rentals and sales inquiries for both rentals and sales listings. This includes monthly and yearly leases on rental villas and leasehold and freehold contracts for villas and land for sale.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    The dynamic team speaks Indonesian, English, French, Italian, and Chinese and is familiar with the local culture in Bali. There are many important points to check when acquiring property in Bali and our experienced team will provide you with a comprehensive overview. Living on the island, our agents can give first-hand knowledge of the local communities and the properties in Bali.
                </p>
            </div>

            <!-- Team Members Placeholder -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-12">
                <!-- Team Member 1 -->
                <div class="text-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Photo</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Name</h4>
                    <p class="text-gray-600">Position</p>
                </div>
                
                <!-- Team Member 2 -->
                <div class="text-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Photo</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Name</h4>
                    <p class="text-gray-600">Position</p>
                </div>
                
                <!-- Team Member 3 -->
                <div class="text-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Photo</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Name</h4>
                    <p class="text-gray-600">Position</p>
                </div>
            </div>
        </div>

        <!-- YouTube Video Section -->
        <div class="mb-16 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Company Video</h3>
            <div class="aspect-video bg-gray-200 rounded-lg flex items-center justify-center max-w-4xl mx-auto">
                <p class="text-gray-400">YouTube Video Embed Placeholder</p>
            </div>
        </div>
    </div>
</section>
@endsection

