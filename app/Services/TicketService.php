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
}
