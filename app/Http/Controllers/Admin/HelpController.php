<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class HelpController extends Controller
{
    public function index()
    {
        $articles = HelpArticle::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.help.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.help.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'description' => 'required',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('guides', 'public');
        }

        HelpArticle::create($data);

        return redirect()->route('admin.help.index')->with('success', 'Artigo de ajuda criado com sucesso!');
    }

    public function edit(HelpArticle $article)
    {
        return view('admin.help.edit', compact('article'));
    }

    public function update(Request $request, HelpArticle $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'description' => 'required',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('guides', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.help.index')->with('success', 'Artigo de ajuda atualizado com sucesso!');
    }

    public function destroy(HelpArticle $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return redirect()->route('admin.help.index')->with('success', 'Artigo de ajuda removido com sucesso!');
    }
}
