@extends('public.layouts.app')

@php
    use Illuminate\Support\Str;
    $guideTitle = $title ?? ($guide->title . ' - Prospedity');
    $guideDesc = $guide && $guide->content ? Str::limit(strip_tags($guide->content), 160) : 'Expert advisor guide from Prospedity about Bali real estate.';
    $guideCanonical = $guide ? url('/advisor-guide/' . $guide->id) : url('/advisor-guide');
@endphp

@section('title', $guideTitle)

@section('meta_description', $guideDesc)

@section('content')
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background)
        ? asset('storage/' . $homeSetting->hero_background)
        : null;

    $referenceUrls = $guide->reference_urls ?: [];
    if (empty($referenceUrls) && $guide->reference_url) {
        $referenceUrls = [$guide->reference_url];
    }
@endphp

<section class="relative h-72 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-3xl md:text-5xl font-bold text-white uppercase tracking-wide text-center px-6">
            ADVISOR GUIDE
        </h1>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('advisor-guide') }}" class="inline-flex items-center text-sm text-[#96A480] hover:text-[#7A8A6A] mb-6">
            &larr; Kembali ke Advisor Guide
        </a>

        <article class="bg-white rounded-lg shadow-md border border-gray-100 p-8">
            <h2 class="text-2xl md:text-3xl font-semibold text-gray-900">
                {{ $guide->title }}
            </h2>

            @if($guide->published_at)
                <p class="text-sm text-gray-500 mt-2">
                    Published on {{ $guide->published_at->format('d M Y') }}
                </p>
            @endif

            @if($guide->content)
                <div class="mt-6 text-gray-700 leading-relaxed whitespace-normal">
                    {!! nl2br(e($guide->content)) !!}
                </div>
            @endif

            @if(!empty($referenceUrls))
                <div class="mt-10 pt-6 border-t border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 mb-3">
                        Link Referensi
                    </h3>
                    <div class="space-y-2">
                        @foreach($referenceUrls as $url)
                            <div>
                                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-[#5B6A49] hover:underline break-all">
                                    {{ $url }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </article>
    </div>
</section>
@endsection

