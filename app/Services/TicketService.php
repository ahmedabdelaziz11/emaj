<?php

namespace App\Services;

use App\Models\Ticket;

class TicketService
{
    public function store($formData)
    {
        $ticket = Ticket::create($formData);
        return $ticket;
    }

    public function createTicketLog(Ticket $ticket)
    {
        return $ticket->logs()->create([
            'state' => 'created',
            'actor_type' => 'user',
            'actor_id' => auth()->id(),
        ]);
    }

    public function createTicketDetails(Ticket $ticket, $formData)
    {
        $ticket->details()->createMany($formData['details']);
    }

    public function createTicketCompensation(Ticket $ticket, $formData)
    {
        $ticket->compensationType()->attach($formData['compensation_type_id'], ['amount' => $formData['amount']]);
    }

    public function createTicketEmployee(Ticket $ticket, $formData)
    {
        $ticket->employees()->createMany($formData['employees'], ['date' => now()]);
    }
}
