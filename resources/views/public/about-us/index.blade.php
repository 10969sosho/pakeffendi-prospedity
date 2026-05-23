@extends('public.layouts.app')

@php
    $isAboutPage = request()->routeIs('about-us');
@endphp

@section('title', $isAboutPage
    ? (($aboutSetting && $aboutSetting->page_title) ? $aboutSetting->page_title : 'About Us - PROSPEDITY')
    : 'Our Services - PROSPEDITY'
)

@section('content')
<!-- Hero Section -->
@php
    if ($isAboutPage) {
        $heroBackground = ($aboutSetting && $aboutSetting->hero_background)
            ? asset('storage/' . $aboutSetting->hero_background)
            : null;

        $heroTitle = ($aboutSetting && $aboutSetting->hero_title)
            ? $aboutSetting->hero_title
            : 'ABOUT US';

        $heroDesc = ($aboutSetting && $aboutSetting->page_description)
            ? $aboutSetting->page_description
            : null;
    } else {
        $heroBackground = ($homeSetting && $homeSetting->hero_background)
            ? asset('storage/' . $homeSetting->hero_background)
            : null;
        $heroTitle = 'OUR SERVICES';
        $heroDesc = null;
    }
@endphp
<section class="relative h-96 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">{{ $heroTitle }}</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($heroDesc)
            <div class="mb-8">
                <p class="text-lg text-gray-700 leading-relaxed">
                    {!! nl2br(e($heroDesc)) !!}
                </p>
            </div>
        @endif

        @if($isAboutPage)
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Send Us a Message</h2>

                    <form action="{{ route('contact-us.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">Nomor WA *</label>
                                <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}" required
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                                       placeholder="+62xxxxxxxxxxx">
                                @error('whatsapp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="property_number" class="block text-sm font-medium text-gray-700 mb-2">Property Number</label>
                                <input type="text" name="property_number" id="property_number" value="{{ old('property_number') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                                       placeholder="Optional">
                                @error('property_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Inquiry Categories *</label>
                            <select name="subject" id="subject" required
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                                <option value="" @selected(old('subject') === null || old('subject') === '')>Pilih Inquiry Categories</option>
                                @foreach($inquiryCategories as $category)
                                    <option value="{{ $category->name }}" @selected(old('subject') === $category->name)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-2">Note *</label>
                            <textarea name="note" id="note" rows="6" required
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">{{ old('note') }}</textarea>
                            @error('note')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="bg-[#96A480] hover:bg-[#7A8A6A] text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                                Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if(!$isAboutPage)
            <div class="space-y-6">
                @forelse($services as $service)
                    <article class="bg-white rounded-lg shadow-md border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                    {{ $service->title }}
                                </h2>
                            </div>
                            @if($service->reference_url)
                                <div class="md:text-right">
                                    <a href="{{ $service->reference_url }}" target="_blank" rel="noopener noreferrer"
                                       class="inline-flex items-center px-4 py-2 rounded-md bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-medium transition-colors">
                                        View Reference
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10v11h11"></path>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if($service->content)
                            <div class="mt-4 text-gray-700 text-sm leading-relaxed">
                                {!! nl2br(\Illuminate\Support\Str::limit($service->content, 400)) !!}
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">
                            Services information is currently being updated.
                        </p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</section>
@endsection
