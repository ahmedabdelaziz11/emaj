<?php

namespace App\Http\Livewire;

use App\Models\Asset;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class AssetManagement extends Component
{
    use WithPagination;

    public $name = null;
    public $parentAccount = null;
    public $from_date = null;
    public $to_date = null;
    public $currentPage = 1;



    public function render()
    {

        return view('livewire.asset-management', [
            'assets' => Asset::when($this->name,function($q){
                $q->whereHas('account',function($q){
                    $q->where('name','like','%'.$this->name.'%');
                });
            })->when($this->parentAccount,function($q){
                $q->WhereHas('account',function($q){
                    $q->where('parent_id',$this->parentAccount);
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
