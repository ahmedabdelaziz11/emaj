<?php

namespace App\Http\Livewire;

use App\Models\products;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class ShowPosts extends Component
{
    use WithPagination;

    public $search = '' ;
    public $currentPage = 1;
    public $selectedStock = null;


    public function render()
    {
        return view('livewire.show-posts', [
            'products' => products::where(function($query){
                $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('name_en', 'like', '%'.$this->search.'%')
                ->orWhere('id', $this->search);
            })->when($this->selectedStock,function($q,$stock_id){
                $q->whereHas('stock' , function($q){
                    $q->where('stock_id', '=', $this->selectedStock);
                });
            })->paginate(15),
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
