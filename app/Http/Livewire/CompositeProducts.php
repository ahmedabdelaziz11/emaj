<?php

namespace App\Http\Livewire;

use App\Models\CompositeProduct;
use App\Models\products;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class CompositeProducts extends Component
{
    use WithPagination;

    public $search = '' ;
    public $currentPage = 1;
    public $selectedStock = null;


    public function render()
    {
        return view('livewire.composite-products', [
            'products' => CompositeProduct::where(function($query){
                $query->where('name', 'like', '%'.$this->search.'%');
            })->when($this->selectedStock,function($q){
                $q->where('stock_id',$this->selectedStock);
            })->orderBy('id','desc')->paginate(15),
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
