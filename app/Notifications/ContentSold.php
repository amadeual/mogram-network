<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ContentSold extends Notification
{
    use Queueable;

    public $amount;
    public $buyerName;
    public $postName;

    public function __construct($amount, $buyerName, $postName = null)
    {
        $this->amount = $amount;
        $this->buyerName = $buyerName;
        $this->postName = $postName;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $postLabel = $this->postName ? " em '{$this->postName}'" : "";
        return [
            'title' => 'Venda Realizada!',
            'message' => "Você recebeu R$ " . number_format($this->amount, 2, ',', '.') . " de {$this->buyerName}{$postLabel}.",
            'type' => 'sale',
            'buyer' => $this->buyerName,
            'amount' => $this->amount,
            'icon' => 'card'
        ];
    }
}
