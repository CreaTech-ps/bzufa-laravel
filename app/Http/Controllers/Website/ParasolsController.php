<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\ParasolsImage;
use App\Models\ParasolsRegion;
use App\Models\ParasolsSetting;

class ParasolsController extends Controller
{
    public function index()
    {
        $settings = ParasolsSetting::get();
        $regions = ParasolsRegion::orderBy('sort_order')->orderBy('id')->get();

        $regionId = request('region');

        $query = ParasolsImage::with('region')
            ->orderBy('sort_order')
            ->orderBy('id');

        if ($regionId) {
            $query->where('region_id', $regionId);
        }

        $images = $query->paginate(9)->withQueryString();

        $totalSpaces = ParasolsImage::count();

        return view('website.umbrellas', compact('settings', 'regions', 'images', 'totalSpaces'));
    }
}
