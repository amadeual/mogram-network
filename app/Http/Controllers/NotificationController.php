<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->take(20)->get();
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => auth()->user()->unreadNotifications->count()
        ]);
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->each(function ($notification) {
            $notification->markAsRead();
        });

        return response()->json(['success' => true]);
    }
}
