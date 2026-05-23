@extends('admin.layouts.app')

@section('title', 'Home Settings')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Home Page CMS</h1>
        <p class="text-sm text-gray-600 mb-6">
            Atur judul, deskripsi, dan background untuk section utama di halaman Home
            (bagian <strong>Latest Villas, Apartments &amp; Houses Listed</strong>).
        </p>

        <form action="{{ route('admin.home-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <div class="space-y-8">
                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                    <div class="bg-[#96A480] px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Branding</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            @if(optional($setting)->hero_logo)
                                <img src="{{ asset('storage/' . $setting->hero_logo) }}" alt="Hero Logo" class="h-20 object-contain bg-gray-100 p-2 rounded mb-3">
                            @endif
                            <input type="file" id="hero_logo" name="hero_logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#96A480] file:text-white hover:file:bg-[#7A8A6A]">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Max: 2MB.</p>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label for="navbar_title" class="block text-sm font-medium text-gray-700 mb-1">Navbar Title</label>
                                <input type="text" id="navbar_title" name="navbar_title" value="{{ old('navbar_title', optional($setting)->navbar_title) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="PROSPEDITY">
                            </div>
                            <div>
                                <label for="navbar_description" class="block text-sm font-medium text-gray-700 mb-1">Navbar Description</label>
                                <textarea id="navbar_description" name="navbar_description" rows="2" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="Prospedity Digital Properties">{{ old('navbar_description', optional($setting)->navbar_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                    <div class="bg-[#96A480] px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Hero Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', optional($setting)->hero_title) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="LATEST VILLAS, APARTMENTS &amp; HOUSES LISTED">
                                <p class="mt-1 text-xs text-gray-500">Judul besar di bagian atas.</p>
                            </div>
                            <div>
                                <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="hero_subtitle" name="hero_subtitle" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="Tulis deskripsi singkat">{{ old('hero_subtitle', optional($setting)->hero_subtitle) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Support line break.</p>
                            </div>
                        </div>
                        <div>
                            @if(optional($setting)->hero_background)
                                <img src="{{ asset('storage/' . $setting->hero_background) }}" alt="Current home hero background" class="w-full max-h-64 object-cover rounded-md border border-gray-200 mb-3">
                            @endif
                            <input type="file" id="hero_background" name="hero_background" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none focus:border-[#96A480]">
                            <p class="mt-1 text-xs text-gray-500">Optimal: 1920×1080 (16:9) atau 2560×1080 (21:9). Max 4MB.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                    <div class="bg-[#96A480] px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Contact Page Settings</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="contact_title" class="block text-sm font-medium text-gray-700 mb-1">Contact Page Title</label>
                            <input type="text" id="contact_title" name="contact_title" value="{{ old('contact_title', optional($setting)->contact_title) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="Prospedity Digital Properties">
                            <p class="mt-1 text-xs text-gray-500">Judul yang muncul sebelum form kontak.</p>
                        </div>
                        <div>
                            <label for="contact_description" class="block text-sm font-medium text-gray-700 mb-1">Contact Page Description</label>
                            <textarea id="contact_description" name="contact_description" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="Tulis deskripsi...">{{ old('contact_description', optional($setting)->contact_description) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Deskripsi yang muncul sebelum form kontak.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                    <div class="bg-[#96A480] px-6 py-4">
                        <h3 class="text-xl font-bold text-white">Social & Contact</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                            <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', optional($setting)->facebook_url) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="https://facebook.com/...">
                        </div>
                        <div>
                            <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                            <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', optional($setting)->instagram_url) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="https://instagram.com/...">
                        </div>
                        <div>
                            <label for="tiktok_url" class="block text-sm font-medium text-gray-700 mb-1">TikTok URL</label>
                            <input type="url" id="tiktok_url" name="tiktok_url" value="{{ old('tiktok_url', optional($setting)->tiktok_url) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="https://tiktok.com/...">
                        </div>
                        <div>
                            <label for="whatsapp_url" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
                            <input type="text" id="whatsapp_url" name="whatsapp_url" value="{{ old('whatsapp_url', optional($setting)->whatsapp_url) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="+62...">
                            <p class="mt-1 text-xs text-gray-500">Nomor untuk tombol chat.</p>
                        </div>
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', optional($setting)->email) }}" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480]" placeholder="info@baliproperties.com">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end pt-6 border-t border-gray-200">
                    <button type="submit" class="px-8 py-3 bg-[#96A480] text-white font-bold rounded-lg shadow hover:bg-[#7A8A6A] transition-colors duration-200">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
