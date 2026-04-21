<?php

namespace App\Http\Controllers;

use App\Models\HelpArticle;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $articles = HelpArticle::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('help.index', compact('articles'));
    }
}
