<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $type = request('type', 'company');
        if (!in_array($type, ['company', 'individual'])) {
            $type = 'company';
        }

        // جلب الجميع للفلترة عبر JS (بدون pagination) أو استخدام النوع المطلوب مع pagination
        $partners = Partner::orderBy('sort_order')->orderBy('id')->get();
        $totalPartners = $partners->count();
        $companyCount = $partners->where('type', 'company')->count();
        $individualCount = $partners->where('type', 'individual')->count();

        return view('website.success_partners', compact('partners', 'totalPartners', 'companyCount', 'individualCount', 'type'));
    }
}
