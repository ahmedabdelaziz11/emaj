<?php

namespace App\Listeners;

use App\Events\TicketUpdated;
use App\Services\TicketService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdatingTicketListener
{
    protected $ticketService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TicketUpdated  $event
     * @return void
     */
    public function handle(TicketUpdated $event)
    {
        $ticket = $event->ticket;
        $this->createTicketLog($ticket)
    }

    public function createTicketLog($ticket)
    {
        $this->ticketService->createTicketLog($ticket, 'Updated');
    }
}
