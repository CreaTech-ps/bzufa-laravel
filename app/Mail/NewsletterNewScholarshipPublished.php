<?php

namespace App\Mail;

use App\Models\Scholarship;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterNewScholarshipPublished extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Scholarship $scholarship,
        public string $subscriberLocale = 'ar'
    ) {}

    public function envelope(): Envelope
    {
        $title = $this->subscriberLocale === 'en' && $this->scholarship->title_en
            ? $this->scholarship->title_en
            : $this->scholarship->title_ar;

        return new Envelope(
            subject: $this->subscriberLocale === 'ar'
                ? 'منحة جديدة: ' . $title
                : 'New scholarship: ' . $title,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.newsletter-new-scholarship');
    }
}
