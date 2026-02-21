<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Mail\VolunteerApplicationNotification;
use App\Models\VolunteerApplication;
use App\Models\VolunteerDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class VolunteerController extends Controller
{
    public function getDepartments()
    {
        $departments = VolunteerDepartment::getActive();
        return response()->json($departments->map(function ($dept) {
            return [
                'id' => $dept->id,
                'name' => app()->getLocale() === 'ar' ? $dept->name_ar : ($dept->name_en ?? $dept->name_ar),
            ];
        }));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'department_id' => ['required', 'exists:volunteer_departments,id'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'], // 10MB
        ], [
            'name.required' => __('about.volunteer_validation_name'),
            'email.required' => __('about.volunteer_validation_email_required'),
            'email.email' => __('about.volunteer_validation_email_email'),
            'phone.required' => __('about.volunteer_validation_phone'),
            'department_id.required' => __('about.volunteer_validation_department_required'),
            'department_id.exists' => __('about.volunteer_validation_department_exists'),
            'cv.required' => __('about.volunteer_validation_cv_required'),
            'cv.file' => __('about.volunteer_validation_cv_file'),
            'cv.mimes' => __('about.volunteer_validation_cv_mimes'),
            'cv.max' => __('about.volunteer_validation_cv_max'),
        ]);

        $cvPath = $request->file('cv')->store('volunteer-applications', 'public');

        $application = VolunteerApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'volunteer_department_id' => $validated['department_id'],
            'cv_path' => $cvPath,
        ]);

        // Send email notification to SiteSetting contact_email
        try {
            $siteSettings = \App\Models\SiteSetting::get();
            $recipientEmail = $siteSettings->contact_email ?: config('mail.from.address');
            
            // Check if mail is configured
            $mailDriver = config('mail.default');
            if ($mailDriver === 'log') {
                \Log::warning('Email not sent: MAIL_MAILER is set to "log". Please configure SMTP in .env file. Email would be sent to: ' . $recipientEmail);
                \Log::info('Volunteer Application Details:', [
                    'name' => $application->name,
                    'email' => $application->email,
                    'phone' => $application->phone,
                    'department' => $application->department->name_ar ?? 'N/A',
                ]);
            } else {
                Mail::to($recipientEmail)->send(new VolunteerApplicationNotification($application));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send volunteer application email: ' . $e->getMessage());
            \Log::error('Email details:', [
                'recipient' => $recipientEmail ?? 'N/A',
                'error' => $e->getTraceAsString(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('about.volunteer_request_success'),
        ]);
    }
}
