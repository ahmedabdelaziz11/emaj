<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stocks = Stock::all();
        return view('orders.create',compact('stocks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $order = PurchaseOrder::create([
                'date' => $request->date,
                'details' => $request->details,
                'stock_id' => $request->stock_id,
                'created_by' => Auth::user()->name,
            ]);

            foreach($request->id as $index => $value)
            {
                OrderProduct::create([
                    'purchase_order_id' => $order->id,
                    'product_id'       => $value,
                    'quantity' => $request->quantity[$index],
                    'Purchasing_price' => $request->purchasing_price[$index],
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/orders/'.$order->id)->with('mss','تم اضافة طلب الشراء بنجاح');        
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $stocks = Stock::all();
        return view('orders.show',compact('purchaseOrder','stocks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        DB::beginTransaction();
        try
        {
            PurchaseOrder::find($request->order_id)->update([
                'date' => $request->date,
                'details' => $request->details,
                'stock_id' => $request->stock_id,
            ]);

            OrderProduct::where('purchase_order_id',$request->order_id)->delete();

            foreach($request->id as $index => $value)
            {
                OrderProduct::create([
                    'purchase_order_id' => $request->order_id,
                    'product_id'       => $value,
                    'quantity' => $request->quantity[$index],
                    'Purchasing_price' => $request->purchasing_price[$index],
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        session()->flash('mss','تم تعديل طلب الشراء بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrder  $purchaseOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        PurchaseOrder::find($request->id)->delete();
        session()->flash('del','تم حذ طلب الشراء بنجاح');
        return back();
    }

    public function getTotal($id)
    {
        $data = [];
        $data['stock_id'] = PurchaseOrder::find($id)->stock_id;
        $data['total'] = OrderProduct::where('purchase_order_id',$id)->select(DB::raw('sum(Purchasing_price	 * quantity) as total'))->value('total');
        return  $data ;
    }
}
