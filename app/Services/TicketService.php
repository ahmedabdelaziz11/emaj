<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\CompensationType;

class TicketService
{
    public function store($formData)
    {
        $ticket = Ticket::create([
            'client_id' => $formData['client_id'],
            'reporter_id' => auth()->id(),
            'reporter_type' => 'user',
            'state' => 'pending',
            'date' => $formData['date'],
            'ticket_type' => $formData['ticket_type'],
            'address' => $formData['address'],
            // 'received_money' => $formData['received_money'],
            'recommended_path' => $formData['recommended_path'],
            // 'closing_note' => $formData['closing_note'],
            // 'invoice_product_id' => $formData['invoice_product_id'],
        ]);
        return $ticket;
    }

    public function update(Ticket $ticket, $formData)
    {
        $ticket->update($formData);
        return $ticket;
    }

    public function createTicketLog(Ticket $ticket, $action = 'created')
    {
        return $ticket->logs()->create(['state' => $action,
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

    public function getCompensationTypes()
    {
        return CompensationType::all();
    }
}
