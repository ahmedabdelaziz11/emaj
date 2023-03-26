<?php

namespace App\Http\Controllers;

use App\Models\offer_products;
use App\Models\offers;
use App\Models\clients;
use App\Models\products;
use Illuminate\Http\Request;

class OfferProductsController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $offer_id = $request->offer_id;
        Offer_products::create([
            'offer_id' => $request->offer_id,
            'product_id' => $request->id,
            'product_price' => $request->product_price,
            'product_quantity' => $request->product_quantity,
        ]);
        $products  = products::all();
        return view('offers.add_products',compact('products','offer_id'));    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\offer_products  $offer_products
     * @return \Illuminate\Http\Response
     */
    public function show(offer_products $offer_products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\offer_products  $offer_products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offers    = offers::where('id',$id)->first();
        $details   = offer_products::where('offer_id',$id)->get();
        $products  = products::all();
        $clients   = clients::all();
        return view('offers.details_offer',compact('offers','details','products','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\offer_products  $offer_products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $validatedData = $request->validate(
            [
                'product_quantity' => 'required|numeric|gt:0',
                'product_price'    => 'required|numeric|gt:0'
            ],
            [
                'product_quantity.gt' =>'يرجي ادخال كمية ',
                'product_price.gt'    =>'يرجي ادخال سعر ',
            ]
        );
        $product = offer_products::where('offer_id',$request->id)->where('product_id',$request->product_id); 
        $product->update([
            'product_quantity' => $request->product_quantity,
            'product_price'    => $request->product_price,
        ]);
        session()->flash('edit','تم تعديل المنتج بنجاج');
        return back();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\offer_products  $offer_products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $product = offer_products::where('offer_id',$request->offer_id)->where('product_id',$request->product_id)->delete();        
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return back();
    }

    public function add_product(Request $request)
    {
        if($request->id)
        {
            $offer_id = $request->offer_id;
            $ids=$request->id; // ids of products
            $quantities = $request->quantity;
            $selling_prices = $request->selling_price;
            $product_faild = 0;
            foreach ($ids as $key => $value) 
            {
                $product = offer_products::where('offer_id',$request->offer_id)->where('product_id',$value)->get();
                $x = count($product);
                if($x == 0){
                    offer_products::create([
                        'offer_id'         => $offer_id,
                        'product_id'       => $value,
                        'product_quantity' => $quantities[$key],
                        'product_price'    => $selling_prices[$key],
                    ]); 
                }
                else
                {
                    $product_faild ++; 
                }   
            }
        }
        if($product_faild == 0){
            session()->flash('Add', 'تم اضافة المنتجات بنجاح ');
        }
        else
        {
            session()->flash('Add', ' تم اضافة المنتج بنجاح باستثناء المنتجات الموجوده فى العرض');
        }
        
        return back();
    }
}
