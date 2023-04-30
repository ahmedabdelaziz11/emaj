<?php

namespace App\Listeners;

use App\Events\TicketCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TicketListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TicketCreated $event)
    {
        $this->handleTicketLog($event);
        $this->handleTicketDetails($event);
        $this->handleTicketCompensation($event);
        $this->handleTicketEmployee($event);
    }

    private function handleTicketLog($event)
    {
        dd($event);
    }

    private function handleTicketDetails($event)
    {
        dd($event);
    }

    public function handleTicketCompensation($event)
    {
        dd($event);
    }

    public function handleTicketEmployee($event)
    {
        dd($event);
    }
}
