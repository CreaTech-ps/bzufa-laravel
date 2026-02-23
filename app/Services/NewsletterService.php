<?php

namespace App\Services;

use App\Mail\NewsletterBroadcast;
use App\Mail\NewsletterNewNewsPublished;
use App\Mail\NewsletterNewScholarshipPublished;
use App\Models\News;
use App\Models\NewsletterSubscriber;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Mail;

class NewsletterService
{
    public function notifyNewNews(News $news): void
    {
        $subscribers = NewsletterSubscriber::all();

        foreach ($subscribers as $subscriber) {
            $locale = $subscriber->locale ?: 'ar';
            Mail::to($subscriber->email)->send(new NewsletterNewNewsPublished($news, $locale));
        }
    }

    public function notifyNewScholarship(Scholarship $scholarship): void
    {
        $subscribers = NewsletterSubscriber::all();

        foreach ($subscribers as $subscriber) {
            $locale = $subscriber->locale ?: 'ar';
            Mail::to($subscriber->email)->send(new NewsletterNewScholarshipPublished($scholarship, $locale));
        }
    }

    public function sendBroadcast(string $subject, string $body): int
    {
        $subscribers = NewsletterSubscriber::all();
        $count = 0;

        foreach ($subscribers as $subscriber) {
            $locale = $subscriber->locale ?: 'ar';
            Mail::to($subscriber->email)->send(new NewsletterBroadcast($subject, $body, $locale));
            $count++;
        }

        return $count;
    }
}
