<?php

namespace App\Http\Livewire;

use App\Models\spares;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;


class SparesPagination extends Component
{
    use WithPagination;

    public $search = '';
    public $currentPage = 1;


    public function render()
    {
        return view('livewire.spares-pagination', [
            'spares' => spares::where(function($query){
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
