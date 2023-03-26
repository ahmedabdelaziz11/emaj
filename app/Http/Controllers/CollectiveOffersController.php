<?php

namespace App\Http\Controllers;

use App\Models\clients;
use App\Models\CollectiveOffer;
use App\Models\CollectiveOffersInvoice;
use App\Models\invoices;
use Illuminate\Http\Request;

class CollectiveOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('collective-offers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoices = invoices::all();
        $clients  = clients::all();
        return view('collective-offers.create',compact('clients','invoices')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $CollectiveOffer = CollectiveOffer::create([
            'name' => $request->name,
            'date' => $request->date,
            'discount' => $request->discount,
            'value_added' => $request->value_add,
            'client_id' => $request->client_id,
        ]);

        foreach($request->invoices as $key => $value)
        {
            CollectiveOffersInvoice::create([
                'offer_id' => $CollectiveOffer->id,
                'invoice_id' => $value,
            ]);
        }

        session()->flash('mss','تم اضافة العرض بنجاج');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = CollectiveOffer::find($id);
        $invoice_ids = CollectiveOffersInvoice::where('offer_id',$id)->pluck('invoice_id');
        $invoices = invoices::whereIn('id',$invoice_ids)->get();
        return view('collective-offers.show',compact('offer','invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        CollectiveOffer::find($request->id)->delete();
        session()->flash('delete','تم حذق العرض بنجاج');
        return back();
    }
}
