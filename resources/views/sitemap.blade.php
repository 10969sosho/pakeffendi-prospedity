<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Featured Properties -->
    <url>
        <loc>{{ route('featured-properties') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Successful Properties -->
    <url>
        <loc>{{ route('successful-properties') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Static Pages -->
    <url>
        <loc>{{ route('about-us') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ route('our-services') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>

    <url>
        <loc>{{ route('contact-us') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>

    <url>
        <loc>{{ route('advisor-guide') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Property Details (only valid properties) -->
    @foreach($properties as $property)
    <url>
        <loc>{{ route('property.show', $property->property_number ?? $property->slug) }}</loc>
        <lastmod>{{ $property->updated_at->tz('Asia/Jakarta')->format('Y-m-d\TH:i:sP') }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach

    <!-- Advisor Guide Posts -->
    @foreach($advisorGuides as $guide)
    <url>
        <loc>{{ route('advisor-guide.show', $guide) }}</loc>
        <lastmod>{{ $guide->updated_at->tz('Asia/Jakarta')->format('Y-m-d\TH:i:sP') }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach
</urlset>
