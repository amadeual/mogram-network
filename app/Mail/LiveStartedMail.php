<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Live;
use App\Models\User;

class LiveStartedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $live;
    public $creator;

    public function __construct(Live $live)
    {
        $this->live = $live;
        $this->creator = $live->user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🔴 ' . $this->creator->name . ' está ao vivo no Mogram!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.live-start',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
