<?php

namespace App\Mail;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterNewNewsPublished extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public News $news;
    public string $subscriberLocale;

    public function __construct(News $news, string $subscriberLocale = 'ar')
    {
        $this->news = $news;
        $this->subscriberLocale = $subscriberLocale;
    }

    public function envelope(): Envelope
    {
        $title = $this->subscriberLocale === 'en' && $this->news->title_en
            ? $this->news->title_en
            : $this->news->title_ar;

        return new Envelope(
            subject: $this->subscriberLocale === 'ar'
                ? 'خبر جديد: ' . $title
                : 'New article: ' . $title,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.newsletter-new-news');
    }
}
