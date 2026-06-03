@extends('public.layouts.app')

@php
    $canonical = $canonical ?? $seoHelper->cleanCanonical();
@endphp

@section('title', $config['title'])

@section('meta_description', $config['description'])

@section('content')
<!-- Hero Section -->
<section class="relative bg-cover bg-center mt-[220px]" style="background-color: #96A480;">
    <div class="py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 uppercase tracking-wide">
                {{ $config['h1'] }}
            </h1>
            <p class="text-base md:text-lg text-white max-w-3xl mx-auto">
                {{ $config['subtitle'] }}
            </p>
            @if($totalCount > 0)
                <p class="text-white text-sm mt-4 opacity-80">
                    {{ $totalCount }} propert{{ $totalCount > 1 ? 'ies' : 'y' }} available
                </p>
            @endif
        </div>
    </div>
</section>

<!-- SEO Content Section -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none">

            @if($config['section_key'] === 'villas-sale-content')
                <h2>Villas for Sale in Bali — Your Complete Guide</h2>
                <p>Bali's real estate market continues to attract international buyers seeking luxury villas, investment properties, and dream homes in one of the world's most desirable destinations. Whether you're looking for a freehold villa in Canggu, a leasehold investment in Seminyak, or a secluded retreat in Ubud, Prospedity offers an extensive portfolio of carefully curated properties.</p>
                
                <h3>Why Buy a Villa in Bali?</h3>
                <p>Bali offers a unique combination of tropical lifestyle, strong rental yields, and consistent property appreciation. The island's popularity as a tourist destination ensures steady demand for villa rentals, making property investment particularly attractive. Foreign buyers can acquire properties through leasehold agreements, while Indonesian citizens and PMA companies can purchase freehold titles.</p>
                
                <h3>Popular Areas for Villa Purchase</h3>
                <p><strong>Canggu</strong> — Known for its surf beaches, vibrant cafe culture, and digital nomad community. Properties in Berawa, Batu Bolong, and Pererenan are particularly sought after. <strong>Seminyak</strong> — Bali's upscale district with high-end restaurants, boutiques, and beach clubs. Premium villa prices but excellent rental potential. <strong>Ubud</strong> — The cultural heart of Bali, surrounded by rice terraces and jungle. Ideal for wellness retreats and serene living. <strong>Uluwatu</strong> — Clifftop luxury with panoramic ocean views and world-class surf breaks.</p>

                <h3>Freehold vs Leasehold</h3>
                <p><strong>Freehold (Hak Milik)</strong> — Full ownership title available to Indonesian citizens. Can be converted to Hak Guna Bangunan for commercial use by foreign-owned companies. <strong>Leasehold (Hak Sewa)</strong> — The most common option for foreign buyers, offering rights to use the property for a fixed period (typically 25-30 years, extendable). Prospedity can guide you through both options.</p>

                <h3>Investment Potential</h3>
                <p>Bali villas typically yield 8-15% annual returns through vacation rentals. Areas like Canggu and Pererenan have seen property values increase 10-20% annually. With proper management and a prime location, a Bali villa can be both a lifestyle asset and a performing investment.</p>

                <h3>How Prospedity Helps</h3>
                <p>Our team provides end-to-end service: property selection, private viewings, price negotiation, legal due diligence with our partner notary, and post-purchase management. We have over 15 years of combined experience in Bali real estate.</p>

            @elseif($config['section_key'] === 'villas-rent-content')
                <h2>Villas for Rent in Bali — Long Term & Monthly Options</h2>
                <p>Finding the perfect rental villa in Bali is essential for expatriates, digital nomads, and families looking to experience island living without the commitment of ownership. Prospedity offers a wide selection of rental properties across Bali's most desirable neighborhoods.</p>
                
                <h3>Rental Options</h3>
                <p><strong>Yearly Rentals</strong> — Ideal for long-term residents. Yearly contracts offer the best value, typically 20-30% cheaper than monthly rates. Most include maintenance, pool service, and security. <strong>Monthly Rentals</strong> — Flexible option for digital nomads and seasonal residents. Fully furnished villas with all utilities included in many cases.</p>

                <h3>Best Areas for Renting</h3>
                <p><strong>Canggu</strong> — Most popular with expats and remote workers. Vibrant community, coworking spaces, and excellent dining. <strong>Seminyak</strong> — Upscale living with premium amenities and beach access. <strong>Ubud</strong> — Peaceful surroundings ideal for wellness-focused living. <strong>Sanur</strong> — Family-friendly with calm beaches and established expat community.</p>

                <h3>What to Expect</h3>
                <p>Monthly rentals in Bali range from IDR 8 million for a 1-bedroom to IDR 50+ million for luxury 3+ bedroom villas. Yearly contracts typically require 1-2 months deposit. Most properties are fully furnished and include WiFi, pool maintenance, and garden care.</p>

            @elseif($config['section_key'] === 'land-sale-content')
                <h2>Land for Sale in Bali — Investment & Development Opportunities</h2>
                <p>Bali's land market offers significant opportunities for investors and developers. From beachfront plots to hillside terraces with ocean views, the island's limited land supply ensures long-term value appreciation.</p>
                
                <h3>Types of Land Available</h3>
                <p><strong>Residential Land</strong> — Zoned for villa construction in popular areas like Canggu, Pererenan, and Umalas. <strong>Commercial Land</strong> — Suitable for hotels, restaurants, and retail in high-traffic tourism areas. <strong>Agricultural Land</strong> — Rice field and plantation land, some with potential for conversion.</p>

                <h3>Land Ownership in Bali</h3>
                <p>Freehold land is available to Indonesian citizens. Foreign investors typically use leasehold arrangements or establish a PMA (foreign investment company) to acquire Hak Guna Bangunan titles. Our notary partner ensures all due diligence is completed before any transaction.</p>

                <h3>Key Considerations</h3>
                <p>Land zoning, access roads, water supply, electricity connections, and building permits (IMB) are critical factors we help evaluate. Prospedity provides full land measurement, topography assessment, and soil testing services.</p>

            @elseif($config['section_key'] === 'canggu-content')
                <h2>Property in Canggu — Bali's Most Dynamic Real Estate Market</h2>
                <p>Canggu has emerged as Bali's most exciting property market, attracting investors, expatriates, and lifestyle buyers from around the world. Stretching from Berawa in the south to Pererenan in the north, this coastal area offers diverse property options.</p>
                
                <h3>Canggu Neighborhoods</h3>
                <p><strong>Berawa</strong> — Premium beachfront and near-beach properties. Home to Finns Beach Club and upscale dining. <strong>Batu Bolong</strong> — The heart of Canggu's surf and cafe scene. Mix of established villas and new developments. <strong>Pererenan</strong> — Rapidly developing area with larger land plots and a more relaxed atmosphere. <strong>Umalas/Kerobokan</strong> — Residential areas between Seminyak and Canggu with excellent access.</p>

                <h3>Why Invest in Canggu?</h3>
                <p>Canggu has seen consistent property value growth of 15-25% annually. The area's popularity with tourists and long-term residents ensures strong rental demand. New infrastructure, international schools, and healthcare facilities continue to enhance livability.</p>

                <h3>Property Types Available</h3>
                <p>Modern tropical villas with private pools, contemporary apartments in managed complexes, commercial properties for hospitality businesses, and land plots ready for development. Whether buying, renting, or investing, Canggu offers options for every budget and requirement.</p>

            @elseif($config['section_key'] === 'seminyak-content')
                <h2>Property in Seminyak — Premium Bali Real Estate</h2>
                <p>Seminyak represents the pinnacle of Bali luxury real estate. This sophisticated neighborhood combines world-class dining, designer boutiques, and stunning beachfront properties. It remains the preferred choice for high-net-worth individuals seeking premium Bali property.</p>
                
                <h3>Prime Seminyak Locations</h3>
                <p><strong>Petitenget</strong> — The most exclusive Seminyak address, home to five-star resorts and beach clubs. <strong>Jalan Kayu Aya (Eat Street)</strong> — Central Seminyak with excellent dining and shopping at your doorstep. <strong>Batu Belig</strong> — The transitional area between Seminyak and Canggu, offering better value with proximity to both areas. <strong>Double Six</strong> — Beachfront and near-beach properties with spectacular sunset views.</p>

                <h3>Investment Outlook</h3>
                <p>Seminyak properties command the highest prices and rental rates in Bali. A well-located 3-bedroom villa can generate USD 3,000-8,000 monthly in rental income. Property values have shown consistent long-term appreciation, making Seminyak a reliable investment market.</p>

            @elseif($config['section_key'] === 'ubud-content')
                <h2>Property in Ubud — Bali's Cultural & Wellness Capital</h2>
                <p>Ubud offers a completely different property experience from Bali's coastal areas. Surrounded by lush rice terraces, tropical jungle, and ancient temples, Ubud attracts those seeking tranquility, spirituality, and connection with nature.</p>
                
                <h3>Ubud's Unique Appeal</h3>
                <p>As Bali's cultural and spiritual center, Ubud is home to yoga retreats, wellness centers, art galleries, and organic restaurants. The area's cooler climate, stunning natural scenery, and rich cultural heritage make it uniquely appealing for both living and investment.</p>

                <h3>Property Types in Ubud</h3>
                <p><strong>Rice field villas</strong> with panoramic views of working rice terraces. <strong>Jungle retreats</strong> nestled in tropical forest settings. <strong>Central Ubud properties</strong> close to the palace, market, and cultural attractions. <strong>River valley estates</strong> along the Ayung and Wos rivers. The Ubud property market offers options from simple bungalows to expansive luxury estates.</p>

                <h3>Why Choose Ubud?</h3>
                <p>Ubud properties offer excellent value compared to coastal areas. The wellness tourism boom has created strong demand for retreat-style accommodations. For those seeking a peaceful Bali lifestyle with cultural immersion, Ubud is unmatched.</p>
            @endif

        </div>
    </div>
