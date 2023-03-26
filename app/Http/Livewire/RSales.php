<?php

namespace App\Http\Livewire;

use App\Models\invoices;
use App\Models\returned_invoice;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class RSales extends Component
{
    use WithPagination;

    public $search = '' ;
    public $selectedStock = null;
    public $currentPage = 1;

    public function render()
    {
        return view('livewire.r-sales', [
            'invoices' => returned_invoice::where(function($query){
                $query->where('id', $this->search)
                ->orWhere('id', $this->search)
                ->orWhereHas('client',function($q){
                    $q->where('name','like','%'.$this->search.'%');
                });
            })->when($this->selectedStock,function($q,$stock_id){
                $q->whereHas('stock' , function($q){
                    $q->where('stock_id', '=', $this->selectedStock);
                });
            })->orderBy('id', 'desc')->paginate(15),
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
