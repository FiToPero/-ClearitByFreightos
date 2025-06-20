<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Ticket;
use App\Notifications\NewMessageNotification;
use App\Http\Requests\MessageRequest;
use App\Models\Message;

class MessageController extends Controller
{
    public function createUser($ticketId)
    {
        $this->authorize('user', User::class);

        return Inertia::render('Message-Form', [
            'ticketId' => $ticketId,
            'user' => 'user',
        ]);
    }

    public function createAgent($ticketId)
    {
        $this->authorize('agent', User::class);

        return Inertia::render('Message-Form', [
            'ticketId' => $ticketId,
            'user' => 'agent',
        ]);
    }

    public function store(MessageRequest $request)
    {
        $this->authorize($request->type, User::class);
        
        $attachmentUrl = null;
        if ($request->hasFile('attachment')) {
            $attachmentUrl = $request->attachment->store('public/attachments');
            $attachmentUrl = str_replace('public', 'storage', $attachmentUrl);
        }

       try {
            $ticket = Ticket::findOrFail($request->ticket_id);
            $message = $ticket->messages()->create([
                'content' => $request->content,
                'type' => $request->type,
                'is_read' => null,
                'attachment' => $attachmentUrl,
            ]);

            $ticket->user->notify(new NewMessageNotification($message));


            return redirect()->route('ticket.'.$request->type)->with(['success' => 'Message sent successfully.', 'color' => 'green']);
        
       } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Failed to send message', 'color' => 'red']);
       }
    }

    public function updateAgent($id)
    {
        $this->authorize('agent', User::class);
        
        try {
            $message = Message::findOrFail($id);
            $message->update([
                'is_read' => now(),
            ]);

            $message->ticket->user->notify(new NewMessageNotification($message));

            return redirect()->route('ticket.agent')->with(['success' => 'Message sent successfully.', 'color' => 'green']);
        
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => 'Failed to send message', 'color' => 'red']);
        }
    }

    public function updateUser($id)
    {
        $this->authorize('User', User::class);
        
        try {
            $message = Message::findOrFail($id);
            $message->update([
                'is_read' => now(),
            ]);

            $message->ticket->user->notify(new NewMessageNotification($message));

            return redirect()->route('ticket.user')->with(['success' => 'Message sent successfully.', 'color' => 'green']);
        
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => 'Failed to send message', 'color' => 'red']);
        }
    }

    

}
