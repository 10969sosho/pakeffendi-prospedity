@extends('admin.layouts.app')

@section('title', 'New Service')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.our-services.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to List
    </a>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 p-6">
    <h1 class="text-2xl font-bold text-slate-900 mb-6">New Service</h1>

    <form action="{{ route('admin.our-services.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reference URL -->
            <div>
                <label for="reference_url" class="block text-sm font-medium text-gray-700 mb-1">Reference URL (Optional)</label>
                <input type="url" name="reference_url" id="reference_url" value="{{ old('reference_url') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                @error('reference_url')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-[#96A480] shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">
                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea name="content" id="content" rows="10"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#96A480] focus:ring focus:ring-[#96A480] focus:ring-opacity-50">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end pt-6 border-t border-gray-100">
                <button type="submit" class="bg-[#96A480] text-white px-6 py-2 rounded-lg hover:bg-[#7A8A6A] transition-colors font-semibold shadow-sm">
                    Create Service
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endpush
@endsection
