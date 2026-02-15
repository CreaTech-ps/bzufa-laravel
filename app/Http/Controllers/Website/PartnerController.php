<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $type = request('type', 'company'); // company | individual

        if (!in_array($type, ['company', 'individual'])) {
            $type = 'company';
        }

        $partners = Partner::where('type', $type)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        $totalPartners = Partner::count();
        $companyCount = Partner::where('type', 'company')->count();
        $individualCount = Partner::where('type', 'individual')->count();

        return view('website.success_partners', compact('partners', 'totalPartners', 'companyCount', 'individualCount', 'type'));
    }
}
