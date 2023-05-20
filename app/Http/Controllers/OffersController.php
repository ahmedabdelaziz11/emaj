<?php

namespace App\Http\Controllers;

use App\Models\offer_products;
use Illuminate\Support\Facades\DB;
use App\Models\clients;
use App\Models\OfferCompositeProducts;
use App\Models\offers;
use App\Models\OfferService;
use App\Models\products;
use App\Models\Stock;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('offers.offers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stocks = Stock::all();
        $tickets = Ticket::get('id');
        $clients  = clients::all();
        return view('offers.create',compact('clients','stocks','tickets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offer = offers::create([
            'name'       => $request->name,
            'name_en'    => $request->name_en,
            'date'       => $request->offer_Date,
            'constraints'      => $request->constraints,
            'constraints_en'   => $request->constraints_en,
            'discount'   => $request->discount,
            'value_added'=> $request->value_add,
            'client_id'  => $request->client_id,
            'stock_id'   => $request->stock_id,
            'ticket_id'   => $request->ticket_id,
            "Created_by" => Auth::user()->name,
        ]);

        if($request->id)
        {
            foreach ($request->id as $key => $value) 
            {                
                offer_products::create([
                    'offer_id'         => $offer->id,
                    'product_id'       => $value,
                    'product_quantity' => $request->quantity[$key],
                    'product_price'    => $request->selling_price[$key],
                ]);
            }
        }

        if($request->c_id)
        {
            foreach($request->c_id as $key => $value)
            {
                OfferCompositeProducts::create([
                    'offer_id' => $offer->id,
                    'coposite_product_id' => $value,
                    'selling_price' => $request->c_selling_price[$key],
                    'quantity' => $request->c_quantity[$key],
                ]);
            }
        }

        if($request->ser_desc)
        {
            foreach ($request->ser_desc as $key => $value) 
            {                
                OfferService::create([
                    'offer_id'         => $offer->id,
                    'details'       => $value,
                    'price'    => $request->ser_price[$key],
                ]);
            }
        }
        return redirect('/offers/'.$offer->id)->with('mss',"تم اضافه العرض");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer   = offers::find($id);
        $stocks = Stock::all();
        $clients  = clients::all();
        $tickets = Ticket::get('id');

        return view('offers.show',compact('offer','stocks','clients','tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        offers::find($request->offer_id)->update([
            'name' => $request->name,            
            'name_en' => $request->name_en,            
            'date' => $request->offer_Date,
            'constraints' => $request->constraints,
            'constraints_en' => $request->constraints_en,
            'discount' => $request->discount,
            'value_added'=> $request->value_add,
            'client_id' => $request->client_id,
            'stock_id' => $request->stock_id,
            'ticket_id'   => $request->ticket_id,
        ]);
        offer_products::where('offer_id',$request->offer_id)->delete();
        if($request->id)
        {
            foreach ($request->id as $key => $value) 
            {                
                offer_products::create([
                    'offer_id'         => $request->offer_id,
                    'product_id'       => $value,
                    'product_quantity' => $request->quantity[$key],
                    'product_price'    => $request->selling_price[$key],
                ]);
            }
        }
        OfferCompositeProducts::where('offer_id',$request->offer_id)->delete();
        if($request->c_id)
        {
            foreach($request->c_id as $key => $value)
            {
                OfferCompositeProducts::create([
                    'offer_id' => $request->offer_id,
                    'coposite_product_id' => $value,
                    'selling_price' => $request->c_selling_price[$key],
                    'quantity' => $request->c_quantity[$key],
                ]);
            }
        }

        OfferService::where('offer_id',$request->offer_id)->delete();
        if($request->ser_desc)
        {
            foreach ($request->ser_desc as $key => $value) 
            {                
                OfferService::create([
                    'offer_id'         => $request->offer_id,
                    'details'       => $value,
                    'price'    => $request->ser_price[$key],
                ]);
            }
        }

        session()->flash('mss','تم تعديل العرض بنجاج');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        offers::find($request->id)->delete();
        session()->flash('delete','تم حذف العرض بنجاح');
        return back();
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("name", "id");
        return json_encode($products);
    }

    public function getOffer($stockId)
    {
        return offers::where('stock_id',$stockId)->pluck('id');
    }

    public function getTicketOffers($ticket_id)
    {
        return offers::where('ticket_id',$ticket_id)->pluck('id');
    }
}
