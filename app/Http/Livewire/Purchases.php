<?php

namespace App\Http\Livewire;

use App\Models\PurchaseOrder;
use App\Models\receipts;
use Livewire\Component;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class Purchases extends Component
{
    use WithPagination;
    
    public $order_id = '' ;
    public $orderSearch = '' ;
    public $invoSearch = '' ;
    public $currentPageOrder = 1;
    public $currentPageReceipts = 1;
    public $page_num = null;

    public function render()
    {
        if($this->invoSearch != '' || $this->order_id != '')
        {
            $this->page_num = 5;
        }
        return view('livewire.purchases', [
            'receipts' => receipts::when($this->invoSearch,function($q,$invoSearch){
                $q->where('id',$this->invoSearch);
            })->when($this->order_id,function($q){
                $q->where('purchase_order_id',$this->order_id);
            })->orderBy('id','desc')->paginate(5)->setPageName("receipts"),

            'orders' => PurchaseOrder::where(function($query){
                $query->Where('details', 'like', '%'.$this->orderSearch.'%')
                ->orWhere('id', $this->orderSearch);
            })->orderBy('id','desc')->paginate(5)->setPageName("orders"),

            'page_num' => $this->page_num,
        ]);
    }

    public function setPage($url)
    {
        $orders = str_contains($url,'orders');
        if($orders)
        {
            $this->page_num = '';
            $this->currentPageOrder = explode('orders=', $url)[1];
            Paginator::currentPageResolver(function(){
                return $this->currentPageOrder;
            });
        }
        else
        {
            $this->page_num = 5;
            $this->currentPageReceipts = explode('receipts=', $url)[1];
            Paginator::currentPageResolver(function(){
                return $this->currentPageReceipts;
            });
        }

    }
}
