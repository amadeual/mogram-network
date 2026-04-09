<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\StoryView;
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

        return view('stories', compact('stories'));
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
}
