<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;

class RobotsController extends Controller
{
    public function index()
    {
        $seo = SeoSetting::first();

        if ($seo && trim((string) $seo->robots_txt) !== '') {
            $content = trim($seo->robots_txt);
            if (!str_contains($content, 'Sitemap:')) {
                $content .= "\n\nSitemap: " . url('/sitemap.xml');
            }
        } else {
            $content = "User-agent: *\n";
            $content .= "Allow: /\n\n";
            $content .= "# Disallow admin panel\n";
            $content .= "Disallow: /cp/\n";
            $content .= "Disallow: /admin/\n\n";
            $content .= "# Sitemap (مهم لمحركات البحث)\n";
            $content .= "Sitemap: " . url('/sitemap.xml') . "\n";
        }

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
