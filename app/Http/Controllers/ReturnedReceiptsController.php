<?php

namespace App\Http\Controllers;

use App\Models\day;
use App\Models\DayDetails;
use App\Models\products;
use App\Models\receipt_products;
use App\Models\receipts;
use App\Models\ReturnedReceipts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturnedReceiptsController extends Controller
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
        $invoices = ReturnedReceipts::orderBy('id', 'desc')->get();   
        return view('returned-receipts.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoices = receipts::where('type',1)->get();
        return view('returned-receipts.create',compact('invoices'));
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
            $o_receipt = receipts::find($request->receipt_id);
            $sub_total = $total = $value_added = 0;
            
            foreach($request->id as $index => $product_id)
            {
                $productInStock = products::find($product_id);
                $productInStock->quantity -= $request->quantity[$index];
                $productInStock->update();

                $productInInvo = receipt_products::where('receipt_id',$request->receipt_id)->where('product_id',$product_id)->first();
                $sub_total += ($productInInvo->product_Purchasing_price * $request->quantity[$index] );

                $products[] = [
                    'product_id'               => $product_id,
                    'product_quantity'         => $request->quantity[$index],
                    'product_Purchasing_price' => $productInInvo->product_Purchasing_price,
                ];
            }
            $total = $sub_total;
            if($o_receipt->value_added == 1)
            {
                $value_added = $total * 0.14;
                $total += $value_added;
            }
            $receipt = ReturnedReceipts::create([
                'date'         => $request->date,
                'total'        => $total,
                'discount'     => 0,
                'sub_total'    => $sub_total,
                "value_added"  => $o_receipt->value_added,
                'supplier_id'  => $o_receipt->supplier_id,
                'cost_id'      => $o_receipt->cost_id,
                "stock_id"     => $o_receipt->stock_id,
                "receipt_id"     => $o_receipt->id,
                "type"         => 0,
                "Created_by"   => Auth::user()->name,
            ]);
            $receipt->receipt_products()->createMany($products);

            $day = day::create([
                'date' => $request->date,
                'note' => "فاتورة مرتجع مشتريات رقم " . " " . $receipt->id,
                'type' => 6,
                'type_name' => 'مشتريات (منتجات)',
                'type_id' => $receipt->id,
                'total' => $receipt->total,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);

            $receipt->update([
                'day_id' => $day->id,
                'type' => 1,
            ]);
            //حساب مخزون  
            DayDetails::create([
                'date' => $request->date,
                'day_id' => $day->id,
                'account_id' => $receipt->stock->account_id,
                'debit' => 0,
                'credit' => $receipt->sub_total,
                'note' => "فاتورة  مرتجع مشتريات رقم " . " " . $receipt->id,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);
            // الضرائب
            if($receipt->value_added == 1)
            {
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => 45,
                    'debit' => 0,
                    'credit' => $receipt->sub_total * .14,
                    'note' => " ضريبة القيمة المضافة لفاتورة  مرتجع مشتريات رقم " . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }
            // الخصم المكتسب
            if($receipt->discount > 0)
            {
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => 112,
                    'debit' => $receipt->discount,
                    'credit' => 0,
                    'note' => " الخصم المكتسب لفاتورة  مرتجع مشتريات رقم " . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }

            // المورد
            DayDetails::create([
                'date' => $request->date,
                'day_id' => $day->id,
                'account_id' => $receipt->supplier->id,
                'debit' => $receipt->total,
                'credit' => 0,
                'note' => "فاتورة  مرتجع مشتريات رقم " . " " . $receipt->id,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/returned-receipts/'.$receipt->id)->with('mss',"تم اضافه الفاتورة");  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturnedReceipts  $returnedReceipts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = ReturnedReceipts::find($id);
        return view('returned-receipts.show',compact('receipt'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturnedReceipts  $returnedReceipts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        DB::beginTransaction();
        try{
            $returned_receipt = ReturnedReceipts::find($request->id);

            foreach ($returned_receipt->prodcuts as $product) 
            {
                $productInStock = products::find($product->id);             
                $productInStock->quantity = $productInStock->quantity + $product->pivot->product_quantity;
                $productInStock->update();
            }  
            $day = day::find($returned_receipt->day_id);
            $day->day2()->delete();
            $day->delete();           
            $returned_receipt->delete();
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        session()->flash('delete','تم حذف الفاتورة بنجاح');
        return back();
    }
}
