<?php

namespace App\Http\Controllers;

use App\Models\offer_products;
use App\Models\offers;
use App\Models\Stock;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    public function index()
    {
        $pending_count =  Ticket::pendingTicketCount();
        $in_progress_count =  Ticket::inProgressTicketCount();
        $closed_count =  Ticket::closedTicketCount();
        $stock_id = Stock::where('name','قطع الغيار')->first()->id;
        $products =  offer_products::whereHas('offer',function($q)use($stock_id){
            $q->where('stock_id',$stock_id);
        })
        ->select('product_id',DB::raw('count(*) as count'))
        ->groupBy('product_id')
        ->orderBy('count','desc')
        ->limit(10)
        ->get();
        return view('crm.index',compact('pending_count','in_progress_count','closed_count','products'));
    }
}
