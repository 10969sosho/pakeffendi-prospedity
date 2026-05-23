@extends('admin.layouts.app')

@section('title', 'Our Services')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Our Services</h1>
    <a href="{{ route('admin.our-services.create') }}"
       class="inline-flex items-center px-4 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-semibold rounded-md shadow-sm">
        + New Service
    </a>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="w-10 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference URL</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="sortable-list">
            @forelse($services as $index => $service)
                <tr data-id="{{ $service->id }}" class="cursor-move hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-center text-gray-400">
                        <div class="flex items-center justify-center">
                            <span class="mr-2 order-number">{{ $index + 1 }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        {{ $service->title }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if($service->is_active)
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
                        @if($service->reference_url)
                            <a href="{{ $service->reference_url }}" target="_blank" rel="noopener noreferrer" class="hover:underline">
                                {{ $service->reference_url }}
                            </a>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-right space-x-2">
                        <a href="{{ route('admin.our-services.edit', $service) }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Edit
                        </a>
                        <form action="{{ route('admin.our-services.destroy', $service) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus service ini?');">
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
                        Belum ada service. Klik "New Service" untuk menambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    var el = document.getElementById('sortable-list');
    var sortable = Sortable.create(el, {
        animation: 150,
        onEnd: function (evt) {
            var order = [];
            document.querySelectorAll('#sortable-list tr').forEach(function(row, index) {
                order.push(row.getAttribute('data-id'));
                row.querySelector('.order-number').textContent = index + 1;
            });

            fetch('{{ route("admin.our-services.update-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ order: order })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    console.log('Order updated');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endpush
@endsection
