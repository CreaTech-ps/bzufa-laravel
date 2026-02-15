<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\TamkeenPartnership;

class TamkeenController extends Controller
{
    public function index()
    {
        $partnerships = TamkeenPartnership::orderBy('sort_order')->orderByDesc('created_at')->paginate(12)->withQueryString();

        $totalBeneficiaries = TamkeenPartnership::sum('beneficiaries_count') ?: 0;
        $totalPartnerships = TamkeenPartnership::count();

        return view('website.enable', compact('partnerships', 'totalBeneficiaries', 'totalPartnerships'));
    }
}
