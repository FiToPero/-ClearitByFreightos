<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Notifications\NewTicketNotification;
use Inertia\Inertia;
use App\Models\User;

class TicketController extends Controller
{
    public function create()
    {
        $this->authorize('user', User::class);

        return Inertia::render('Ticket-User');
    }

    public function edit()
    {
        $this->authorize('agent', User::class);
        $tickets = Ticket::with(['user', 'messages'])->get();

        return Inertia::render('Ticket-Agent', [
            'tickets' => $tickets,
        ]);

    }

    public function show()
    {
        $this->authorize('user', User::class);
        $tickets = Ticket::with(['user', 'messages'])->get();

        return Inertia::render('Ticket-user-All', [
            'tickets' => $tickets,
        ]);
    }

    public function store(TicketRequest $request)
    {   
        $attachmentUrl = null;
        if ($request->hasFile('attachment')) {
            $attachmentUrl = $request->attachment->store('public/attachments');
            $attachmentUrl = str_replace('public', 'storage', $attachmentUrl);
        }
 
    try{
        $ticket = Ticket::create([
        'user_id' => $request->user_id,
        'name' => $request->name,
        'type' => $request->type,
        'transport_mode' => $request->transport_mode,
        'product' => $request->product,
        'origin_country' => $request->origin_country,
        'destination_country' => $request->destination_country,
        'status' => $request->status,
    ]);
        $ticket->messages()->create([
            'content' => $request->content,
            'message_type' => 'user', // user, agent
            'is_read' => null,
            'attachment' => $attachmentUrl,
        ]);

        $ticket->user->notify(new NewTicketNotification($ticket));


    return redirect()->route('ticket.user')->with(['message' => 'Ticket created successfully!', 'color' => 'green']);
    } catch (\Exception $e) {
        return redirect()->route('ticket.user')->with(['message' => 'Error creating ticket', 'color' => 'red']);
    }

    }

    public function updateAgent($id, $status)
    {
        
        $this->authorize('agent', User::class);
        
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->update([
                'status' => $status,
            ]);

            $ticket->user->notify(new NewTicketNotification($ticket));

            return redirect()->route('ticket.agent')->with(['success' => 'Message sent successfully.', 'color' => 'green']);
        
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => 'Failed to send message', 'color' => 'red']);
        }
    }

    public function updateUser($id, $status)
    {
        
        $this->authorize('user', User::class);
        
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->update([
                'status' => $status,
            ]);

            $ticket->user->notify(new NewTicketNotification($ticket));

            return redirect()->route('ticket.user')->with(['success' => 'Message sent successfully.', 'color' => 'green']);
        
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => 'Failed to send message', 'color' => 'red']);
        }
    }
}
