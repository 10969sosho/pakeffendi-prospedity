@extends('admin.layouts.app')

@section('title', 'Edit PIC Profile')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Edit PIC Profile</h1>
        <p class="mt-2 text-sm text-gray-600">Update PIC profile details</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('admin.pic-profiles.update', $picProfile->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Reference Number -->
            <div>
                <label for="ref_number" class="block text-sm font-bold text-gray-700 mb-2">Reference Number</label>
                <input type="text" name="ref_number" id="ref_number" value="{{ old('ref_number', $picProfile->ref_number) }}" required 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                    placeholder="e.g. PIC-001">
                @error('ref_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $picProfile->name) }}" required 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                    placeholder="e.g. John Doe">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email (Optional)</label>
                <input type="email" name="email" id="email" value="{{ old('email', $picProfile->email) }}" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                    placeholder="e.g. john@example.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- WhatsApp Number -->
            <div>
                <label for="whatsapp_number" class="block text-sm font-bold text-gray-700 mb-2">WhatsApp Number (Optional)</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $picProfile->whatsapp_number) }}" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors"
                    placeholder="e.g. +628123456789">
                @error('whatsapp_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.pic-profiles.index') }}" class="px-6 py-3 text-sm font-medium text-gray-700 bg-white border-2 border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-[#96A480] hover:bg-[#7A8A6A] rounded-lg shadow transition-colors">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
