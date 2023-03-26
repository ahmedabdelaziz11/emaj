<?php

namespace App\Http\Controllers;

use App\Models\receipts;
use App\Models\products;
use App\Models\AllAccount;
use App\Models\Cost;
use App\Models\day;
use App\Models\DayDetails;
use App\Models\OrderProduct;
use App\Models\PurchaseOrder;
use App\Models\receipt_products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceiptsController extends Controller
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
        return view('receipts.receipts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers  = AllAccount::suppliers()->get();
        $accounts = AllAccount::banking()->get();
        $orders  = PurchaseOrder::all();
        $costs = Cost::all();
        return view('receipts.create_receipt',compact('accounts','orders','costs','suppliers'));
    }

    public function createPermission()
    {
        $receipts = receipts::where('type',0)->orderBy('id','desc')->get();
        return view('receipts.create-permission',compact('receipts'));
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
        try{
            $receipt = receipts::create([
                'date'         => $request->date,
                'total'        => $request->total,
                'discount'     => $request->discount,
                'sub_total'    => $request->sub_total,
                'amount_paid'  => $request->amount_paid,
                'supplier_id'  => $request->supplier_id,
                'cost_id'      => $request->cost_id ? $request->cost_id : null ,
                'account_id'   => $request->account_id ? $request->account_id : null,  
                "stock_id"     => $request->stock_id,
                "purchase_order_id" => $request->order_id,
                "value_added"  => $request->value_add,
                "type"         => 0,
                "Created_by"   => Auth::user()->name,
            ]);

            $products = OrderProduct::where('purchase_order_id',$request->order_id)->get();
            foreach ($products as $product) 
            {                
                receipt_products::create([
                    'receipt_id'       => $receipt->id,
                    'product_id'       => $product->product_id,
                    'product_quantity' => $product->quantity,
                    'product_Purchasing_price' => $product->Purchasing_price,
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/ReceiptDetails/'.$receipt->id)->with('mss',"تم اضافه الفاتورة");        
    }

    public function show($id)
    {
        return $receipt = receipts::find($id)->prodcuts;
    }

    public function permissionAdd (Request $request)
    {
        DB::beginTransaction();
        try{
            $receipt = receipts::find($request->receipt_id);

            $products = receipt_products::where('receipt_id',$receipt->id)->get();
            foreach($products as $product)
            {
                $productInStock = products::find($product->product_id);
                $total_old = $productInStock->quantity * $productInStock->Purchasing_price ;
                $total = $product->product_quantity * $product->product_Purchasing_price;
                $total_new = $total + $total_old ;              
                $productInStock->quantity = $productInStock->quantity + $product->product_quantity;
                if($productInStock->quantity  > 0 )
                {
                    $productInStock->Purchasing_price = $total_new / $productInStock->quantity ;
                }
                $productInStock->update();
            }

            $day = day::create([
                'date' => $receipt->date,
                'note' => "فاتورة مشتريات رقم " . " " . $receipt->id,
                'type' => 1,
                'type_name' => 'مشتريات (منتجات)',
                'type_id' => $receipt->id,
                'total' => $receipt->total + $receipt->amount_paid,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);

            $receipt->update([
                'day_id' => $day->id,
                'type' => 1,
                'date_add' => $request->date,
                'p_num' => $request->p_num,
            ]);
            //حساب مخزون  
            DayDetails::create([
                'date' => $receipt->date,
                'day_id' => $day->id,
                'account_id' => $receipt->stock->account_id,
                'debit' => $receipt->sub_total,
                'credit' => 0,
                'note' => "فاتورة مشتريات رقم " . " " . $receipt->id,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);
            // الضرائب
            if($receipt->value_added == 1)
            {
                DayDetails::create([
                    'date' => $receipt->date,
                    'day_id' => $day->id,
                    'account_id' => 45,
                    'debit' => $receipt->sub_total * .14,
                    'credit' => 0,
                    'note' => " ضريبة القيمة المضافة لفاتورة مشتريات رقم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }
            // الخصم المكتسب
            if($receipt->discount > 0)
            {
                DayDetails::create([
                    'date' => $receipt->date,
                    'day_id' => $day->id,
                    'account_id' => 112,
                    'debit' => 0,
                    'credit' => $receipt->discount,
                    'note' => " الخصم المكتسب لفاتورة مشتريات رقم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }

            //  المصاريف
            if($receipt->additions > 0)
            {
                DayDetails::create([
                    'date' => $receipt->date,
                    'day_id' => $day->id,
                    'account_id' => 110,
                    'debit' => $receipt->additions,
                    'credit' => 0,
                    'note' => "   مصاريف فاتورة مشتريات رقم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }

            // المورد
            DayDetails::create([
                'date' => $receipt->date,
                'day_id' => $day->id,
                'account_id' => $receipt->supplier->id,
                'debit' => 0,
                'credit' => $receipt->total,
                'note' => "فاتورة مشتريات رقم" . " " . $receipt->id,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);

            if($receipt->amount_paid > 0 && $receipt->account_id != null)
            {
                DayDetails::create([
                    'date' => $receipt->date,
                    'day_id' => $day->id,
                    'account_id' => $receipt->supplier->id,
                    'debit' => $receipt->amount_paid,
                    'credit' => 0,
                    'note' => " مدفوعات فاتورة مشتريات رقم " . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
                DayDetails::create([
                    'date' => $receipt->date,
                    'day_id' => $day->id,
                    'account_id' => $receipt->account_id,
                    'debit' => 0,
                    'credit' =>$receipt->amount_paid,
                    'note' => " مدفوعات فاتورة مشتريات رقم" . " " . $receipt->id,
                    'cost_id' => $request->cost_id ? $request->cost_id : null ,
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        session()->flash('mss','تم تنفيذ الطلب');
        return back();   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suppliers  = AllAccount::suppliers()->get();
        $accounts = AllAccount::banking()->get();
        $costs = Cost::all();
        $orders  = PurchaseOrder::all();
        $receipt   = receipts::find($id);
        return view('receipts.details_receipt',compact('receipt','costs','accounts','suppliers','orders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
            $receipt = receipts::find($request->receipt_id);
            if(isset($request->p_num))
            { 
                $receipt->update([
                    'p_num'  => $request->p_num,
                ]);
            }
            else
            {
                $receipt->update([
                    'date'         => $request->date,
                    'total'        => $request->total,
                    'additions'    => $request->additions,
                    'discount'     => $request->discount,
                    'sub_total'    => $request->sub_total,
                    'amount_paid'  => $request->amount_paid,
                    'supplier_id'  => $request->supplier_id,
                    'cost_id'      => $request->cost_id ? $request->cost_id : null ,
                    'account_id'   => $request->account_id ? $request->account_id : null,  
                    "stock_id"     => $request->stock_id,
                    "purchase_order_id" => $request->order_id,
                    "value_added"  => $request->value_add,
                ]);

                //decreament product from stock
                if($receipt->type == 1)
                {
                    foreach ($receipt->receipt_products as $productInOffer) 
                    {
                        $productInStock = products::find($productInOffer->product_id); 
                        $productInStock->quantity = $productInStock->quantity - $productInOffer->product_quantity;
                        $productInStock->update();            
                    }
                }
                receipt_products::where('receipt_id',$request->receipt_id)->delete();
                $products = OrderProduct::where('purchase_order_id',$request->order_id)->get();
                foreach ($products as $product) 
                {                
                    receipt_products::create([
                        'receipt_id'       => $request->receipt_id,
                        'product_id'       => $product->product_id,
                        'product_quantity' => $product->quantity,
                        'product_Purchasing_price' => $product->Purchasing_price,
                    ]);

                    if($receipt->type == 1)
                    {
                        $productInStock = products::find($product->product_id);
                        $total_old = $productInStock->quantity * $productInStock->Purchasing_price ;
                        $total = $product->quantity * $product->Purchasing_price;
                        $total_new = $total + $total_old ;              
                        $productInStock->quantity = $productInStock->quantity + $product->quantity;
                        if($productInStock->quantity  > 0 )
                        {
                            $productInStock->Purchasing_price = $total_new / $productInStock->quantity ;
                        }
                        $productInStock->update();
                    }
                }



                if($receipt->type == 1)
                {
                    $day = day::find($receipt->day_id);
                    $day->day2()->forceDelete();

                    $day->update([
                        'date' => $receipt->date,
                        'note' => "فاتورة مشتريات رقم " . " " . $receipt->id,
                        'type' => 1,
                        'type_name' => 'مشتريات (منتجات)',
                        'type_id' => $receipt->id,
                        'total' => $receipt->total + $receipt->amount_paid,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
                    //حساب مخزون  
                    DayDetails::create([
                        'date' => $receipt->date,
                        'day_id' => $day->id,
                        'account_id' => $receipt->stock->account_id,
                        'debit' => $receipt->sub_total,
                        'credit' => 0,
                        'note' => "فاتورة مشتريات رقم " . " " . $receipt->id,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
                    // الضرائب
                    if($receipt->value_added == 1)
                    {
                        DayDetails::create([
                            'date' => $receipt->date,
                            'day_id' => $day->id,
                            'account_id' => 45,
                            'debit' => $receipt->sub_total * .14,
                            'credit' => 0,
                            'note' => " ضريبة القيمة المضافة لفاتورة مشتريات رقم" . " " . $receipt->id,
                            'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                        ]);
                    }
                    // الخصم المكتسب
                    if($receipt->discount > 0)
                    {
                        DayDetails::create([
                            'date' => $receipt->date,
                            'day_id' => $day->id,
                            'account_id' => 112,
                            'debit' => 0,
                            'credit' => $receipt->discount,
                            'note' => " الخصم المكتسب لفاتورة مشتريات رقم" . " " . $receipt->id,
                            'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                        ]);
                    }
        
                    //  المصاريف
                    if($receipt->additions > 0)
                    {
                        DayDetails::create([
                            'date' => $receipt->date,
                            'day_id' => $day->id,
                            'account_id' => 110,
                            'debit' => $receipt->additions,
                            'credit' => 0,
                            'note' => "   مصاريف فاتورة مشتريات رقم" . " " . $receipt->id,
                            'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                        ]);
                    }
        
                    // المورد
                    DayDetails::create([
                        'date' => $receipt->date,
                        'day_id' => $day->id,
                        'account_id' => $receipt->supplier->id,
                        'debit' => 0,
                        'credit' => $receipt->total,
                        'note' => "فاتورة مشتريات رقم" . " " . $receipt->id,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
        
                    if($receipt->amount_paid > 0 && $receipt->account_id != null)
                    {
                        DayDetails::create([
                            'date' => $receipt->date,
                            'day_id' => $day->id,
                            'account_id' => $receipt->supplier->id,
                            'debit' => $receipt->amount_paid,
                            'credit' => 0,
                            'note' => " مدفوعات فاتورة مشتريات رقم " . " " . $receipt->id,
                            'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                        ]);
                        DayDetails::create([
                            'date' => $receipt->date,
                            'day_id' => $day->id,
                            'account_id' => $receipt->account_id,
                            'debit' => 0,
                            'credit' =>$receipt->amount_paid,
                            'note' => " مدفوعات فاتورة مشتريات رقم" . " " . $receipt->id,
                            'cost_id' => $request->cost_id ? $request->cost_id : null ,
                        ]);
                    }
                }
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        session()->flash('mss','تم تعديل الفاتورة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\receipts  $receipts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $receipt = receipts::find($request->id);
            if($receipt->type == 1)
            {
                $invoiceProducts = receipt_products::where('receipt_id','=',$receipt->id)->get();
                foreach ($invoiceProducts as $productInInvoice) 
                {
                    $productInStock = products::find($productInInvoice->product_id);             
                    $productInStock->quantity = $productInStock->quantity - $productInInvoice->product_quantity;
                    $productInStock->update();
                }  
                DayDetails::where('day_id',$receipt->day_id)->delete();
                day::find($receipt->day_id)->delete();
            }
            $receipt->delete();
        } catch(\Exception $e){
            DB::rollback();
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        session()->flash('delete','تم حذف الفاتورة بنجاح');
        return back();
    }
}
