<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function download($id)
    {
        $post = Post::findOrFail($id);

        // Check if user has access
        $hasAccess = false;

        // Creators always have access to their own posts
        if (Auth::id() === $post->user_id) {
            $hasAccess = true;
        } 
        // Free content is accessible to all authenticated users
        elseif (!$post->is_exclusive) {
            $hasAccess = true;
        } 
        // Paid content checks for purchase
        else {
            $hasAccess = Purchase::where('user_id', Auth::id())
                ->where('post_id', $post->id)
                ->exists();
        }

        if (!$hasAccess) {
            return back()->with('error', 'Você precisa adquirir este conteúdo para fazer o download.');
        }

        // For this demo, we'll check if the file exists in public/storage
        $filePath = $post->file_path;
        
        if (!Storage::disk('public')->exists($filePath)) {
            // If it's a URL or doesn't exist, we'll mock a placeholder for now
            // In a real app, this would be a secure storage path
            return back()->with('error', 'O arquivo não foi encontrado no servidor.');
        }

        return Storage::disk('public')->download($filePath, $post->title . '.pdf');
    }
}
