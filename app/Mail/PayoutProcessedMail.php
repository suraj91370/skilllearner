<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PayoutProcessedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $userName,
        public float $amount,
        public string $payoutCode,
        public string $paymentMethod,
        public ?string $utrNumber = null,
        public ?string $remarks = null,
        public ?string $processedAt = null
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payout Credited Successfully | Skilllearner',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payout-processed',
            with: [
                'userName' => $this->userName,
                'amount' => $this->amount,
                'payoutCode' => $this->payoutCode,
                'paymentMethod' => $this->paymentMethod,
                'utrNumber' => $this->utrNumber,
                'remarks' => $this->remarks,
                'processedAt' => $this->processedAt ?? now()->format('d M Y, h:i A'),
                'subject' => 'Payout Credited Successfully | Skilllearner',
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
