<?php

namespace App\Mail;

use App\Models\Enquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

/**
 * Sent to the enquiry inbox (reachout@) for every contact-us / request-a-quote submission.
 * Reply-To is the customer, so replying from the mail client answers them directly.
 */
class EnquiryReceived extends Mailable
{
    public function __construct(public Enquiry $enquiry) {}

    public function envelope(): Envelope
    {
        $label = self::typeLabel($this->enquiry->type);
        $subject = $this->enquiry->subject ?: ($this->enquiry->form_data['service'] ?? null);

        return new Envelope(
            from: new Address(config('mail.enquiries.from'), config('mail.from.name')),
            replyTo: [new Address($this->enquiry->email, $this->enquiry->name)],
            subject: "New {$label} from {$this->enquiry->name}" . ($subject ? " — {$subject}" : ''),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-received',
            with: [
                'enquiry' => $this->enquiry,
                'typeLabel' => self::typeLabel($this->enquiry->type),
                'adminUrl' => rtrim(config('app.url'), '/') . '/admin/enquiries',
            ],
        );
    }

    public static function typeLabel(?string $type): string
    {
        return match ($type) {
            'quote' => 'quote request',
            'contact' => 'contact message',
            'consultation' => 'consultation request',
            'service_enquiry' => 'service enquiry',
            'product_enquiry' => 'product enquiry',
            default => 'enquiry',
        };
    }
}
