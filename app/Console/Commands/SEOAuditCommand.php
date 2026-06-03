<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\PropertyType;
use App\Models\AdvisorGuide;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SEOAuditCommand extends Command
{
    protected $signature = 'seo:audit';
    protected $description = 'Comprehensive SEO Audit for PROSPEDITY';

    public function handle()
    {
        $this->info(str_repeat('=', 80));
        $this->info('       PROSPEDITY SEO AUDIT REPORT');
        $this->info(str_repeat('=', 80));

        $this->runPriority5(); // Index Coverage
        $this->runPriority3(); // Thin Content
        $this->runPriority2(); // Property Quality Audit (20 terbaru)
        $this->runPriority4(); // Internal Link Audit
        $this->outputSummary();
    }

    // ================================================================
    // PRIORITY 5: Audit Index Coverage
    // ================================================================
    private function runPriority5()
    {
        $this->line('');
        $this->line(str_repeat('-', 80));
        $this->info('PRIORITY 5: AUDIT INDEX COVERAGE');
        $this->line(str_repeat('-', 80));

        // Total semua properties
        $totalAll = Property::count();

        // Properties "aktif" (bisa muncul di public)
        $activeQuery = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('expired_date')
                    ->orWhere('expired_date', '>=', now()->toDateString());
            })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->where(function ($q) {
                $q->whereHas('media', function ($mq) {
                    $mq->where('collection_name', 'photos');
                });
            });
        $totalActive = $activeQuery->count();

        // Properties tanpa foto
        $noPhotos = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })->whereDoesntHave('media', function ($q) {
            $q->where('collection_name', 'photos');
        })->count();

        // Properties tanpa deskripsi
        $noDesc = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('description')
                    ->orWhere('description', '=', '');
            })->count();

        // Properties tanpa title
        $noTitle = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('title')
                    ->orWhere('title', '=', '');
            })->count();

        // Properties sold / rented
        $sold = Property::where('property_status', 'SOLD')->count();
        $rented = Property::where('property_status', 'RENTED')->count();

        // Properties expired
        $expired = Property::whereNotNull('expired_date')
            ->where('expired_date', '<', now()->toDateString())->count();

        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Properties di Database', $totalAll],
                ['Properties Aktif + Layak Index (ada foto+title+desc)', $totalActive],
                ['Properties Tanpa Foto', $noPhotos],
                ['Properties Tanpa Deskripsi', $noDesc],
                ['Properties Tanpa Title', $noTitle],
                ['Properties SOLD', $sold],
                ['Properties RENTED', $rented],
                ['Properties Expired', $expired],
            ]
        );

        $this->warn("Target GSC Indexed: 400+ (saat ini reported: 122)");
        $this->warn("Jika DB: {$totalActive} property layak index, gap: " . ($totalActive - 122) . " property belum terindex");
    }

    // ================================================================
    // PRIORITY 3: Audit Thin Content
    // ================================================================
    private function runPriority3()
    {
        $this->line('');
        $this->line(str_repeat('-', 80));
        $this->info('PRIORITY 3: AUDIT THIN CONTENT');
        $this->line(str_repeat('-', 80));

        // Property dengan description < 300 karakter
        $thinDescriptions = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->selectRaw('id, title, slug, property_number, CHAR_LENGTH(description) as desc_len, description')
            ->havingRaw('desc_len < 300')
            ->orderByRaw('desc_len ASC')
            ->limit(30)
            ->get();

        // Property dengan description kosong/null
        $emptyDescriptions = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('description')
                    ->orWhere('description', '=', '');
            })
            ->select('id', 'title', 'slug', 'property_number')
            ->limit(20)
            ->get();

        // Stats
        $totalThin = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->whereRaw('CHAR_LENGTH(description) < 300')
            ->count();

        $totalEmpty = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->where(function ($q) {
                $q->whereNull('description')
                    ->orWhere('description', '=', '');
            })->count();

        $this->warn("Total deskripsi < 300 karakter: {$totalThin}");
        $this->warn("Total deskripsi KOSONG: {$totalEmpty}");

        if ($thinDescriptions->count() > 0) {
            $this->line('');
            $this->info("Sample deskripsi < 300 karakter (Top {$thinDescriptions->count()}):");
            $rows = $thinDescriptions->map(function ($p) {
                return [
                    'ID' => $p->id,
                    'PN' => $p->property_number,
                    'Title' => Str::limit($p->title, 40),
                    'Desc Len' => $p->desc_len . ' chars',
                    'URL' => '/property/' . ($p->property_number ?? $p->slug),
                ];
            })->toArray();
            $this->table(['ID', 'PN', 'Title', 'Desc Len', 'URL'], $rows);
        }

        if ($emptyDescriptions->count() > 0) {
            $this->line('');
            $this->error("Property dengan deskripsi KOSONG (Top {$emptyDescriptions->count()}):");
            $rows = $emptyDescriptions->map(function ($p) {
                return [
                    'ID' => $p->id,
                    'PN' => $p->property_number ?? '-',
                    'Title' => Str::limit($p->title ?? 'NULL', 40),
                    'URL' => '/property/' . ($p->property_number ?? $p->slug),
                ];
            })->toArray();
            $this->table(['ID', 'PN', 'Title', 'URL'], $rows);
        }
    }

    // ================================================================
    // PRIORITY 2: Audit Kualitas Halaman Property (20 terbaru)
    // ================================================================
    private function runPriority2()
    {
        $this->line('');
        $this->line(str_repeat('-', 80));
        $this->info('PRIORITY 2: AUDIT KUALITAS HALAMAN PROPERTY (20 Terbaru)');
        $this->line(str_repeat('-', 80));

        $properties = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $rows = [];
        foreach ($properties as $property) {
            $desc = $property->description ?? '';
            $wordCount = str_word_count(strip_tags($desc));
            $descLen = mb_strlen($desc);
            $title = $property->title ?? '';

            $rows[] = [
                'ID' => $property->id,
                'PN' => $property->property_number ?? '-',
                'Title' => Str::limit($title, 35),
                'Desc Words' => $wordCount,
                'Desc Chars' => $descLen,
                'Title Len' => mb_strlen($title),
                'Slug' => Str::limit($property->slug, 20),
                'Status' => $descLen < 500 ? 'THIN (<500 chars)' : ($descLen < 1200 ? 'OK (500-1200)' : 'GOOD (1200+)'),
            ];
        }

        $this->table(['ID', 'PN', 'Title', 'Desc Words', 'Desc Chars', 'Title Len', 'Slug', 'Status'], $rows);

        // Statistik
        $avgWords = count($rows) > 0 ? round(array_sum(array_column($rows, 'Desc Words')) / count($rows)) : 0;
        $avgChars = count($rows) > 0 ? round(array_sum(array_column($rows, 'Desc Chars')) / count($rows)) : 0;
        $goodCount = count(array_filter($rows, fn($r) => str_starts_with($r['Status'], 'GOOD')));
        $okCount = count(array_filter($rows, fn($r) => str_starts_with($r['Status'], 'OK')));
        $thinCount = count(array_filter($rows, fn($r) => str_starts_with($r['Status'], 'THIN')));

        $this->line('');
        $this->warn("Rata-rata word count: {$avgWords} kata | Rata-rata chars: {$avgChars}");
        $this->warn("Target deskripsi: 500-1200 karakter (minimal)");
        $this->info("GOOD (1200+ chars): {$goodCount} | OK (500-1200): {$okCount} | THIN (<500): {$thinCount}");

        // Duplicate title check
        $this->line('');
        $this->info("Duplicate Title Check (sample):");
        $duplicateTitles = Property::select('title')
            ->whereNotNull('title')
            ->groupBy('title')
            ->havingRaw('COUNT(*) > 1')
            ->limit(10)
            ->pluck('title');

        if ($duplicateTitles->count() > 0) {
            foreach ($duplicateTitles as $dupTitle) {
                $count = Property::where('title', $dupTitle)->count();
                $this->warn("  \"{$dupTitle}\" muncul {$count}x");
            }
        } else {
            $this->info("  Tidak ditemukan duplicate title di 10 sample.");
        }
    }

    // ================================================================
    // PRIORITY 4: Audit Internal Link (Homepage)
    // ================================================================
    private function runPriority4()
    {
        $this->line('');
        $this->line(str_repeat('-', 80));
        $this->info('PRIORITY 4: AUDIT INTERNAL LINK');
        $this->line(str_repeat('-', 80));

        $this->warn("=== Analisis dari code review resources/views/public/index.blade.php ===");
        $this->warn("(Ini adalah source code audit, bukan crawl)");

        $this->line('');
        $this->info('Form Filter di Homepage menghasilkan URL query:');

        $filterParams = [
            'property_type' => 'select dropdown (dari DB PropertyType)',
            'location' => 'select dropdown (dari DB Property.area)',
            'property_category' => 'select: LEASEHOLD, FREEHOLD, RENT_YEARLY, RENT_MONTHLY',
            'currency' => 'select: IDR, USD',
            'min_price' => 'input number',
            'max_price' => 'input number',
            'bedroom' => 'select: 1-10',
            'property_tag' => 'select: new, featured, + tags DB',
            'search_type' => 'hidden input',
            'land_size' => 'select: 0-50, 50-100, 100-200, 200+',
            'pic_ref_number' => 'input text',
            'property_number' => 'input text',
            'keyword' => 'input text',
        ];

        $this->table(['Parameter', 'Source'], array_map(
            fn($k, $v) => [$k, $v],
            array_keys($filterParams),
            $filterParams
        ));

        $this->line('');
        $this->info("Jumlah link property per halaman: 12 (paginate)");
        $this->info("Total kombinasi filter yang mungkin: ~ribuan (unique oleh user input)");
        $this->info("Semua URL query sudah di-noindex + di-block robots.txt");

        $this->line('');
        $this->warn("Rekomendasi:");
        $this->warn("1. Hapus link submit filter dari halaman utama, ganti dengan JS-only filtering");
        $this->warn("2. ATAU ganti filter form method GET ke POST (JavaScript fetch)");
        $this->warn("3. Ini akan mencegah Googlebot menemukan semua kombinasi URL filter");
    }

    // ================================================================
    // SUMMARY
    // ================================================================
    private function outputSummary()
    {
        $this->line('');
        $this->line(str_repeat('=', 80));
        $this->info('       SUMMARY & NEXT STEPS');
        $this->line(str_repeat('=', 80));

        $this->line('');
        $this->info('PRIORITY 1: Cek GSC "Crawled - Currently Not Indexed"');
        $this->line('  => Export 50 URL dari GSC lalu kelompokkan manual');
        $this->line('  => Kategori: Property / Advisor Guide / Lainnya');

        $this->line('');
        $this->info('PRIORITY 3: Perbaiki Thin Content');
        $this->line('  => Perbaiki property dengan deskripsi < 300 karakter terlebih dahulu');
        $this->line('  => Target minimal 500 kata per property');

        $this->line('');
        $this->info('PRIORITY 4: Hapus form GET filter atau ganti ke JS');
        $this->line('  => Edit resources/views/public/index.blade.php');

        $this->line('');
        $this->info('PRIORITY 6: Buat Landing Page SEO');
        $this->line('  => /villas-for-sale-in-bali');
        $this->line('  => /villas-for-rent-in-bali');
        $this->line('  => /land-for-sale-in-bali');
        $this->line('  => /property-in-canggu');
        $this->line('  => /property-in-seminyak');
        $this->line('  => /property-in-ubud');

        $this->line('');
        $this->info(str_repeat('=', 80));
        $this->info('AUDIT SELESAI');
        $this->info(str_repeat('=', 80));
    }
}
