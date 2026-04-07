<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Live;
use App\Models\LiveChat;
use App\Models\Gift;
use App\Models\LiveGift;
use App\Models\LiveLike;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LiveStartedMail;

class LiveController extends Controller
{
    public function index(Request $request)
    {
        $onlineQuery = Live::where('status', 'online');
        $scheduledQuery = Live::where('status', 'scheduled');

        if ($request->has('category') && $request->category !== 'Explorar') {
            $onlineQuery->where('category', $request->category);
            $scheduledQuery->where('category', $request->category);
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
            'category' => 'nullable|string|max:100',
            'is_free' => 'required|boolean',
            'price' => 'nullable|numeric|min:0'
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('live_thumbnails', 'public');

        $live = Live::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category ?? 'Geral',
            'thumbnail' => $thumbnailPath,
            'is_free' => $request->is_free,
            'price' => $request->is_free ? 0 : $request->price,
            'status' => 'offline',
            'started_at' => now()
        ]);

        try {
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
        
        $topSupporters = LiveGift::where('live_id', $live->id)
            ->select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('user_id')
            ->orderBy('total_amount', 'desc')
            ->take(3)
            ->with('user')
            ->get();

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

        if ($live->thumbnail) {
            Storage::disk('public')->delete($live->thumbnail);
        }

        $live->delete();
        return response()->json(['success' => true]);
    }

    public function start(Live $live)
    {
        if (Auth::id() != $live->user_id) {
            return response()->json(['success' => false], 403);
        }

        $live->update(['status' => 'online']);
        return response()->json(['success' => true]);
    }

    public function togglePause(Request $request, Live $live)
    {
        if (Auth::id() != $live->user_id) {
            return response()->json(['success' => false], 403);
        }

        try {
            $live->update(['is_paused' => $request->paused]);
        } catch (\Exception $e) {
            // Check if column exists, if not, try to create it via SQL
            try {
                DB::statement("ALTER TABLE lives ADD COLUMN is_paused TINYINT(1) DEFAULT 0");
                $live->update(['is_paused' => $request->paused]);
            } catch (\Exception $e2) {
                return response()->json(['success' => false, 'error' => $e2->getMessage()]);
            }
        }
        
        return response()->json(['success' => true]);
    }

    public function status(Live $live)
    {
        return response()->json([
            'success' => true,
            'status' => $live->status,
            'viewer_count' => count($live->chats->unique('user_id')),
            'likes_count' => $live->likes()->count(),
            'is_paused' => (bool)$live->is_paused
        ]);
    }

    public function toggleLike(Live $live)
    {
        $like = LiveLike::where('user_id', Auth::id())
                        ->where('live_id', $live->id)
                        ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            LiveLike::create([
                'user_id' => Auth::id(),
                'live_id' => $live->id
            ]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $live->likes()->count()
        ]);
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
            $user->decrement('balance', $gift->price);
            $platformComm = $gift->price * 0.20;
            $creatorShare = $gift->price - $platformComm;
            $live->user->increment('balance', $creatorShare);

            LiveGift::create([
                'live_id' => $live->id,
                'user_id' => $user->id,
                'gift_id' => $gift->id,
                'amount' => $gift->price,
                'commission' => $platformComm
            ]);

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
