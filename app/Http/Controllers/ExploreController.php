<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExploreController extends Controller
{
    public function feed()
    {
        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('explore.feed', compact('posts'));
    }

    public function creators(Request $request)
    {
        $query = User::where('role', '!=', 'admin')->withCount('followers');

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('username', 'LIKE', "%{$request->search}%");
            });
        }

        $creators = $query->orderBy('followers_count', 'desc')->paginate(16);
        $categories = User::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');

        return view('explore.creators', compact('creators', 'categories'));
    }
}
