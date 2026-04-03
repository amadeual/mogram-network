<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'likes', 'comments.user', 'comments.replies.user'])
            ->where(function($query) {
                $query->whereNull('scheduled_at')
                      ->orWhere('scheduled_at', '<=', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard', compact('posts'));
    }

    public function toggleLike(Post $post)
    {
        $like = Like::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->first();

        if ($like) {
            $like->delete();
            $status = 'unliked';
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id
            ]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'likes_count' => $post->likes()->count()
        ]);
    }

    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        if ($request->ajax()) {
            return response()->json([
                'comment' => $comment->load('user'),
                'html' => view('partials.comment', ['comment' => $comment])->render()
            ]);
        }

        return back()->with('success', 'Comentário enviado!');
    }

    public function deleteComment(Comment $comment)
    {
        if (Auth::id() != $comment->user_id) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }

        if ($comment->created_at->diffInMinutes(now()) >= 5) {
            return response()->json(['error' => 'Tempo de exclusão expirado (5 min)'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}
