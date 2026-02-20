<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\KananiSetting;
use App\Models\StoreProduct;

class KananiController extends Controller
{
    public function index()
    {
        $settings = KananiSetting::get();
        $items = StoreProduct::query()
            ->where('is_active', true)
            ->orderByDesc('sort_order')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        return view('website.canaanite', compact('settings', 'items'));
    }
}
