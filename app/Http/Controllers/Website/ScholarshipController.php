<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        $totalActive = Scholarship::where('is_active', true)->count();

        return view('website.grants', compact('scholarships', 'totalActive'));
    }

    public function show(string $slug)
    {
        $scholarship = Scholarship::where('is_active', true)
            ->when(is_numeric($slug), fn ($q) => $q->where('id', (int) $slug))
            ->when(!is_numeric($slug), fn ($q) => $q->where(function ($q2) use ($slug) {
                $q2->where('slug_ar', $slug)->orWhere('slug_en', $slug);
            }))
            ->firstOrFail();

        $related = Scholarship::where('is_active', true)
            ->where('id', '!=', $scholarship->id)
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('website.scholarship_details', compact('scholarship', 'related'));
    }

    public function apply(string $slug)
    {
        $scholarship = Scholarship::where('is_active', true)
            ->when(is_numeric($slug), fn ($q) => $q->where('id', (int) $slug))
            ->when(!is_numeric($slug), fn ($q) => $q->where(function ($q2) use ($slug) {
                $q2->where('slug_ar', $slug)->orWhere('slug_en', $slug);
            }))
            ->firstOrFail();

        return view('website.application_steps', compact('scholarship'));
    }

    public function storeApplication(Request $request, string $slug)
    {
        $scholarship = Scholarship::where('is_active', true)
            ->when(is_numeric($slug), fn ($q) => $q->where('id', (int) $slug))
            ->when(!is_numeric($slug), fn ($q) => $q->where(function ($q2) use ($slug) {
                $q2->where('slug_ar', $slug)->orWhere('slug_en', $slug);
            }))
            ->firstOrFail();

        if ($scholarship->application_end_date && $scholarship->application_end_date->isPast()) {
            return back()->withInput()->with('error', 'انتهى موعد التقديم على هذه المنحة.');
        }

        $validated = $request->validate([
            'applicant_name' => ['required', 'string', 'max:255'],
            'applicant_id_number' => ['required', 'string', 'max:50'],
            'filled_form' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'], // 10MB
            'consent' => ['required', 'accepted'],
        ], [
            'applicant_name.required' => 'يرجى إدخال الاسم الكامل.',
            'applicant_id_number.required' => 'يرجى إدخال رقم الهوية الوطنية أو الإقامة.',
            'filled_form.required' => 'يرجى رفع نموذج المنحة المعبأ (PDF أو صورة).',
            'filled_form.file' => 'يرجى رفع ملف صحيح.',
            'filled_form.mimes' => 'يرجى رفع ملف بصيغة PDF أو JPG أو PNG.',
            'filled_form.max' => 'حجم الملف يجب أن لا يتجاوز 10 ميجابايت.',
            'consent.required' => 'يجب الموافقة على الشروط لإرسال الطلب.',
            'consent.accepted' => 'يجب الموافقة على الشروط لإرسال الطلب.',
        ]);

        $filePath = $request->file('filled_form')->store('scholarship-applications/' . $scholarship->id, 'public');

        $application = ScholarshipApplication::create([
            'scholarship_id' => $scholarship->id,
            'applicant_name' => $validated['applicant_name'],
            'applicant_id_number' => $validated['applicant_id_number'],
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('grants.apply', $scholarship->slug_ar ?: $scholarship->id)
            ->with('success', 'تم استلام طلبك بنجاح. رقم الطلب: #' . $application->id . '. سنتواصل معك قريباً.');
    }
}
