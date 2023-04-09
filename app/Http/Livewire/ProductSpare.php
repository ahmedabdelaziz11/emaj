<?php

namespace App\Http\Livewire;

use App\Models\Stock;
use App\Services\ProductService;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class ProductSpare extends Component
{
    use WithPagination;

    public $search = '' ;
    public $selectedStock = null;
    public $currentPage = 1;
    private $service;
    
    public function mount(ProductService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.product-spare', [
            'products' => $this->service->getAllProductSpare($this->search,$this->selectedStock),
            'stocks' => Stock::all(),
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
