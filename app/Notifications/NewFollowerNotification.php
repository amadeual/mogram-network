<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewFollowerNotification extends Notification
{
    use Queueable;

    public $followerName;
    public $followerUsername;

    public function __construct($followerName, $followerUsername)
    {
        $this->followerName = $followerName;
        $this->followerUsername = $followerUsername;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Novo Seguidor!',
            'message' => "@{$this->followerUsername} ({$this->followerName}) começou a te seguir.",
            'type' => 'follow',
            'follower' => $this->followerUsername,
            'icon' => 'user'
        ];
    }
}
