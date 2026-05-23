@extends('public.layouts.app')

@section('title', 'Konfirmasi Pembelian - PROSPEDITY')

@section('content')
@php
    $formatPrice = function ($value) {
        return 'Rp ' . number_format((float) $value, 0, ',', '.');
    };

    $bankName = $activeBankAccount?->bank_name ?? config('payment.bank_name');
    $bankAccountNumber = $activeBankAccount?->account_number ?? config('payment.bank_account_number');
    $bankAccountName = $activeBankAccount?->account_name ?? config('payment.bank_account_name');

    $adminWhatsappNumber = $homeSetting?->whatsapp_url;
    $adminWhatsappLink = $adminWhatsappNumber ? ('https://wa.me/' . preg_replace('/\D+/', '', $adminWhatsappNumber)) : null;
@endphp

<section class="relative h-72 bg-cover bg-center mt-[220px]" style="background-color: #96A480;">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white uppercase tracking-wide">Konfirmasi</h1>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-8">
                <div class="mb-6">
                    <div class="text-sm text-gray-500">Nomor Sales Order (SO)</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900">{{ $salesOrder->so_number }}</div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <div class="text-sm text-gray-500">Paket</div>
                        <div class="mt-1 text-lg font-semibold text-gray-900">{{ $salesOrder->package_name }}</div>
                        <div class="mt-4 text-sm text-gray-500">Total</div>
                        <div class="mt-1 text-xl font-bold text-gray-900">{{ $formatPrice($salesOrder->final_price) }}</div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-5 border border-gray-200">
                        <div class="text-sm text-gray-500">Data Pembeli</div>
                        <div class="mt-2 text-sm text-gray-800">
                            <div class="font-semibold">{{ $salesOrder->customer_full_name }}</div>
                            <div>{{ $salesOrder->company_name }}</div>
                            <div>{{ $salesOrder->whatsapp_number }}</div>
                            <div>{{ $salesOrder->email }}</div>
                            @if($salesOrder->pic_number)
                                <div class="mt-2 text-xs text-gray-600">PIC Number: {{ $salesOrder->pic_number }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Instruksi Pembayaran</h2>

                    <div class="text-sm text-gray-700 leading-relaxed space-y-2">
                        <div>Silakan lakukan transfer ke rekening berikut:</div>
                        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="text-xs text-gray-500">Bank</div>
                                <div class="mt-1 font-semibold text-gray-900">{{ $bankName }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="text-xs text-gray-500">No. Rekening</div>
                                <div class="mt-1 font-semibold text-gray-900">{{ $bankAccountNumber }}</div>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="text-xs text-gray-500">Atas Nama</div>
                                <div class="mt-1 font-semibold text-gray-900">{{ $bankAccountName }}</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            Berita transfer wajib diisi: <span class="font-semibold">{{ $salesOrder->so_number }}</span>
                        </div>

                        <div class="mt-2">
                            Setelah transfer, kirim bukti transfer ke WhatsApp admin.
                            @if($adminWhatsappLink)
                                <a href="{{ $adminWhatsappLink }}" target="_blank" rel="noopener noreferrer" class="text-[#5B6A49] hover:underline font-semibold">
                                    Hubungi Admin via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('our-services.order.invoice', $salesOrder) }}"
                       class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-[#96A480] hover:bg-[#7A8A6A] text-white font-semibold transition-colors">
                        Unduh Invoice (PDF)
                    </a>
                    <a href="{{ route('our-services') }}"
                       class="inline-flex items-center justify-center px-5 py-3 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold">
                        Kembali ke Pricelist
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
