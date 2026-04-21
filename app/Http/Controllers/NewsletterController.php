<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email'
        ], [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um e-mail válido.',
            'email.unique' => 'Este e-mail já está inscrito em nossa newsletter.'
        ]);

        NewsletterSubscription::create([
            'email' => $request->email
        ]);

        return back()->with('success', 'Inscrição realizada com sucesso! Fique atento às novidades.');
    }

    public function index()
    {
        $subscriptions = NewsletterSubscription::latest()->paginate(20);
        return view('admin.newsletter.index', compact('subscriptions'));
    }
}
