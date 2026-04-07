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

        $gifts = \App\Models\Gift::all();
        return view('chat-show', compact('user', 'messages', 'gifts'));
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

    public function sendGift(Request $request, User $user)
    {
        $request->validate(['gift_id' => 'required|exists:gifts,id']);
        
        $sender = Auth::user();
        $gift = \App\Models\Gift::find($request->gift_id);

        if ($sender->balance < $gift->price) {
            return response()->json(['success' => false, 'message' => 'Saldo insuficiente']);
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($sender, $gift, $user) {
            // Deduct from sender
            $sender->decrement('balance', $gift->price);
            
            // Platform commission (20%)
            $platformComm = $gift->price * 0.20;
            $creatorShare = $gift->price - $platformComm;
            
            // Credit the receiver (creator)
            $user->increment('balance', $creatorShare);

            // Record gift
            \App\Models\LiveGift::create([
                'live_id' => null, // Outside live
                'user_id' => $sender->id,
                'receiver_id' => $user->id,
                'gift_id' => $gift->id,
                'amount' => $gift->price,
                'commission' => $platformComm
            ]);

            // Create message for the gift
            Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $user->id,
                'message' => "🎁 enviou " . $gift->icon . " " . $gift->name . "!"
            ]);
        });

        return response()->json(['success' => true]);
    }
}
