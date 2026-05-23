<?php

namespace Database\Seeders;

use App\Models\AdvisorGuide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AdvisorGuideSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Panduan Awal Investasi Properti di Bali (2026)',
                'content' => "Bali tetap jadi magnet investasi, tapi strategi yang dipakai harus menyesuaikan profil risiko dan tujuan Anda.\n\nLangkah awal yang paling aman: tentukan tipe aset (villa, landbank, apartemen), horizon waktu (1–3 tahun / 3–7 tahun / 7+ tahun), dan target yield.\n\nPastikan juga dari awal Anda pisahkan kebutuhan: properti untuk dipakai sendiri, disewakan harian, atau disewakan jangka panjang.\n\nDi artikel ini kami rangkum checklist cepat yang biasa dipakai advisor untuk menilai peluang, termasuk dokumen, legalitas, dan simulasi biaya operasional.",
                'reference_urls' => [
                    'https://www.investopedia.com/terms/r/returnoninvestment.asp',
                    'https://www.investopedia.com/terms/c/caprate.asp',
                ],
                'published_at' => Carbon::now()->subDays(2),
                'is_active' => true,
            ],
            [
                'title' => 'Checklist Legalitas: Freehold vs Leasehold',
                'content' => "Banyak calon investor fokus ke lokasi dan harga, tapi lupa bahwa struktur legal itu menentukan keamanan dan exit strategy.\n\nSecara sederhana, freehold memberi kontrol jangka panjang, sedangkan leasehold lebih umum untuk strategi yield dengan periode tertentu.\n\nYang penting bukan hanya istilahnya, tapi detail kontrak: periode, opsi perpanjangan, hak bangun, siapa pemegang sertifikat, dan klausul pengalihan.\n\nDi sini kami buat checklist poin-poin legal yang wajib dicek sebelum DP atau tanda tangan.",
                'reference_urls' => [
                    'https://en.wikipedia.org/wiki/Leasehold_estate',
                    'https://en.wikipedia.org/wiki/Freehold_(law)',
                    'https://www.investopedia.com/terms/t/title-search.asp',
                ],
                'published_at' => Carbon::now()->subDays(5),
                'is_active' => true,
            ],
            [
                'title' => 'Cara Menghitung Biaya Operasional Villa untuk Rental',
                'content' => "Perhitungan yield yang akurat tidak bisa hanya pakai harga beli dan proyeksi okupansi.\n\nDi lapangan, biaya operasional villa biasanya meliputi: staff, maintenance berkala, utilitas, marketing/OTA fee, pajak, dan sinking fund.\n\nSaran kami: hitung 3 skenario (conservative / base / optimistic) dan gunakan asumsi okupansi yang realistis sesuai area.\n\nArtikel ini memberikan template sederhana untuk menghitung net income agar Anda bisa membandingkan beberapa opsi properti secara fair.",
                'reference_urls' => [
                    'https://www.investopedia.com/terms/n/netincome.asp',
                    'https://www.investopedia.com/terms/o/operating-expense.asp',
                ],
                'published_at' => Carbon::now()->subDays(8),
                'is_active' => true,
            ],
            [
                'title' => 'Strategi Location Picking: Area yang Cocok untuk Growth vs Cashflow',
                'content' => "Tidak semua lokasi cocok untuk semua strategi.\n\nArea yang sedang berkembang biasanya menarik untuk growth (capital gain), tapi cashflow bisa belum stabil.\n\nSebaliknya, area yang sudah matang cenderung memberi cashflow lebih konsisten, namun growth tidak selalu setinggi area emerging.\n\nDi artikel ini kami jelaskan cara memilih lokasi berdasarkan data sederhana: demand, supply pipeline, akses, dan segment wisata/ekspat.",
                'reference_urls' => [
                    'https://www.investopedia.com/terms/s/supply.asp',
                    'https://www.investopedia.com/terms/d/demand.asp',
                ],
                'published_at' => Carbon::now()->subDays(12),
                'is_active' => true,
            ],
            [
                'title' => 'Tips Negosiasi Deal Properti: Dari Offer sampai Closing',
                'content' => "Negosiasi yang efektif bukan sekadar minta diskon.\n\nKuncinya adalah memahami motivasi seller, kondisi pasar, dan leverage yang Anda miliki (cash buyer, timeline cepat, atau fleksibilitas term).\n\nSiapkan juga list item yang bisa dinegosiasikan selain harga: furnitur, jadwal pembayaran, perbaikan minor, hingga penalti jika serah-terima terlambat.\n\nDi artikel ini kami rangkum langkah negosiasi yang rapi agar proses closing lebih aman dan minim drama.",
                'reference_urls' => [
                    'https://www.investopedia.com/articles/personal-finance/110615/real-estate-negotiation-tips-buyers-and-sellers.asp',
                    'https://www.investopedia.com/terms/d/due-diligence.asp',
                ],
                'published_at' => Carbon::now()->subDays(15),
                'is_active' => true,
            ],
        ];

        foreach ($items as $item) {
            $referenceUrls = $item['reference_urls'] ?? [];
            $item['reference_url'] = $referenceUrls[0] ?? null;

            AdvisorGuide::updateOrCreate(
                ['title' => $item['title']],
                $item
            );
        }
    }
}
