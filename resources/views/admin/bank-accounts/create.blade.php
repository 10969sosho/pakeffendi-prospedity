@extends('admin.layouts.app')

@section('title', 'Tambah Nomor Rekening')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.bank-accounts.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="bank_name" class="block text-sm font-semibold text-gray-700 mb-2">Bank</label>
                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" required>
            </div>

            <div>
                <label for="account_number" class="block text-sm font-semibold text-gray-700 mb-2">No. Rekening</label>
                <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" required>
            </div>

            <div>
                <label for="account_name" class="block text-sm font-semibold text-gray-700 mb-2">Atas Nama</label>
                <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}"
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-[#96A480] focus:border-[#96A480] transition-colors" required>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.bank-accounts.index') }}"
                   class="inline-flex items-center px-5 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center px-5 py-3 rounded-lg bg-[#96A480] hover:bg-[#7A8A6A] text-white font-semibold transition-colors">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
