@extends('admin.layouts.app')

@section('title', 'Inquiry Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Inquiry Details</h1>
            <p class="mt-2 text-sm text-gray-600">View inquiry information</p>
        </div>
        <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-lg shadow hover:bg-gray-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Inquiry Details -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="bg-[#96A480] px-6 py-4">
            <h3 class="text-xl font-bold text-white">Inquiry Information</h3>
        </div>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Inquiry Number</label>
                    <div class="px-4 py-3 bg-[#E4E9DD] border-2 border-[#96A480] rounded-lg">
                        <span class="text-lg font-bold text-[#5B6A49]">{{ $inquiry->inquiry_number }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Property Number</label>
                    <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <span class="text-lg font-semibold text-gray-700">{{ $inquiry->property_number ?? '-' }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Subject</label>
                    <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <span class="text-lg font-semibold text-gray-700">{{ $inquiry->subject ?? '-' }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                    <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <span class="text-lg font-semibold text-gray-700">{{ $inquiry->name }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <a href="mailto:{{ $inquiry->email }}" class="text-lg font-semibold text-[#5B6A49] hover:underline">{{ $inquiry->email }}</a>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">WhatsApp Number</label>
                    <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->whatsapp) }}" target="_blank" class="text-lg font-semibold text-green-600 hover:underline">{{ $inquiry->whatsapp }}</a>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Date & Time</label>
                    <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg">
                        <div class="text-lg font-semibold text-gray-700">{{ $inquiry->created_at->format('d M Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $inquiry->created_at->format('H:i:s') }}</div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Note / Message</label>
                <div class="px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg min-h-[150px]">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $inquiry->note }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <div class="flex justify-end space-x-4">
            <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow transition-colors duration-200">
                    Delete Inquiry
                </button>
            </form>
        </div>
    </div>
</div>
@endsection


