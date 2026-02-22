<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\TamkeenPartnership;
use App\Models\TamkeenSetting;

class TamkeenController extends Controller
{
    public function index()
    {
        $query = TamkeenPartnership::orderBy('sort_order')->orderByDesc('created_at');
        
        // Filter by sector if provided
        if (request()->filled('sector')) {
            $query->where('sector', request('sector'));
        }
        
        $partnerships = $query->paginate(12)->withQueryString();

        $totalBeneficiaries = TamkeenPartnership::sum('beneficiaries_count') ?: 0;
        $totalPartnerships = TamkeenPartnership::count();
        
        // Sectors from dashboard settings
        $tamkeenSettings = TamkeenSetting::get();
        $sectorsList = $tamkeenSettings->sectors ?? TamkeenSetting::defaultSectors();
        $sectorsMap = $tamkeenSettings->getSectorsForLocale();
        
        // Available sectors = those from settings that exist in at least one partnership (or all if none)
        $usedSectors = TamkeenPartnership::whereNotNull('sector')->distinct()->pluck('sector')->toArray();
        $availableSectors = empty($usedSectors) ? array_column($sectorsList, 'key') : $usedSectors;

        return view('website.enable', compact('partnerships', 'totalBeneficiaries', 'totalPartnerships', 'availableSectors', 'sectorsList', 'sectorsMap'));
    }
}
