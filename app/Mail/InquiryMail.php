<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->data['subject'] ?? 'Inquiry';
        $subjectLabel = match ($subject) {
            'tanya properti' => 'Tanya Properti',
            'tanya harga' => 'Tanya Harga',
            default => $subject,
        };

        $propertyNumber = $this->data['property_number'] ?? null;
        $subjectText = $subjectLabel . ($propertyNumber ? ' - ' . $propertyNumber : '');

        return new Envelope(
            subject: $subjectText,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inquiry',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
