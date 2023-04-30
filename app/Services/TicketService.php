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

    public function getAllTickets($client_id = null, $from_date = null,$to_date = null)
    {
        return Ticket::when($client_id,function($q,$client_id){
            $q->where('client_id',$client_id);
        })
        ->when($from_date,function($q,$from_date){
            $q->where('date','<=',$from_date);
        })
        ->when($to_date,function($q,$to_date){
            $q->where('date','>=',$to_date);
        })
        ->paginate(15);
    }
}
