<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\User;

class ExploreController extends Controller
{
    public function feed()
    {
        // Get public posts or trending posts
        $posts = Post::where('is_exclusive', false)
            ->with(['user', 'media'])
            ->latest()
            ->paginate(12);
            
        return view('explore.feed', compact('posts'));
    }

    public function creators()
    {
        // Get users who are active creators
        $creators = User::whereNotNull('username')
            ->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->latest()
            ->paginate(16);
            
        return view('explore.creators', compact('creators'));
    }
}
