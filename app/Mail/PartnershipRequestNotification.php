<?php

namespace App\Mail;

use App\Models\PartnershipRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PartnershipRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PartnershipRequest $request
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'طلب شراكة جديد — ' . ($this->request->company_name ?? 'شريك نجاح'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.partnership-request',
            with: ['request' => $this->request],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
