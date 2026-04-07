<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContentPurchasedMail;

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

        // Get active stories from followed users + own
        $followingIds = auth()->user()->following()->pluck('users.id')->toArray();
        $followingIds[] = auth()->id();

        $activeStories = collect();
        if (\Illuminate\Support\Facades\Schema::hasTable('stories')) {
            $activeStories = \App\Models\Story::whereIn('user_id', $followingIds)
                ->where('expires_at', '>', now())
                ->with('user')
                ->get()
                ->groupBy('user_id');
        }

        return view('dashboard', compact('posts', 'activeStories'));
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
            'content' => 'required|string|max:255',
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

    public function unlockPost(Post $post)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if already purchased
        if ($post->isPurchasedBy($user)) {
            return response()->json(['success' => true, 'message' => 'Conteúdo já desbloqueado!']);
        }

        // Check balance
        if ($user->balance < $post->price) {
            return response()->json([
                'success' => false, 
                'error' => 'Saldo insuficiente!',
                'balance' => $user->balance,
                'price' => $post->price,
                'message' => 'Seu saldo atual é R$ ' . number_format($user->balance, 2, ',', '.') . '. Faça um depósito para desbloquear este conteúdo exclusivo.'
            ], 402);
        }

        // Process purchase
        try {
            \Illuminate\Support\Facades\DB::transaction(function() use ($user, $post) {
                // Debit buyer
                $user->decrement('balance', $post->price);
                
                // Credit seller (creator)
                $creator = $post->user;
                // Removed: $creator->increment('balance', $post->price); // Goes only to Finance ledger

                // Record purchase
                \App\Models\Purchase::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                    'amount' => $post->price
                ]);

                // Send email to buyer
                try {
                    Mail::to($user->email)->send(new ContentPurchasedMail($post->price));
                } catch (\Exception $e) {
                    \Log::error('Erro ao enviar email de compra: ' . $e->getMessage());
                }

                // Send email to creator (seller)
                try {
                    Mail::to($creator->email)->send(new \App\Mail\ContentSoldMail($post->price, $user->name, $post->title));
                } catch (\Exception $e) {
                    \Log::error('Erro ao enviar email de venda: ' . $e->getMessage());
                }
                // Notify creator
                try {
                    $creator->notify(new \App\Notifications\ContentSold($post->price, $user->name, $post->title));
                } catch (\Exception $e) {
                    \Log::error('Erro ao notificar venda de conteúdo: ' . $e->getMessage());
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Conteúdo desbloqueado com sucesso!',
                'new_balance' => $user->fresh()->balance
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Erro ao processar a compra. Tente novamente.'], 500);
        }
    }
}
