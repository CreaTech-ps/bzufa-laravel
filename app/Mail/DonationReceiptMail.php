<?php

namespace App\Mail;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Donation $donation,
        public string $storeName,
        public ?string $cardBrand
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('donate.email_subject_receipt') . ' — ' . $this->storeName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.donation-receipt',
            with: [
                'donation' => $this->donation,
                'storeName' => $this->storeName,
                'cardBrand' => $this->cardBrand,
            ],
        );
    }
}
