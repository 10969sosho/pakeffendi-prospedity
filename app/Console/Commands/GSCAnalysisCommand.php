<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\AdvisorGuide;
use Illuminate\Console\Command;

class GSCAnalysisCommand extends Command
{
    protected $signature = 'seo:gsc-analyze {file? : Path to GSC CSV export file}';
    protected $description = 'Analyze GSC Crawled Currently Not Indexed CSV export';

    public function handle()
    {
        $filePath = $this->argument('file');

        $this->line(str_repeat('=', 75));
        $this->info('GSC "Crawled - Currently Not Indexed" ANALYSIS');
        $this->line(str_repeat('=', 75));

        if ($filePath && file_exists($filePath)) {
            $this->analyzeCsv($filePath);
        } else {
            $this->showDatabaseAnalysis();
        }

        $this->line('');
        $this->info('INSTRUCTIONS:');
        $this->line('1. Go to Google Search Console → Pages → Crawled - Currently Not Indexed');
        $this->line('2. Click "Export" → Download CSV');
        $this->line('3. Run: php artisan seo:gsc-analyze /path/to/downloaded.csv');
        $this->line('');
        $this->line('Below is a database-based estimation of what those 380 URLs likely contain:');
    }

    private function analyzeCsv(string $filePath): void
    {
        $this->info("Reading: {$filePath}");

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->error('Cannot open file');
            return;
        }

        $headers = fgetcsv($handle);
        $urls = [];
        while (($row = fgetcsv($handle)) !== false) {
            $urls[] = $row[0]; // First column is typically the URL
        }
        fclose($handle);

        $this->categorizeUrls($urls);
    }

    private function showDatabaseAnalysis(): void
    {
        // Simulate what would be in GSC based on DB data
        $urls = [];

        // Property detail pages — these are the most likely candidates
        $properties = Property::where(function ($q) {
            $q->where('property_status', 'AVAILABLE')
                ->orWhereNull('property_status');
        })
            ->whereNotNull('title')
            ->where('title', '!=', '')
            ->where(function ($q) {
                $q->whereNull('description')
                    ->orWhere('description', '=', '')
                    ->orWhereRaw('CHAR_LENGTH(description) < 300');
            })
            ->limit(100)
            ->get();

        foreach ($properties as $p) {
            $urls[] = url('/property/' . ($p->property_number ?? $p->slug));
        }

        // Advisor guide pages
        $guides = AdvisorGuide::limit(50)->get();
        foreach ($guides as $g) {
            $urls[] = route('advisor-guide.show', $g);
        }

        // Static pages
        $urls[] = route('home');
        $urls[] = route('featured-properties');
        $urls[] = route('successful-properties');
        $urls[] = route('about-us');
        $urls[] = route('our-services');
        $urls[] = route('contact-us');
        $urls[] = route('advisor-guide');

        $this->categorizeUrls(array_unique($urls));
    }

    private function categorizeUrls(array $urls): void
    {
        $property = [];
        $guide = [];
        $other = [];

        foreach ($urls as $url) {
            $url = trim($url);
            if (empty($url)) continue;

            if (str_contains($url, '/property/')) {
                $property[] = $url;
            } elseif (str_contains($url, '/advisor-guide/')) {
                $guide[] = $url;
            } else {
                $other[] = $url;
            }
        }

        $total = count($property) + count($guide) + count($other);

        $this->line('');
        $this->table(
            ['Category', 'Count', '%'],
            [
                ['Property Detail (/property/*)', count($property), $total > 0 ? round(count($property) / $total * 100) . '%' : '0%'],
                ['Advisor Guide (/advisor-guide/*)', count($guide), $total > 0 ? round(count($guide) / $total * 100) . '%' : '0%'],
                ['Other (static pages, etc.)', count($other), $total > 0 ? round(count($other) / $total * 100) . '%' : '0%'],
                ['TOTAL', $total, '100%'],
            ]
        );

        // Show samples
        $this->line('');
        $this->info("Property Detail Samples (first 10):");
        foreach (array_slice($property, 0, 10) as $url) {
            $this->line("  {$url}");
        }

        if (count($guide) > 0) {
            $this->line('');
            $this->info("Advisor Guide Samples (first 5):");
            foreach (array_slice($guide, 0, 5) as $url) {
                $this->line("  {$url}");
            }
        }

        if (count($other) > 0) {
            $this->line('');
            $this->info("Other URLs:");
            foreach ($other as $url) {
                $this->line("  {$url}");
            }
        }

        $this->line('');
        $this->warn("DIAGNOSIS:");
        if (count($property) > 200) {
            $this->warn("  → Majority are property detail pages — likely thin content issue");
            $this->warn("  → Fix: Run 'php artisan seo:generate-descriptions' to enrich content");
        }
        if (count($guide) > 50) {
            $this->warn("  → Many advisor guide pages — may need more unique content");
        }
        if (count($other) > 10) {
            $this->warn("  → Some static pages not indexed — check meta robots tag");
        }
    }
}
