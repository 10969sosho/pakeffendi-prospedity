@extends('public.layouts.app')

@section('title', 'Contact Us - Prospedity Digital Properties Bali')

@section('meta_description', 'Get in touch with Prospedity for inquiries about luxury properties in Bali. Contact our expert advisors for villas, investments, and property consultation.')

@section('content')
<!-- Hero Section -->
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background) 
        ? asset('storage/' . $homeSetting->hero_background) 
        : null;
@endphp
<section class="relative h-96 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 uppercase tracking-wide">
            ABOUT US
        </h1>
        <p class="text-base md:text-lg text-white max-w-4xl">
            Get in touch with us for any inquiries about our properties
        </p>
    </div>
</section>

<!-- Contact Form Section -->
<section class="py-12 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject *</label>
                    <select name="subject" id="subject" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                        <option value="" @selected(old('subject') === null || old('subject') === '')>Pilih Subject</option>
                        <option value="tanya properti" @selected(old('subject') === 'tanya properti')>Tanya Properti</option>
                        <option value="tanya harga" @selected(old('subject') === 'tanya harga')>Tanya Harga</option>
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
</section>

<script>
function handleContactSubmit(event) {
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const whatsapp = document.getElementById('whatsapp').value;
    const propertyNumber = document.getElementById('property_number').value;
    const note = document.getElementById('note').value;

    // Construct email body
    const subject = `Inquiry from Website - ${name}`;
    const body = `Name: ${name}
Email: ${email}
WhatsApp: ${whatsapp}
Property Number: ${propertyNumber || '-'}

Message:
${note}`;

    // Prospedity email
    const toEmail = "{{ $homeSetting->email ?? 'info@prospedity.com' }}";
    
    // Create mailto link
    const mailtoLink = `mailto:${toEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    
    // Open email client
    window.location.href = mailtoLink;
    
    // Form will continue to submit to server (saving to database)
}
</script>
@endsection
