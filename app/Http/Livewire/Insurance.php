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
    private $service;
    
    public function mount(InsuranceService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.insurance', [
            'insurances' => $this->service->getAllInsuranes(),
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
