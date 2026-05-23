@extends('public.layouts.app')

@section('title', 'Villa Rentals | PROSPEDITY')

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
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">VILLA RENTALS</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">RENT YOUR VILLA WITH US</h2>
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800" alt="Luxury Villa" class="w-full max-w-3xl mx-auto h-auto rounded-lg shadow-lg">
        </div>

        <!-- Content Text -->
        <div class="mt-12 prose prose-lg max-w-none text-center">
            <p class="text-gray-700 leading-relaxed mb-6">
                PROSPEDITY offers a wide range of villas for both yearly and monthly rental arrangements. Renting a property in Bali has many advantages including great value for money. Select a home that matches your style and our team at PROSPEDITY will settle with finding you nothing less than what you are looking for. Pool view? Ocean frontage? Tropical garden oasis? No matter what you are seeking, we believe Bali's Island of the God's has something special just for you.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                PROSPEDITY proudly handpicks each of our rental properties from the real estate market to develop honest and clear representations of each rental. Our personalised service is founded on trust and reliability and we are ready to show you a beautiful portfolio of ready to go rentals including properties with monthly or yearly contracts.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Rental properties are available in many forms including a range of villas, apartments, houses and luxury penthouses. Locations include Canggu, Berawa, Echo Beach, Batu Bolong, Umalas, Pererenan, Seseh, Seminyak, Sanur, Ubud and the Bukit Peninsula. Contracts are continuously added and updated with listings from $7000.00 to $100.000 per year.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Our rental portfolio is continuously expanding. Our professional team is ready to support you through each step of the rental process. First, our team will do a suitable selection of available rental properties for you following your rental preferences. Furthermore, each time there is a new listing on the database that matches your given preferences, you will be notified by our team.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Our team will arrange with you to view your selected rental properties and can schedule these visits with a private driver at your request. This is certainly one of the best ways to view several properties with ease whilst seeing the local neighbourhood on the island.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                As part of the rental service, we will handle the price negotiation of each rental listing in total transparency as well as providing any required legal support services. Legal services are included in our agency fee and we ensure each agreement is legalised with a notary service.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Additional services are available to our clients including assistance in the hiring of property staff such as housekeeping or landscaping maintenance, lease extensions, handling the intermediary between owner and tenant during the lease period and offer support as a neutral intermediary party if any discrepancies arise.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-12">
                PROSPEDITY will hold the Security Bond in an escrow amount and manage all related concerns with bond deposits at the end stages of each contract. Our staff will manage the inventory of the property ensuring that renting with us is stress-free from the beginning through to the key handover when you move into your new home.
            </p>
        </div>

        <!-- Location Sections -->
        <div class="mt-16 space-y-12 text-center">
            <!-- Yearly Rental Villa -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">YEARLY RENTAL VILLA</h3>
                <div class="space-y-4 text-gray-700">
                    <p>Canggu | Berawa | Canggu Residential Side | Pererenan</p>
                    <p>Seminyak | Batu Belig | Petitenget</p>
                    <p>Umalas | Kerobokan</p>
                    <p>Tanah Lot | Other Bali Area</p>
                </div>
            </div>

            <!-- Monthly Rental Villa -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">MONTHLY RENTAL VILLA</h3>
                <div class="space-y-4 text-gray-700 mb-6">
                    <p>Canggu | Berawa | Canggu Residential Side | Pererenan</p>
                    <p>Seminyak | Batu Belig | Petitenget</p>
                    <p>Umalas | Kerobokan</p>
                    <p>Tanah Lot | Other Bali Area</p>
                </div>
                <div class="text-gray-700">
                    <p class="font-semibold">1 Bedroom | 2 Bedrooms | 3 Bedrooms | 4 Bedrooms | 5+ Bedrooms</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

