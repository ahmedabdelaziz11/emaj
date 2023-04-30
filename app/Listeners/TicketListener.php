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
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        $ticket = $event->ticket;
        $formData = $event->formData;
        $this->handleTicketLog($ticket);
        $this->handleTicketDetails($ticket, $formData);
        $this->handleTicketCompensation($ticket, $formData);
        $this->handleTicketEmployee($ticket, $formData);
    }

    private function handleTicketLog($ticket)
    {
        $this->ticketService->handleTicketLog($ticket);
    }

    private function handleTicketDetails($ticket, $formData)
    {
        $this->ticketService->handleTicketDetails($ticket, $formData);
    }

    public function handleTicketCompensation($ticket, $formData)
    {
        $this->ticketService->handleTicketCompensation($ticket, $formData);
    }

    public function handleTicketEmployee($ticket, $formData)
    {
        $this->ticketService->handleTicketEmployee($ticket, $formData);
    }
}
