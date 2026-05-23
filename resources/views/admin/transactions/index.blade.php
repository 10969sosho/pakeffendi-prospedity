@extends('admin.layouts.app')

@section('title', 'Property Transactions')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Transactions</h1>
            <p class="mt-2 text-sm text-gray-600">Manage property transactions and validity</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('admin.transactions.index') }}">
            <div class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Transaction Number..." class="flex-1 px-4 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors">
                <button type="submit" class="px-6 py-2 bg-[#96A480] text-white rounded-lg hover:bg-[#7A8A6A] transition-colors">Search</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Properties Count</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expiry Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($transactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->transaction_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->property_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction->expired_date ? \Carbon\Carbon::parse($transaction->expired_date)->format('d M Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->expired_date && \Carbon\Carbon::parse($transaction->expired_date)->isPast())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('admin.transactions.extend') }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="hidden" name="transaction_number" value="{{ $transaction->transaction_number }}">
                                <input type="number" name="validity_days" placeholder="Days" class="w-20 px-2 py-1 border border-gray-300 rounded text-sm" required min="1">
                                <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-bold">Extend</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
