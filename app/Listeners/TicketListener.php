<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use App\Services\TicketService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TicketListener
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
     * create the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        $ticket = $event->ticket;
        $formData = $event->formData;
        $this->createTicketLog($ticket);
        $this->createTicketDetails($ticket, $formData);
        // $this->createTicketCompensation($ticket, $formData);
        // $this->createTicketEmployee($ticket, $formData);
    }

    private function createTicketLog($ticket)
    {
        $this->ticketService->createTicketLog($ticket);
    }

    private function createTicketDetails($ticket, $formData)
    {
        $this->ticketService->createTicketDetails($ticket, $formData);
    }

    public function createTicketCompensation($ticket, $formData)
    {
        $this->ticketService->createTicketCompensation($ticket, $formData);
    }

    public function createTicketEmployee($ticket, $formData)
    {
        $this->ticketService->createTicketEmployee($ticket, $formData);
    }
}
