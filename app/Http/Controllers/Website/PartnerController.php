<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\PartnershipRequestNotification;
use App\Models\Partner;
use App\Models\PartnershipRequest;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        // تأكيد ضبط اللغة من الـ URL لضمان تطابق ترجمات النموذج مع لغة العرض
        $locale = LaravelLocalization::getCurrentLocale();
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
        }

        $type = $request->query('type', 'company');
        if (!in_array($type, ['company', 'individual'])) {
            $type = 'company';
        }

        $partners = Partner::where('type', $type)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(8)
            ->withQueryString();

        $totalPartners = Partner::count();
        $companyCount = Partner::where('type', 'company')->count();
        $individualCount = Partner::where('type', 'individual')->count();

        if ($request->ajax() || $request->query('ajax')) {
            $html = view('website.partials.partners_list', compact('partners'))->render();
            return response()->json([
                'html' => $html,
                'type' => $type,
                'current_page' => $partners->currentPage(),
                'last_page' => $partners->lastPage(),
            ]);
        }

        return view('website.success_partners', compact('partners', 'totalPartners', 'companyCount', 'individualCount', 'type'));
    }

    public function storePartnershipRequest(Request $request)
    {
        // ضبط اللغة من الـ URL (مهم لطلبات POST لأن الحزمة قد تتجاهلها)
        $locale = $request->segment(1) ?: config('app.locale');
        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
        }

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'message' => ['nullable', 'string', 'max:2000'],
        ], [
            'company_name.required' => __('partners.validation_company_name'),
            'contact_name.required' => __('partners.validation_contact_name'),
            'email.required' => __('partners.validation_email_required'),
            'email.email' => __('partners.validation_email_email'),
            'phone.required' => __('partners.validation_phone'),
        ]);

        $partnershipRequest = PartnershipRequest::create([
            'company_name' => $validated['company_name'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'] ?? null,
        ]);

        try {
            $siteSettings = SiteSetting::get();
            $recipientEmail = $siteSettings->contact_email ?: config('mail.from.address');

            if (config('mail.default') === 'log') {
                \Log::info('Partnership request (email=log):', $validated);
            } else {
                Mail::to($recipientEmail)->send(new PartnershipRequestNotification($partnershipRequest));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send partnership request email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => __('partners.request_success'),
        ]);
    }
}
