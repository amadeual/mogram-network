<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('user')->latest()->get();
        return view('admin.support.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('messages.user', 'user');
        return view('admin.support.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate(['message' => 'nullable|string']);

        if ($request->filled('message')) {
            TicketMessage::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'message' => $request->message
            ]);
        }

        $ticket->update([
            'status' => $request->status ?? 'Aguardando Resposta',
            'category' => $request->category ?? $ticket->category,
            'priority' => $request->priority ?? $ticket->priority,
            'assigned_to' => $request->assigned_to ?? $ticket->assigned_to
        ]);

        return back()->with('success', 'Resposta enviada com sucesso!');
    }
}
