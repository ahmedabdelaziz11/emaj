<?php

namespace App\Http\Livewire;

use App\Services\InsuranceService;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class Insurance extends Component
{
    use WithPagination;

    public $currentPage = 1;
    public $product_name = '';
    public $client_name  = '';
    public $invoice_id   = '';
    public $start_date   = '';
    public $end_date     = '';
    private $service;
    

    public function render(InsuranceService $service)
    {
        $this->service = $service;
        return view('livewire.insurance', [
            'insurances' => $this->service->getAllInsuranes(
                $this->product_name,
                $this->client_name,
                $this->invoice_id,
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
