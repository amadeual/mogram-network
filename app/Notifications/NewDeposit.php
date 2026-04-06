<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewDeposit extends Notification
{
    use Queueable;

    public $amount;

    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Depósito Disponível!',
            'message' => 'Seu depósito de R$ ' . number_format($this->amount, 2, ',', '.') . ' foi aprovado com sucesso.',
            'type' => 'deposit',
            'amount' => $this->amount,
            'icon' => 'wallet'
        ];
    }
}
