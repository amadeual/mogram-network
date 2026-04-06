<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WithdrawalRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;
    public $method;
    public $id;

    public function __construct($amount, $method, $id)
    {
        $this->amount = $amount;
        $this->method = $method;
        $this->id = $id;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🏧 Solicitação de Saque - Mogram Network',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.withdrawal_requested',
            with: [
                'amount' => $this->amount,
                'method' => $this->method,
                'id' => $this->id,
            ]
        );
    }
}
