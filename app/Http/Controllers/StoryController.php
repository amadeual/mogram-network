<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryView;
use App\Models\Gift;
use App\Models\LiveGift;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function index()
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('stories')) {
            return redirect()->route('dashboard')->with('error', 'O sistema de stories está em manutenção.');
        }

        // Get active stories from followed users + own
        $followingIds = auth()->user()->following()->pluck('users.id')->toArray();
        $followingIds[] = auth()->id();

        $stories = Story::whereIn('user_id', $followingIds)
            ->where('expires_at', '>', now())
            ->with('user')
            ->latest()
            ->get();

        // removed the redirect to allow the menu to actually 'open' even if empty
        // return view('stories', compact('stories'));

        $gifts = Gift::all();
        return view('stories', compact('stories', 'gifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,mp4,mov|max:20480', // 20MB max
            'is_exclusive' => 'boolean',
            'price' => 'nullable|numeric|min:0',
        ]);

        $path = $request->file('file')->store('stories', 'public');
        $type = str_contains($request->file('file')->getMimeType(), 'video') ? 'video' : 'image';

        $story = Story::create([
            'user_id' => auth()->id(),
            'file_path' => $path,
            'type' => $type,
            'is_exclusive' => $request->is_exclusive ?? false,
            'price' => $request->price ?? 0.00,
            'expires_at' => now()->addHours(24),
        ]);

        return response()->json([
            'success' => true,
            'story' => $story
        ]);
    }

    public function markAsViewed(Story $story)
    {
        $viewed = StoryView::where('story_id', $story->id)
            ->where(function ($query) {
                $query->where('user_id', auth()->id())
                      ->orWhere('ip_address', request()->ip());
            })
            ->exists();

        if (!$viewed) {
            StoryView::create([
                'story_id' => $story->id,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function sendGift(Request $request, Story $story)
    {
        if ($story->user_id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Não é possível enviar mimos para seu próprio story.']);
        }

        $request->validate(['gift_id' => 'required|exists:gifts,id']);
        
        $user = auth()->user();
        $gift = Gift::find($request->gift_id);

        if ($user->balance < $gift->price) {
            return response()->json(['success' => false, 'message' => 'Saldo insuficiente']);
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($user, $gift, $story) {
            $user->decrement('balance', $gift->price);
            
            $platformComm = $gift->price * 0.20;
            $creatorShare = $gift->price - $platformComm;

            LiveGift::create([
                'user_id' => $user->id,
                'receiver_id' => $story->user_id,
                'gift_id' => $gift->id,
                'amount' => $gift->price,
                'commission' => $platformComm,
                'live_id' => null
            ]);

            // Notify via DM
            Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $story->user_id,
                'message' => "🌹 [Storie Mimo] Enviou um " . $gift->icon . " " . $gift->name . " no seu story!"
            ]);
        });

        return response()->json(['success' => true, 'balance' => number_format($user->balance, 2, ',', '.')]);
    }

    public function sendMessage(Request $request, Story $story)
    {
        if ($story->user_id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Não é possível responder seu próprio story.']);
        }

        $request->validate(['message' => 'required|string|max:1000']);
        
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $story->user_id,
            'message' => "[Storie Reply] " . $request->message
        ]);

        return response()->json(['success' => true]);
    }
}
