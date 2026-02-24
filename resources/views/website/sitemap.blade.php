<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach($routes as $route)
    @php
        $arUrl = $route['url'];
        $enUrl = $route['url_en'] ?? null;
    @endphp
    <url>
        <loc>{{ $arUrl }}</loc>
        @if(isset($route['lastmod']))
        <lastmod>{{ $route['lastmod'] }}</lastmod>
        @endif
        <changefreq>{{ $route['changefreq'] ?? 'monthly' }}</changefreq>
        <priority>{{ $route['priority'] ?? '0.5' }}</priority>
        <xhtml:link rel="alternate" hreflang="ar" href="{{ $arUrl }}" />
        @if($enUrl)
        <xhtml:link rel="alternate" hreflang="en" href="{{ $enUrl }}" />
        @endif
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $arUrl }}" />
    </url>
    @if(!empty($enUrl) && $enUrl !== $arUrl)
    <url>
        <loc>{{ $enUrl }}</loc>
        @if(isset($route['lastmod']))
        <lastmod>{{ $route['lastmod'] }}</lastmod>
        @endif
        <changefreq>{{ $route['changefreq'] ?? 'monthly' }}</changefreq>
        <priority>{{ $route['priority'] ?? '0.5' }}</priority>
        <xhtml:link rel="alternate" hreflang="ar" href="{{ $arUrl }}" />
        <xhtml:link rel="alternate" hreflang="en" href="{{ $enUrl }}" />
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $arUrl }}" />
    </url>
    @endif
@endforeach
</urlset>
