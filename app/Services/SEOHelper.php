<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SEOHelper
{
    protected Request $request;
    protected string $siteName;
    protected string $siteUrl;
    protected string $defaultDescription;
    protected string $defaultImage;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->siteName = 'Prospedity Digital Properties Bali';
        $this->siteUrl = url('/');
        $this->defaultDescription = 'Curating exceptional villas and investment properties in Bali\'s most sought-after locations. Experience premium tropical living with Prospedity.';
        $this->defaultImage = $this->siteUrl . '/images/og-default.jpg';
    }

    public function getSiteName(): string
    {
        return $this->siteName;
    }

    public function getSiteUrl(): string
    {
        return $this->siteUrl;
    }

    public function canonical(string $path = ''): string
    {
        $url = $this->siteUrl;
        if ($path) {
            $url .= '/' . ltrim($path, '/');
        }
        return $url;
    }

    public function currentCanonical(): string
    {
        $path = $this->request->path();
        if ($path === '/') {
            return $this->siteUrl;
        }
        return $this->siteUrl . '/' . $path;
    }

    public function cleanCanonical(): string
    {
        return $this->siteUrl . '/' . ltrim($this->request->path(), '/');
    }

    public function shouldNoindex(): bool
    {
        if ($this->request->hasAny(['page', 'sort', 'search', 'filter'])) {
            return true;
        }
        return false;
    }

    public function generateTitle(string $pageTitle, bool $includeBrand = true): string
    {
        if ($includeBrand) {
            return $pageTitle . ' | Prospedity';
        }
        return $pageTitle;
    }

    public function generateDescription(string $description): string
    {
        if (empty($description)) {
            return $this->defaultDescription;
        }
        return Str::limit(strip_tags($description), 160);
    }

    public function metaRobots(): string
    {
        if ($this->shouldNoindex()) {
            return 'noindex,follow';
        }
        return 'index,follow';
    }

    public function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Prospedity',
            'alternateName' => 'Prospedity Digital Properties Bali',
            'url' => $this->siteUrl,
            'description' => $this->defaultDescription,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Bali',
                'addressCountry' => 'ID',
            ],
        ];
    }

    public function breadcrumbSchema(array $items): array
    {
        $itemListElement = [];
        $position = 1;

        foreach ($items as $item) {
            $itemListElement[] = [
                '@type' => 'ListItem',
                'position' => $position,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
            $position++;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemListElement,
        ];
    }

    public function realEstateListingSchema(array $property): array
    {
        $photos = $property['photos'] ?? [];

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'RealEstateListing',
            'name' => $property['title'],
            'description' => $property['description'] ?? $this->defaultDescription,
            'url' => $property['url'] ?? $this->siteUrl,
            'image' => !empty($photos) ? $photos : [$this->defaultImage],
            'datePosted' => $property['created_at'] ?? date('c'),
        ];

        if (!empty($property['price'])) {
            $schema['offers'] = [
                '@type' => 'Offer',
                'price' => $property['price'],
                'priceCurrency' => $property['currency'] ?? 'IDR',
            ];
        }

        return $schema;
    }

    public function webSiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $this->siteName,
            'url' => $this->siteUrl,
            'description' => $this->defaultDescription,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $this->siteUrl . '/?keyword={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    public function defaultMetaTags(): string
    {
        $tags = '';

        $canonical = $this->cleanCanonical();
        $tags .= '<link rel="canonical" href="' . e($canonical) . '">' . "\n";

        $robots = $this->shouldNoindex() ? 'noindex,follow' : 'index,follow';
        $tags .= '<meta name="robots" content="' . $robots . '">' . "\n";

        return $tags;
    }
}
