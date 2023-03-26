<?php

namespace App\Http\Livewire;

use App\Models\CollectiveOffer;
use App\Models\CompositeProduct;
use App\Models\products;
use App\Models\Stock;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class CollectiveOffers extends Component
{
    use WithPagination;

    public $name = '' ;
    public $clientName = null;
    public $from_date = null;
    public $to_date = null;
    public $currentPage = 1;



    public function render()
    {
        return view('livewire.collective-offers', [
            'offers' => CollectiveOffer::where(function($query){
                $query->where('name', 'like', '%'.$this->name.'%');
            })->when($this->clientName,function($q){
                $q->WhereHas('client',function($q){
                    $q->where('name','like','%'.$this->clientName.'%');
                });
            })->when($this->from_date,function($q){
                $q->where('date','>=',$this->from_date);
            })->when($this->to_date,function($q){
                $q->where('date','<=',$this->to_date);
            })->orderBy('id','desc')->paginate(15),
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
