<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Live;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $posts = Post::where('user_id', $user->id)
            ->where(function($query) {
                $query->whereNull('scheduled_at')
                      ->orWhere('scheduled_at', '<=', now());
            })
            ->latest()
            ->get();

        $lives = Live::where('user_id', $user->id)
            ->where('status', 'active')
            ->get();

        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $isFollowing = Auth::check() ? Auth::user()->isFollowing($user) : false;

        return view('profile', compact('user', 'posts', 'lives', 'followersCount', 'followingCount', 'isFollowing'));
    }

    public function toggleFollow(User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json(['error' => 'Você não pode seguir a si mesmo'], 403);
        }

        /** @var \App\Models\User $me */
        $me = Auth::user();

        if ($me->isFollowing($user)) {
            $me->following()->detach($user->id);
            $status = 'unfollowed';
        } else {
            $me->following()->attach($user->id);
            $status = 'followed';
            
            // Notify the user being followed
            try {
                $user->notify(new \App\Notifications\NewFollowerNotification($me->name, $me->username));
            } catch (\Exception $e) {
                \Log::error('Erro ao notificar novo seguidor: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => $status,
            'followers_count' => $user->followers()->count()
        ]);
    }
}
