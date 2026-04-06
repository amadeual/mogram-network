<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return response()->json(['users' => []]);
        }

        // Clean query if it starts with @
        $searchQuery = ltrim($query, '@');

        $users = User::where('name', 'LIKE', "%{$searchQuery}%")
            ->orWhere('username', 'LIKE', "%{$searchQuery}%")
            ->take(10)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'avatar' => $user->avatar ? Storage::url($user->avatar) : "https://api.dicebear.com/7.x/initials/svg?seed={$user->name}",
                    'profile_url' => route('creator.profile', $user->username),
                    'is_verified' => $user->is_verified,
                    'is_following' => Auth::check() ? Auth::user()->isFollowing($user) : false
                ];
            });

        return response()->json(['users' => $users]);
    }
}
