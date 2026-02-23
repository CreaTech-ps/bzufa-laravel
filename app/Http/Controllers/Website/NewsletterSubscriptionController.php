<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => __('ui.email_required'),
            'email.email' => __('ui.email_invalid'),
        ]);

        $email = strtolower(trim($validated['email']));
        $locale = app()->getLocale();

        NewsletterSubscriber::firstOrCreate(
            ['email' => $email],
            ['locale' => $locale]
        );

        return back()->with('newsletter_success', __('ui.newsletter_subscribed'));
    }
}
