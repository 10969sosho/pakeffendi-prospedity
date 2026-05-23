@extends('public.layouts.app')

@section('title', 'Management & Construction | PROSPEDITY')

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
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">MANAGEMENT & CONSTRUCTION</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Property Management Section -->
        <div class="mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">PROPERTY MANAGEMENT</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY has a fantastic network across Bali with a qualified and professional team of staff ready to meet and assist you with your home. Our strong commitment to our clients helps us to achieve a high level of comfort and trust. This is something we have built over time. To learn more about our Property Management please connect with our team on social media and view our online customer reviews.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Our property managers will save your time and money with the right advice. Let us take care of your property. First, we ensure our team understands the needs of each client to meet the renters' expectations. Our staff are highly trained through our recruitment process ensuring competence in their role. Our team will arrange any necessary property repairs, maintenance and improvements plus facilitate the direct assistance required in case of an Emergency.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    We have every aspect of each service covered with qualified electricians, plumbers, construction workers and general maintenance and repair staff ready to go. PROSPEDITY guarantees our highly regarded contractors who have built over 80 properties consistently for the past ten years. As our valued client, you can relax knowing that our management team is organising the timely and secure payments of all costs and bills for services such as home internet and monthly home cleaning costs.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    We provide our clients with a comprehensive monthly financial report and a guest feedback report. Our management services can include consulting and additional support for relations with local authorities if required.
                </p>
            </div>
        </div>

        <!-- Construction Consulting Section -->
        <div class="text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">CONSTRUCTION CONSULTING</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    Since 2012, PROSPEDITY selection of contractor partners have build impressive projects on the island of Bali. Our partners have professional and highly sought after team, they have completed more than fifty construction projects including multiple villas, commercial spaces and luxury apartments. The consistency and high standard of their teams are due to a 15-year work history that we are proud to say offers clients the best network of people available on the island.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    PROSPEDITY has developed a wide network of established contractors in the region, allowing us to select the suppliers who best match with your ideas and individual personality. We strive every day to refine our techniques, seek out up and coming artisans and designers, finding only the best materials to build world-class properties. We know how important your future real estate project is, as it not only represents a new beginning but also the start of personal investment here in Bali. We welcome you to connect with our team and let us take care of your construction projects, ensuring it is a success, from beginning to end.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

