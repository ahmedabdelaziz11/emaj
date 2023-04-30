<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function store($formData)
    {
        $ticket = Ticket::create($formData);
    }

    public function handleTicketLog(Ticket $ticket)
    {
        return $ticket->logs()->create([
            'state' => 'created',
            'actor_type' => 'user',
            'actor_id' => auth()->id(),
        ]);
    }

    public function handleTicketDetails(Ticket $ticket, $formData)
    {
        $ticket->details()->createMany($formData['details']);
    }

    public function handleTicketCompensation(Ticket $ticket, $formData)
    {
        $ticket->compensationType()->attach($formData['compensation_type_id'], ['amount' => $formData['amount']]);
    }

    public function handleTicketEmployee(Ticket $ticket, $formData)
    {
        $ticket->employees()->createMany($formData['employees'], ['date' => now()]);
    }

    public function getAllTickets($client_id = null, $date = null)
    {
        return Ticket::when($client_id,function($q,$client_id){
            $q->where('client_id',$client_id);
        })
        ->when($date,function($q,$date){
            $q->where('date',$date);
        })
        ->paginate(15);
    }
}
