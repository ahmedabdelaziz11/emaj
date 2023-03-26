<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\Cost;
use App\Models\day;
use App\Models\DayDetails;
use App\Models\spare_receipts;
use App\Models\spare_sections;
use App\Models\spares;
use App\Models\sreceipt_products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpareReceiptsController extends Controller
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
        $receipts = spare_receipts::orderBy('id', 'desc')->get();
        return view('spare_receipts.receipts',compact('receipts'));
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
        $costs = Cost::all();
        $products  = spares::all();
        $sections  = spare_sections::all();
        return view('spare_receipts.create_receipt',compact('suppliers','products','sections','accounts','costs'));
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
            $products = [];

            $total = $purchases = $value_added = $discount = $additions = 0;
            if($request->product_name_new != null)
            {    
                foreach($request->product_name_new as $index => $value)
                {
                    if($value != null && $request->purchasing_price_new[$index] !=null && $request->selling_price_new[$index] !=null )
                    {
                        $products[] = spares::create([
                            'name' => $value,
                            'name_en' => "nothing" ,
                            'description' => "لا يوجد",
                            'description_en' => "nothing",
                            'Purchasing_price' => $request->purchasing_price_new[$index],
                            'selling_price' => $request->selling_price_new[$index],
                            'quantity' => $request->quantity_new[$index],
                            'section_id' => $request->section_id[$index],
                        ]);
                        $total = $total + ($request->purchasing_price_new[$index] * $request->quantity_new[$index]);         
                    }
                }
            }
            if($request->id != null)
            {
                $p_prices = $request->purchasing_price;
                $quantities = $request->quantity;
                foreach($request->id as $index => $value )
                {
                    $total = $total + ($p_prices[$index] * $quantities[$index]);         
                }
            }
            $purchases = $total; // price of products only 
            if($request->value_add == 1)
            {
                $total = $total + ($total * 0.14 );
                $value_added = $total - $purchases;
            }
            else
            {
                $total = $total;
            }
            $total += $request->additions - $request->discount ;
            $receipt = spare_receipts::create([
                'date' => $request->date,
                'total'        => $total,
                'additions'    => $request->additions,
                'discount'     => $request->discount,
                'sub_total'    => $purchases,
                'amount_paid'  => $request->amount_paid,
                'supplier_id'  => $request->supplier_id,
                'cost_id'      => $request->cost_id ? $request->cost_id : null ,
                'account_id'   => $request->account_id ? $request->account_id : null,  
                'Status'       => "شراء قطع غيار",
                "Value_Status" => "2",
                "value_added"  => $request->value_add,
                "type" => 0,
                "Created_by"   => Auth::user()->name,
            ]);

            if($products != null)
            {
                foreach ($products as $product) 
                {                
                    sreceipt_products::create([
                        'receipt_id'       => $receipt->id,
                        'product_id'       => $product->id,
                        'product_quantity' => $product->quantity,
                        'product_Purchasing_price' => $product->Purchasing_price,
                    ]);
                    $product = spares::find($product->id);
                    $product->quantity = 0;
                    $product->save();
                }
            }

            if($request->id != null)
            {
                foreach ($request->id as $index => $value) 
                {                
                    sreceipt_products::create([
                        'receipt_id'       => $receipt->id,
                        'product_id'       => $value,
                        'product_quantity' => $quantities[$index],
                        'product_Purchasing_price' => $p_prices[$index],
                    ]);
                }
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();        
        return redirect('/ReceiptDetails_s/'.$receipt->id)->with('message',"تم اضافه الفاتورة");
    }

    public function payment(Request $request)
    {
        DB::beginTransaction();
        try{
            $receipt = spare_receipts::find($request->id);

            $products = sreceipt_products::where('receipt_id',$receipt->id)->get();
            foreach($products as $product)
            {
                $productInStock = spares::find($product->product_id);
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
                'date' => date('Y-m-d'),
                'note' => "فاتورة مشتريات رقم " . " " . $receipt->id,
                'type' => 2,
                'type_name' => 'مشتريات (قطع غيار)',
                'type_id' => $receipt->id,
                'total' => $receipt->total + $receipt->amount_paid,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);

            $receipt->update([
                'day_id' => $day->id,
                'type' => 1,
            ]);
            //حساب مخزون قطع الغيار 
            DayDetails::create([
                'date' => date('Y-m-d'),
                'day_id' => $day->id,
                'account_id' => 108,
                'debit' => $receipt->sub_total,
                'credit' => 0,
                'note' => "فاتورة مشتريات (ق) قم " . " " . $receipt->id,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);
            // الضرائب
            if($receipt->value_added == 1)
            {
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 45,
                    'debit' => $receipt->sub_total * .14,
                    'credit' => 0,
                    'note' => " ضريبة القيمة المضافة لفاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }
            // الخصم المكتسب
            if($receipt->discount > 0)
            {
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 112,
                    'debit' => 0,
                    'credit' => $receipt->discount,
                    'note' => " الخصم المكتسب لفاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }

            //  المصاريف
            if($receipt->additions > 0)
            {
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 110,
                    'debit' => $receipt->additions,
                    'credit' => 0,
                    'note' => " مصاريف فاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
            }

            // المورد
            DayDetails::create([
                'date' => date('Y-m-d'),
                'day_id' => $day->id,
                'account_id' => $receipt->supplier->id,
                'debit' => 0,
                'credit' => $receipt->total,
                'note' => "فاتورة مشتريات (ق) قم" . " " . $receipt->id,
                'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
            ]);

            if($receipt->amount_paid > 0 && $receipt->account_id != null)
            {
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => $receipt->supplier->id,
                    'debit' => $receipt->amount_paid,
                    'credit' => 0,
                    'note' => " مدفوعات فاتورة مشتريات (ق) رقم " . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => $receipt->account_id,
                    'debit' => 0,
                    'credit' =>$receipt->amount_paid,
                    'note' => " مدفوعات فاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                    'cost_id' => $request->cost_id ? $request->cost_id : null ,
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/ReceiptDetails_s/'.$receipt->id)->with('message',"تم اضافه الفاتورة");   
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\spare_receipts  $spare_receipts
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receipt   = spare_receipts::where('id',$id)->first();
        $suppliers  = AllAccount::suppliers()->get();
        $accounts = AllAccount::banking()->get();
        $costs = Cost::all();
        $products  = spares::all();
        $sections  = spare_sections::all();
        return view('spare_receipts.details_receipt',compact('receipt','suppliers','accounts','costs','products','sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\spare_receipts  $spare_receipts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,spare_receipts $spare_receipts)
    {
        DB::beginTransaction();
        try{
            $products = [];
            $total = $purchases = $value_added = $discount = $additions = 0;
            if($request->product_name_new != null)
            {    
                foreach($request->product_name_new as $index => $value)
                {
                    if($value != null && $request->purchasing_price_new[$index] !=null && $request->selling_price_new[$index] !=null )
                    {
                        $products[] = spares::create([
                            'name' => $value,
                            'name_en' => "nothing" ,
                            'description' => "لا يوجد",
                            'description_en' => "nothing",
                            'Purchasing_price' => $request->purchasing_price_new[$index],
                            'selling_price' => $request->selling_price_new[$index],
                            'quantity' => $request->quantity_new[$index],
                            'section_id' => $request->section_id[$index],
                        ]);
                        $total = $total + ($request->purchasing_price_new[$index] * $request->quantity_new[$index]);         
                    }
                }
            }
            if($request->id != null)
            {
                $p_prices = $request->purchasing_price;
                $quantities = $request->quantity;
                foreach($request->id as $index => $value )
                {
                    $total = $total + ($p_prices[$index] * $quantities[$index]);         
                }
            }
            $purchases = $total; // price of products only 
            if($request->value_add == 1)
            {
                $total = $total + ($total * 0.14 );
                $value_added = $total - $purchases;
            }

            $total += $request->additions - $request->discount;

            spare_receipts::find($request->receipt_id)->update([
                'date'         => $request->date,
                'total'        => $total,
                'additions'    => $request->additions,
                'discount'     => $request->discount,
                'sub_total'    => $purchases,
                'amount_paid'  => $request->amount_paid,
                'supplier_id'  => $request->supplier_id,
                'cost_id'      => $request->cost_id ? $request->cost_id : null ,
                'account_id'   => $request->account_id ? $request->account_id : null,  
                'Status'       => "شراء منتجات",
                "Value_Status" => "1",
                "value_added"  => $request->value_add,
            ]);
            $receipt = spare_receipts::find($request->receipt_id);
            foreach($receipt->receipt_products as $product)
            {
                $productInStock = spares::find($product->product_id);
                $productInStock->quantity -= $product->product_quantity ;
                $productInStock->save();
                $product->delete();
            }



            if($products != null)
            {
                foreach ($products as $product) 
                {                
                    sreceipt_products::create([
                        'receipt_id'       => $receipt->id,
                        'product_id'       => $product->id,
                        'product_quantity' => $product->quantity,
                        'product_Purchasing_price' => $product->Purchasing_price,
                    ]);
                    $product = spares::find($product->id);
                    $product->quantity = 0;
                    $product->save();
                }
            }

            if($request->id != null)
            {
                foreach ($request->id as $index => $value) 
                {                
                    sreceipt_products::create([
                        'receipt_id'       => $receipt->id,
                        'product_id'       => $value,
                        'product_quantity' => $quantities[$index],
                        'product_Purchasing_price' => $p_prices[$index],
                    ]);
                }
            }

            if($receipt->type == 1)
            {
                $products = sreceipt_products::where('receipt_id',$receipt->id)->get();
                foreach($products as $product)
                {
                    $productInStock = spares::find($product->product_id);
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
    
                day::find($receipt->day_id)->update([
                    'note' => "فاتورة مشتريات (ق) رقم " . " " . $receipt->id,
                    'type' => 2,
                    'type_name' => 'مشتريات (قطع غيار)',
                    'type_id' => $receipt->id,
                    'total' => $receipt->total + $receipt->amount_paid,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
                $day = day::find($receipt->day_id);
                $day->day2()->delete();
                //حساب مخزون قطع الغيار 
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 108,
                    'debit' => $receipt->sub_total,
                    'credit' => 0,
                    'note' => "فاتورة مشتريات (ق) قم " . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);
                // الضرائب
                if($receipt->value_added == 1)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 45,
                        'debit' => $receipt->sub_total * .14,
                        'credit' => 0,
                        'note' => " ضريبة القيمة المضافة لفاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
                }
                // الخصم المكتسب
                if($receipt->discount > 0)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 112,
                        'debit' => 0,
                        'credit' => $receipt->discount,
                        'note' => " الخصم المكتسب لفاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
                }

                //  المصاريف
                if($receipt->additions > 0)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 110,
                        'debit' => $receipt->additions,
                        'credit' => 0,
                        'note' => " مصاريف فاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
                }

                // المورد
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => $receipt->supplier->id,
                    'debit' => 0,
                    'credit' => $receipt->total,
                    'note' => "فاتورة مشتريات (ق) قم" . " " . $receipt->id,
                    'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                ]);

                if($receipt->amount_paid > 0 && $receipt->account_id != null)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => $receipt->supplier->id,
                        'debit' => $receipt->amount_paid,
                        'credit' => 0,
                        'note' => " مدفوعات فاتورة مشتريات (ق) رقم " . " " . $receipt->id,
                        'cost_id' => $receipt->cost_id ? $receipt->cost_id : null ,
                    ]);
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => $receipt->account_id,
                        'debit' => 0,
                        'credit' =>$receipt->amount_paid,
                        'note' => " مدفوعات فاتورة مشتريات (ق) رقم" . " " . $receipt->id,
                        'cost_id' => $request->cost_id ? $request->cost_id : null ,
                    ]);
                }
            }
            
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\spare_receipts  $spare_receipts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $receipt = spare_receipts::find($request->id);
            if($receipt->type == 1)
            {
                $invoiceProducts = sreceipt_products::where('receipt_id','=',$receipt->id)->get();
                foreach ($invoiceProducts as $productInInvoice) 
                {
                    $productInStock = spares::find($productInInvoice->product_id);             
                    $productInStock->quantity = $productInStock->quantity - $productInInvoice->product_quantity;
                    $productInStock->update();
                }  
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

