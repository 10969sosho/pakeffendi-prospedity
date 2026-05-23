@php
    $hasBannerImage = isset($homeSetting) && $homeSetting && $homeSetting->hero_background;
    $bannerImage = $hasBannerImage ? asset('storage/' . $homeSetting->hero_background) : null;

    $defaultHeroTitle = 'LATEST VILLAS, APARTMENTS & HOUSES LISTED';
    $defaultHeroSubtitle = '<strong>Prospedity Digital Properties</strong> is your trusted partner for property investment in Bali. With years of experience in the real estate market, we offer a comprehensive selection of premium properties including villas, apartments, and houses. Our team of experts is dedicated to helping you find the perfect property that meets your needs and investment goals. Whether you\'re looking for a vacation home, rental property, or long-term investment, we have the expertise and portfolio to guide you through every step of your property journey in Bali.';
@endphp

<section id="home-guest-banner" class="bg-white pt-16 md:pt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
        <div class="relative group w-full max-w-5xl mx-auto rounded-3xl border border-dashed border-gray-500/60 overflow-hidden bg-black/40">
            @if($bannerImage)
                <img src="{{ $bannerImage }}" alt="Banner" class="w-full h-[260px] sm:h-[340px] md:h-[420px] object-cover transition-transform duration-700 ease-out group-hover:scale-[1.03]" loading="lazy">
            @else
                <div class="w-full h-[260px] sm:h-[340px] md:h-[420px] bg-gradient-to-br from-[#1F2A1F] via-[#2A3A2A] to-[#96A480]"></div>
            @endif
        </div>
    </div>
</section>

<section id="home-guest-intro" class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        <div class="max-w-4xl mx-auto text-center">
            <p class="text-[#96A480] text-xs sm:text-sm tracking-[0.25em] uppercase font-semibold">Prospedity Digital Properties</p>
            <h1 class="mt-4 text-2xl sm:text-3xl md:text-4xl font-bold leading-tight text-gray-900">
                {{ $homeSetting && $homeSetting->hero_title ? $homeSetting->hero_title : $defaultHeroTitle }}
            </h1>
            <div class="mt-5 text-base sm:text-lg leading-relaxed text-gray-700">
                {!! $homeSetting && $homeSetting->hero_subtitle
                    ? nl2br(e($homeSetting->hero_subtitle))
                    : $defaultHeroSubtitle !!}
            </div>

            <div class="mt-7 flex flex-col sm:flex-row gap-3 sm:items-center justify-center">
                <a href="#search-properties" class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-[#96A480] text-white font-semibold tracking-wide transition-all duration-300 hover:bg-[#7A8C65] hover:shadow-[0_10px_25px_rgba(0,0,0,0.12)]">
                    Browse Properties
                </a>
                @php
                    $advisorHref = ($homeSetting && $homeSetting->whatsapp_url)
                        ? ('https://wa.me/' . preg_replace('/[^0-9]/', '', $homeSetting->whatsapp_url))
                        : route('contact-us');
                @endphp
                <a href="{{ $advisorHref }}" @if($homeSetting && $homeSetting->whatsapp_url) target="_blank" rel="noopener noreferrer" @endif class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-gray-900 text-white font-semibold tracking-wide transition-all duration-300 hover:bg-gray-800 hover:shadow-[0_10px_25px_rgba(0,0,0,0.12)]">
                    Talk to Our Advisor
                </a>
            </div>
        </div>
    </div>
</section>
