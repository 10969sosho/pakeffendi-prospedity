@extends('admin.layouts.app')

@section('title', 'Sales Orders')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Sales Orders</h1>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SO Number</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WhatsApp</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PIC Number</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($salesOrders as $order)
                @php
                    $digits = preg_replace('/\D+/', '', (string) $order->whatsapp_number);
                    $waLink = $digits ? ('https://wa.me/' . $digits) : null;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-900 font-semibold">{{ $order->so_number }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order->customer_full_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order->company_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        <div class="flex items-center gap-2">
                            <span class="whitespace-nowrap">{{ $order->whatsapp_number }}</span>
                            <button type="button"
                                    class="px-2 py-1 text-xs font-semibold rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50"
                                    onclick="navigator.clipboard.writeText(@js($order->whatsapp_number))">
                                Copy
                            </button>
                            @if($waLink)
                                <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer"
                                   class="px-2 py-1 text-xs font-semibold rounded-md border border-[#96A480] text-[#5B6A49] hover:bg-[#96A480]/10">
                                    WA
                                </a>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order->email }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        @if($order->pic_number)
                            {{ $order->pic_number }}
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order->package_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-6 text-center text-sm text-gray-500">
                        Belum ada Sales Order masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(method_exists($salesOrders, 'links'))
    <div class="mt-6">
        {{ $salesOrders->links() }}
    </div>
@endif
@endsection
