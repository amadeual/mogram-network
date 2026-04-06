<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContentPurchasedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📸 Conteúdo Novo Desbloqueado - Mogram Network',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.content_purchased',
            with: [
                'amount' => $this->amount,
            ]
        );
    }
}
