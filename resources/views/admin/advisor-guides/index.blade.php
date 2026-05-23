@extends('admin.layouts.app')

@section('title', 'Advisor Guide Posts')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Advisor Guide Posts</h1>
    <a href="{{ route('admin.advisor-guides.create') }}"
       class="inline-flex items-center px-4 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-semibold rounded-md shadow-sm">
        + New Post
    </a>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published At</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference URL</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($guides as $guide)
                <tr>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        {{ $guide->title }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @if($guide->published_at)
                            {{ $guide->published_at->format('d M Y') }}
                        @else
                            <span class="text-xs text-gray-400">Not set</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if($guide->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-[#5B6A49] max-w-xs truncate">
                        @if($guide->reference_url)
                            <a href="{{ $guide->reference_url }}" target="_blank" rel="noopener noreferrer" class="hover:underline">
                                {{ $guide->reference_url }}
                            </a>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-right space-x-2">
                        <a href="{{ route('admin.advisor-guides.edit', $guide) }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Edit
                        </a>
                        <form action="{{ route('admin.advisor-guides.destroy', $guide) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-red-300 text-red-700 hover:bg-red-50">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                        Belum ada posting Advisor Guide. Klik "New Post" untuk menambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($guides->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
            {{ $guides->links() }}
        </div>
    @endif
</div>
@endsection


