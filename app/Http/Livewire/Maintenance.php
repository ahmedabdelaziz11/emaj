<?php

namespace App\Http\Livewire;

use App\Services\MaintenanceContractService;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class Maintenance extends Component
{
    use WithPagination;

    public $currentPage = 1;
    public $product_name = '';
    public $client_name  = '';
    public $invoice_id   = '';
    public $start_date   = '';
    public $end_date     = '';
    private $service;
    

    public function render(MaintenanceContractService $service)
    {
        $this->service = $service;
        return view('livewire.maintenance', [
            'maintenance_contracts' => $this->service->getAllMaintenanceContract(
                $this->product_name,
                $this->client_name,
                $this->start_date,
                $this->end_date,
            ),
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
