<?php

namespace App\Http\Livewire;

use App\Models\AllAccount;
use App\Services\TicketService;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class Ticket extends Component
{
    use WithPagination;

    public $currentPage = 1;
    public $client_id = '';
    public $from_date = '';
    public $to_date = '';
    public $state = '';
    private $service;
    

    public function render(TicketService $service)
    {
        $this->service = $service;
        return view('livewire.tickets', [
            'tickets' => $this->service->getAllTickets(
                $this->client_id,
                $this->from_date,
                $this->to_date,
                $this->state,
            ),
            'clients' => AllAccount::clients()->get(),
        ]);
    } 



    public function setPage($url)
    {
        $this->currentPage = explode('page=', $url)[1];
        Paginator::currentPageResolver(function(){
            return $this->currentPage;
        });
    }

}
