<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use App\Models\HomeStatistic;
use App\Models\News;
use App\Models\Partner;
use App\Models\SuccessStory;

class HomeController extends Controller
{
    public function index()
    {
        $homeSetting = HomeSetting::get();
        $statistics = HomeStatistic::orderBy('sort_order')->orderBy('id')->get();
        $partners = Partner::orderBy('sort_order')->orderBy('id')->get();
        $newsItems = News::where('is_published', true)
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();
        $successStories = SuccessStory::where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(10)
            ->get();

        return view('website.home', compact('homeSetting', 'statistics', 'partners', 'newsItems', 'successStories'));
    }
}
