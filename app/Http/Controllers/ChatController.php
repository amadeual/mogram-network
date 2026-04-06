<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get all users who have sent me messages or I have sent messages to
        $chatUsers = User::where('id', '!=', $userId)
            ->whereHas('sentMessages', function ($query) use ($userId) {
                $query->where('receiver_id', $userId);
            })
            ->orWhereHas('receivedMessages', function ($query) use ($userId) {
                $query->where('sender_id', $userId);
            })
            ->distinct()
            ->get();

        return view('chat', compact('chatUsers'));
    }

    public function show(User $user)
    {
        $userId = Auth::id();
        
        $messages = Message::where(function ($query) use ($userId, $user) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($userId, $user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $user->id)
               ->where('receiver_id', $userId)
               ->update(['is_read' => true]);

        return view('chat-show', compact('user', 'messages'));
    }

    public function sendMessage(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message
        ]);

        return back();
    }
}
