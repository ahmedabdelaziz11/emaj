<?php

namespace App\Http\Livewire;

use App\Models\offers as ModelsOffers;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class Offers extends Component
{
    use WithPagination;

    public $search = '' ;
    public $from_date = '' ;
    public $to_date = '' ;
    public $currentPage = 1;
    public $selectedStock = null;

    public function render()
    {
        return view('livewire.offers', [
            'offers' => ModelsOffers::where(function($query){
                $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('id', $this->search)
                ->orWhereHas('client',function($q){
                    $q->where('client_name','like','%'.$this->search.'%');
                });
            })->when($this->selectedStock,function($q,$stock_id){
                $q->whereHas('stock' , function($q){
                    $q->where('stock_id', '=', $this->selectedStock);
                });
            })->when($this->from_date,function($q){
                $q->where('date','>=',$this->from_date);
            })->when($this->to_date,function($q){
                $q->where('date','<=',$this->to_date);
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
