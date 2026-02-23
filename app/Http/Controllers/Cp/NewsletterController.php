<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Services\NewsletterService;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query()->orderByDesc('subscribed_at');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('email', 'like', "%{$q}%");
        }

        $subscribers = $query->paginate(20)->withQueryString();

        return view('cp.newsletter.index', compact('subscribers'));
    }

    public function broadcast()
    {
        return view('cp.newsletter.broadcast');
    }

    public function sendBroadcast(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $count = app(NewsletterService::class)->sendBroadcast(
            $validated['subject'],
            $validated['body']
        );

        return redirect()->route('cp.newsletter.broadcast')->with('success', "تم إرسال الرسالة إلى {$count} مشترك بنجاح.");
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('cp.newsletter.index')->with('success', 'تم إلغاء اشتراك المستخدم بنجاح.');
    }
}
