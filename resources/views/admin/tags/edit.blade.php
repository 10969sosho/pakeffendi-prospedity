@extends('admin.layouts.app')

@section('title', 'Edit Tag')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Edit Tag</h1>
        <a href="{{ route('admin.tags.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Tags
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tag Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $tag->name) }}" class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" placeholder="e.g. New, Featured, Best Deal" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">The slug will be automatically generated from the name.</p>
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#96A480] hover:bg-[#7A8A6A] text-white font-medium rounded-lg shadow transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Tag
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
