<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DepositConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;
    public $id;

    public function __construct($amount, $id)
    {
        $this->amount = $amount;
        $this->id = $id;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💰 Depósito Confirmado - Mogram Network',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deposit_confirmed',
            with: [
                'amount' => $this->amount,
                'id' => $this->id,
            ]
        );
    }
}
