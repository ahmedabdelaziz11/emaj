<?php

namespace App\Http\Livewire;

use App\Models\products;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class StockProducts extends Component
{
    use WithPagination;

    public $search = '' ;
    public $currentPage = 1;


    public function render()
    {
        return view('livewire.stock-products', [
            'products' => products::where(function($query){
                $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('name_en', 'like', '%'.$this->search.'%')
                ->orWhere('id', $this->search);
            })->paginate(15),
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
