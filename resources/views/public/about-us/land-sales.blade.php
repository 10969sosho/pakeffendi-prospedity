@extends('public.layouts.app')

@section('title', 'Land Sales | PROSPEDITY')

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
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">LAND SALES</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-center">
            <p class="text-gray-700 leading-relaxed mb-6">
                PROSPEDITY offers land for development, commercial and residential projects to suit the needs of our wide client base. Our Land For Sale listings come with stunning landscapes available in the popular areas of Canggu, Pererenan, Batu Bolong, Umalas, Seminyak, Land sales are also available on the nearby islands with direct access from Bali such as Gili Meno, Gili Trawangan, Gili Air, Gili Gede, Nusa Ceningan, Nusa Lembongan and Nusa Penida.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Curious about a tropical paradise that awaits you close to Bali, yet mostly undiscovered by tourists? Consider a beachfront investment for the future in Palau Sumba, Sumbawa or Lombok. PROSPEDITY has unique areas of land available for long-term investments including absolute beachfront that is picture perfect! From Denpasar Bali, Palau Sumba is about a 1-hour flight, Sumbawa is just under 3 hours and the popular island of Lombok is a short 30-minute flight.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Each listing in the Bali real estate catalogue has a different panoramic view from the beachfront to the rice fields, the jungle, or the river. Whatever view you are searching for; we can help you find it. Our team is committed to offering you our knowledge and expertise in the consultancy and acquisition of land particularly in south Bali but also in surroundings.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Our Land Sales Team can provide you with carefully selected properties on various terrain all with the legal permission for future development. For home or business, we have land available to match your next dream project in Bali.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-6">
                Interested in purchasing land in Bali? We can help you to secure the land you are after and we understand the importance of each purchase our clients make. We make selecting the ideal piece of land possible with our professional services. These include a suitable selection of property, private viewings arranged with our driver and price negotiation with full transparency.
            </p>
            
            <p class="text-gray-700 leading-relaxed mb-12">
                We work in collaboration with a notary for all due diligence to handle each aspect of purchasing the land. Our team can check every requirement before finalising the land sales, our partner can handle land re-measurement, topography, and soil testing. Finally, our team can provide you with over 15 years of experience in project construction ensuring your land purchase is the best opportunity available for you and your project.
            </p>
        </div>

        <!-- Location Sections -->
        <div class="mt-16 space-y-12 text-center">
            <!-- Freehold -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">FREEHOLD</h3>
                <div class="space-y-4 text-gray-700">
                    <p>Canggu | Berawa | Canggu Residential Side | Pererenan</p>
                    <p>Seminyak | Umalas | Kerobokan</p>
                    <p>Tanah Lot | Other Bali Area | Other Indo Island</p>
                </div>
            </div>

            <!-- Leasehold -->
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-6">LEASEHOLD</h3>
                <div class="space-y-4 text-gray-700">
                    <p>Canggu | Berawa | Canggu Residential Side | Pererenan</p>
                    <p>Seminyak | Umalas | Kerobokan</p>
                    <p>Tanah Lot | Other Bali Area | Other Indo Island</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

