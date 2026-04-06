<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContentSoldMail extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;
    public $buyerName;
    public $postTitle;

    public function __construct($amount, $buyerName, $postTitle)
    {
        $this->amount = $amount;
        $this->buyerName = $buyerName;
        $this->postTitle = $postTitle;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💰 Nova Venda Realizada - Mogram Network',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.content_sold',
            with: [
                'amount' => $this->amount,
                'buyerName' => $this->buyerName,
                'postTitle' => $this->postTitle,
            ]
        );
    }
}
