<?php

namespace App\Http\Controllers;

use App\Models\CompositeProduct;
use App\Models\CProduct;
use App\Models\Stock;
use Illuminate\Http\Request;

class CompositeProductsController extends Controller
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
        return view('composite-products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stocks = Stock::all();
        return view('composite-products.create',compact('stocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate(['name' => 'required|unique:composite_products|max:255'],['name.unique' =>'اسم المنتج مسجل مسبقا',]);

        $composite_product = CompositeProduct::create([
            'name' => $request->name,
            'description' => $request->description,
            'selling_price' => $request->selling_price,
            'stock_id' => $request->stock_id,
        ]);

        foreach($request->id as $key => $id)
        {
            CProduct::create([
                'composite_product_id' => $composite_product->id,
                'product_id' => $id,
                'quantity' => $request->quantity[$key],
            ]);
        }

        return redirect('composite-products/'.$composite_product->id)->with('mss',"تم اضافه المنتج");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $composite_product = CompositeProduct::find($id);
        $stocks = Stock::all();
        return view('composite-products.show',compact('stocks','composite_product'));
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
        // return $request;
        $composite_product = CompositeProduct::find($id);
        $composite_product->update([
            'name' => $request->name,
            'description' => $request->description,
            'selling_price' => $request->selling_price,
            'stock_id' => $request->stock_id,
        ]);

        CProduct::where('composite_product_id',$id)->delete();

        foreach($request->id as $key => $id)
        {

            CProduct::create([
                'composite_product_id' => $composite_product->id,
                'product_id' => $id,
                'quantity' => $request->quantity[$key],
            ]);
        }
        return redirect()->back()->with('mss',"تم التعديل المنتج");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        CompositeProduct::find($request->id)->delete();
        return redirect()->back()->with('del','تم الحذف بنجاح');
    }


    public function getAllByStock($stock_id)
    {
        $products = CompositeProduct::where('stock_id',$stock_id)->get();
        return json_encode($products);
    }
}
