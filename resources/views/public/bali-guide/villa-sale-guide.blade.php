@extends('public.layouts.app')

@section('title', 'Bali Villa Sale Guide | PROSPEDITY')

@section('content')
<!-- Hero Banner Section -->
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background) 
        ? asset('storage/' . $homeSetting->hero_background) 
        : null;
@endphp
<section class="relative h-96 bg-cover bg-center mt-[220px]" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 uppercase tracking-wide">
            BALI VILLA SALE GUIDE
        </h1>
        <p class="text-lg md:text-xl text-white max-w-4xl">
            BUY VILLA IN BALI: A COMPREHENSIVE GUIDE FOR INVESTORS
        </p>
    </div>
</section>

<!-- Main Content -->
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Property Ownership Types -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Property Ownership Types in Bali</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Hak Sewa/Leasehold -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-[#d4af37] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Hak Sewa / Leasehold</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Fixed-duration ownership for foreigners (up to 30 years, extendable). This is the most common property title for foreign investors in Bali, providing secure long-term rights to use the land and buildings.
                    </p>
                </div>

                <!-- Hak Milik/Freehold -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-[#d4af37] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Hak Milik / Freehold</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Permanent ownership exclusively for Indonesian citizens. This is the strongest form of property ownership in Indonesia, providing full and permanent rights to the land.
                    </p>
                </div>

                <!-- Hak Pakai -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-[#d4af37] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Hak Pakai</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Similar to Hak Sewa but involves conversion from Hak Milik, less common, and for private residence. This title is typically used for specific purposes and has more restrictions than leasehold.
                    </p>
                </div>

                <!-- Hak Guna Bangunan -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 bg-[#d4af37] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Hak Guna Bangunan</h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        Reserved for commercial purposes, converted from Hak Milik, for Indonesian or foreign-owned companies (valid up to 70 years). This is used for business and commercial property development.
                    </p>
                </div>
            </div>
        </div>

        <!-- Property Title Requirements Table -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Property Title Requirements</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead class="bg-[#162138] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold uppercase">Document Type</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Hak Sewa</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Hak Milik</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Hak Guna Bangunan</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold uppercase">Hak Pakai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Passport</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">ID Card</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">PT PMA</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">KITAS</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">BPNS Form</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Foreigner Indonesian Citizen</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">Only allowed for Indonesian citizen</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">✓</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">X</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Buying/Leasing Process -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Buying/Leasing Process in Bali</h2>
            
            <!-- Leasehold Process -->
            <div class="mb-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Leasehold / Hak Sewa Process</h3>
                <div class="flex flex-wrap gap-4 justify-center">
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">1</div>
                        <div class="text-sm font-semibold">Agree with the price & Condition</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">2</div>
                        <div class="text-sm font-semibold">Sign MOU & Pay Deposit</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">3</div>
                        <div class="text-sm font-semibold">Due Diligence Process</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">4</div>
                        <div class="text-sm font-semibold">Prepare Lease Agreement</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">5</div>
                        <div class="text-sm font-semibold">Sign Lease Agreement & Pay Balance</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">6</div>
                        <div class="text-sm font-semibold">Finalize lease and taxes payment as per the agreement</div>
                    </div>
                </div>
            </div>

            <!-- Freehold Process -->
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Freehold / Hak Milik / HGB / Hak Pakai Process</h3>
                <div class="flex flex-wrap gap-4 justify-center">
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">1</div>
                        <div class="text-sm font-semibold">Agree with the price</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">2</div>
                        <div class="text-sm font-semibold">Sign MOU & Pay Deposit</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">3</div>
                        <div class="text-sm font-semibold">Due Diligence Process</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">4</div>
                        <div class="text-sm font-semibold">Prepare Sale & Purchase Agreement</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">5</div>
                        <div class="text-sm font-semibold">Sign SPA & Pay Balance</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">6</div>
                        <div class="text-sm font-semibold">Pay Taxes (BPHTB & PPh)</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">7</div>
                        <div class="text-sm font-semibold">Land Office Registration</div>
                    </div>
                    <div class="bg-[#d4af37] text-white px-6 py-4 rounded-lg text-center min-w-[200px]">
                        <div class="text-2xl font-bold mb-2">8</div>
                        <div class="text-sm font-semibold">Title Deed Transfer</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Important Notes -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Important Notes:</h3>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Limitation on land purchase: one plot per name, max 2,000 m²</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Buildings on leased land can be used for residential purposes only</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>All property transactions must be conducted through a notary and registered at the Land Office</span>
                </li>
            </ul>
        </div>

    </div>
</section>
@endsection






