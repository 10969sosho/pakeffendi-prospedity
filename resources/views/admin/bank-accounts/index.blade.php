@extends('admin.layouts.app')

@section('title', 'Nomor Rekening')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-900">Nomor Rekening</h1>
    <a href="{{ route('admin.bank-accounts.create') }}"
       class="inline-flex items-center px-4 py-2 bg-[#96A480] hover:bg-[#7A8A6A] text-white text-sm font-semibold rounded-md shadow-sm">
        + Tambah Rekening
    </a>
</div>

<div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Rekening</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Atas Nama</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($bankAccounts as $bankAccount)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $bankAccount->bank_name }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $bankAccount->account_number }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $bankAccount->account_name }}</td>
                    <td class="px-4 py-3 text-sm">
                        @if($bankAccount->is_active)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">Inactive</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-right space-x-2">
                        @if(!$bankAccount->is_active)
                            <form action="{{ route('admin.bank-accounts.activate', $bankAccount) }}" method="POST" class="inline-block">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-[#96A480] text-[#5B6A49] hover:bg-[#E4E9DD]">
                                    Aktifkan
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.bank-accounts.edit', $bankAccount) }}"
                           class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">
                            Edit
                        </a>
                        <form action="{{ route('admin.bank-accounts.destroy', $bankAccount) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('Yakin ingin menghapus rekening ini?');">
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
                        Belum ada nomor rekening. Klik "Tambah Rekening" untuk menambahkan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
