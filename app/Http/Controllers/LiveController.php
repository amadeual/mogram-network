<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Live;
use App\Models\LiveChat;
use App\Models\Gift;
use App\Models\LiveGift;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LiveStartedMail;

class LiveController extends Controller
{
    public function index()
    {
        $cutoffDate = '2026-04-03 21:00:00';
        $demoUserIds = [1, 2];
        
        $onlineQuery = Live::where('status', 'online');
        $scheduledQuery = Live::where('status', 'scheduled');

        // Check if user is "new" (registered after the cutoff)
        if (Auth::check() && Auth::user()->created_at->isAfter($cutoffDate)) {
            $onlineQuery->whereNotIn('user_id', $demoUserIds);
            $scheduledQuery->whereNotIn('user_id', $demoUserIds);
        }

        $onlineLives = $onlineQuery->latest()->get();
        $scheduledLives = $scheduledQuery->latest()->get();
        
        return view('lives', compact('onlineLives', 'scheduledLives'));
    }

    public function create()
    {
        return view('create-live');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'thumbnail' => 'required|image|max:2048',
            'is_free' => 'required|boolean',
            'price' => 'nullable|numeric|min:0'
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('live_thumbnails', 'public');

        $live = Live::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'is_free' => $request->is_free,
            'price' => $request->is_free ? 0 : $request->price,
            'status' => 'online',
            'started_at' => now()
        ]);

        try {
            // Ideally this would go to followers. As a placeholder/test, send to creator
            Mail::to(Auth::user()->email)->send(new LiveStartedMail($live));
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar email de inicio de live: ' . $e->getMessage());
        }

        return redirect()->route('live.watch', $live->id);
    }

    public function watch(Live $live)
    {
        $messages = LiveChat::where('live_id', $live->id)->with('user')->latest()->take(50)->get()->reverse();
        $gifts = Gift::orderBy('price', 'asc')->get();
        
        // Dynamic Top Supporters
        $topSupporters = LiveGift::where('live_id', $live->id)
            ->select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('user_id')
            ->orderBy('total_amount', 'desc')
            ->take(3)
            ->with('user')
            ->get();

        // Suggested Channels (Online Lives)
        $suggestedChannels = Live::where('status', 'online')
            ->where('id', '!=', $live->id)
            ->with(['user', 'chats'])
            ->take(3)
            ->get();

        return view('live-stream', compact('live', 'messages', 'gifts', 'topSupporters', 'suggestedChannels'));
    }

    public function destroy(Live $live)
    {
        if (Auth::id() != $live->user_id) {
            return response()->json(['success' => false, 'message' => 'Não autorizado'], 403);
        }

        // Cleanup files
        if ($live->thumbnail) {
            Storage::disk('public')->delete($live->thumbnail);
        }

        // Chat messages and gifts are cascade deleted by DB if set, otherwise do it here
        $live->delete();

        return response()->json(['success' => true]);
    }

    public function sendMessage(Request $request, Live $live)
    {
        $request->validate(['message' => 'required|string|max:500']);

        $chat = LiveChat::create([
            'live_id' => $live->id,
            'user_id' => Auth::id(),
            'message' => $request->message
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('partials.chat-message', ['message' => $chat, 'live' => $live])->render()
            ]);
        }

        return back();
    }

    public function sendGift(Request $request, Live $live)
    {
        $request->validate(['gift_id' => 'required|exists:gifts,id']);
        
        $user = Auth::user();
        $gift = Gift::find($request->gift_id);

        if ($user->balance < $gift->price) {
            return response()->json(['success' => false, 'message' => 'Saldo insuficiente']);
        }

        DB::transaction(function () use ($user, $gift, $live) {
            // Deduct from user
            $user->decrement('balance', $gift->price);

            // Calculate commission (e.g., 20% for platform, 80% for creator)
            $platformComm = $gift->price * 0.20;
            $creatorShare = $gift->price - $platformComm;

            // Add to creator
            $live->user->increment('balance', $creatorShare);

            // Record gift
            LiveGift::create([
                'live_id' => $live->id,
                'user_id' => $user->id,
                'gift_id' => $gift->id,
                'amount' => $gift->price,
                'commission' => $platformComm
            ]);

            // Add system message to chat
            $chat = LiveChat::create([
                'live_id' => $live->id,
                'user_id' => $user->id,
                'message' => "enviou " . $gift->icon . " " . $gift->name . "!"
            ]);
        });

        return response()->json(['success' => true, 'balance' => number_format($user->balance, 2, ',', '.')]);
    }

    public function getMessages(Live $live)
    {
        $messages = LiveChat::where('live_id', $live->id)->with('user')->latest()->take(50)->get()->reverse();
        $html = '';
        foreach($messages as $msg) {
            $html .= view('partials.chat-message', ['message' => $msg, 'live' => $live])->render();
        }
        return response()->json(['success' => true, 'html' => $html]);
    }
}