</section>

<!-- Property Listing Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($properties->count() > 0)
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Available Properties</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($properties as $property)
                    <a href="{{ route('property.show', $property->property_number ?? $property->slug) }}" class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow block cursor-pointer">
                        <div class="relative bg-gray-200 group" style="aspect-ratio: 4 / 3;">
                            @php
                                $photos = $property->getMedia('photos');
                            @endphp
                            @if($photos->count() > 0)
                                @php
                                    $coverPhoto = $property->coverPhoto();
                                    $displayPhoto = $coverPhoto ?? $photos->first();
                                    $imageUrl = '/storage/' . $displayPhoto->id . '/' . $displayPhoto->file_name;
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $property->title }}" class="w-full h-full object-cover" loading="lazy">

                                <div class="absolute top-3 left-3 flex flex-wrap gap-1">
                                    @if($property->price_freehold && $property->price_freehold > 0)
                                        <span class="bg-[#96A480] text-white px-2 py-1 rounded text-xs font-semibold">FREEHOLD</span>
                                    @endif
                                    @if($property->price_leasehold && $property->price_leasehold > 0)
                                        <span class="bg-[#7A8A6A] text-white px-2 py-1 rounded text-xs font-semibold">LEASEHOLD</span>
                                    @endif
                                    @if($property->price_monthly && $property->price_monthly > 0)
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded text-xs font-semibold">RENT</span>
                                    @endif
                                </div>

                                @if($property->property_status === 'SOLD')
                                    <div class="absolute top-3 right-3 bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold">SOLD</div>
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ strtoupper($property->title) }}</h3>
                            <p class="text-sm text-gray-600 mb-3">
                                @if($property->area){{ strtoupper($property->area) }}@else BALI @endif
                                @if($property->bedroom)<span class="mx-2">|</span>{{ $property->bedroom }} bd@endif
                                @if($property->bathroom)<span class="mx-1">/</span>{{ $property->bathroom }} ba@endif
                                @if($property->land_size)<span class="mx-2">|</span>{{ $property->land_size }} m² land@endif
                            </p>
                            <div class="pt-3 border-t border-gray-200">
                                @php
                                    $displayPrice = $property->price_freehold ?? $property->price_leasehold 
                                        ?? $property->price_yearly ?? $property->price_monthly ?? null;
                                    $priceLabel = $property->price_freehold ? 'Freehold' : ($property->price_leasehold ? 'Leasehold' : 
                                        ($property->price_yearly ? '/year' : ($property->price_monthly ? '/month' : '')));
                                @endphp
                                @if($displayPrice)
                                    <p class="text-xl font-bold text-[#96A480]">
                                        IDR {{ number_format($displayPrice, 0, ',', '.') }}
                                        @if($priceLabel)<span class="text-sm font-normal text-gray-600">{{ $priceLabel }}</span>@endif
                                    </p>
                                @else
                                    <p class="text-xl font-bold text-[#96A480]">Price on Request</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No properties available at the moment</h3>
                <p class="text-gray-500">Check back soon or <a href="{{ route('contact-us') }}" class="text-[#96A480] underline">contact us</a> for new listings.</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-[#96A480]">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Looking for something specific?</h2>
        <p class="text-white text-lg mb-8 opacity-90">Our team can help you find the perfect property. Contact us for a personalized consultation.</p>
        <a href="{{ route('contact-us') }}" class="inline-block bg-white text-[#96A480] px-8 py-3 rounded font-semibold hover:bg-gray-100 transition-colors">
            Contact Us
        </a>
    </div>
</section>

<!-- Schema -->
@section('head_extra')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "{{ $config['h1'] }}",
    "description": "{{ $config['description'] }}",
    "url": "{{ $canonical }}",
    "mainEntity": {
        "@type": "ItemList",
        "numberOfItems": {{ $totalCount }}
    }
}
</script>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}"},
        {"@type": "ListItem", "position": 2, "name": "{{ $config['h1'] }}"}
    ]
}
</script>
@endsection
@endsection
