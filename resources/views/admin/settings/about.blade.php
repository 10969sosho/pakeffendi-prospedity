@extends('admin.layouts.app')

@section('title', 'Contact Us Settings')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-slate-900 mb-6">Contact Us CMS</h1>
        <p class="text-sm text-gray-600 mb-6">
            Atur konten utama untuk halaman Contact Us.
        </p>

        <form action="{{ route('admin.about-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                <div class="bg-[#96A480] px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Hero Section</h3>
                </div>
                <div class="p-6 grid grid-cols-1 gap-6">
                    <div>
                        <label for="hero_background" class="block text-sm font-medium text-gray-700 mb-2">
                            Hero Background Image
                        </label>
                        @if(optional($setting)->hero_background)
                            <img src="{{ asset('storage/' . $setting->hero_background) }}" alt="About Us Hero" class="h-40 object-cover bg-gray-100 p-2 rounded mb-3">
                        @endif
                        <input type="file" name="hero_background" id="hero_background" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#96A480] file:text-white hover:file:bg-[#7A8A6A] transition-colors">
                        <p class="mt-1 text-sm text-gray-500">Recommended: 1920x1080px (Landscape)</p>
                    </div>

                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Hero Title
                        </label>
                        <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', optional($setting)->hero_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent" placeholder="e.g. ABOUT US">
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                <div class="bg-[#96A480] px-6 py-4">
                    <h3 class="text-xl font-bold text-white">Content Section</h3>
                </div>
                <div class="p-6 grid grid-cols-1 gap-6">
                    <div>
                        <label for="page_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Page Title / Heading
                        </label>
                        <input type="text" name="page_title" id="page_title" value="{{ old('page_title', optional($setting)->page_title) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent" placeholder="e.g. Our Story">
                    </div>

                    <div>
                        <label for="page_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="page_description" id="page_description" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent" placeholder="Write the about us description here...">{{ old('page_description', optional($setting)->page_description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="submit" class="px-8 py-3 bg-[#96A480] text-white font-bold rounded-lg shadow hover:bg-[#7A8A6A] transition-colors duration-200">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Inquiry Categories Section -->
        <div class="mt-10 bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
            <div class="bg-[#96A480] px-6 py-4">
                <h3 class="text-xl font-bold text-white">Inquiry Categories</h3>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-4">Manage the categories available for inquiries.</p>
                
                <!-- List of categories -->
                @if($inquiryCategories->count() > 0)
                    <ul class="space-y-3 mb-6">
                        @foreach($inquiryCategories as $category)
                            <li class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <span class="text-gray-700 font-medium">{{ $category->name }}</span>
                                <form action="{{ route('admin.inquiry-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 italic mb-6">No categories added yet.</p>
                @endif

                <!-- Add new category form -->
                <form action="{{ route('admin.inquiry-categories.store') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-grow">
                        <label for="new_category" class="block text-sm font-medium text-gray-700 mb-1">Add New Category</label>
                        <input type="text" name="name" id="new_category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-transparent" placeholder="e.g. General Inquiry" required>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-[#96A480] text-white font-bold rounded-lg shadow hover:bg-[#7A8A6A] transition-colors duration-200 h-[42px]">
                        Add
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
