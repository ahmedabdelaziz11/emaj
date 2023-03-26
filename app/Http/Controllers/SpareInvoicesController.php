<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\Cost;
use App\Models\day;
use App\Models\DayDetails;
use App\Models\sinvoice_products;
use App\Models\spare_invoice_attachments;
use App\Models\spare_invoices;
use App\Models\spares;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SpareInvoicesController extends Controller
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
        $invoices = spare_invoices::orderBy('date', 'desc')->get();    
        return view('spare_invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients  = AllAccount::clients()->get();
        $accounts = AllAccount::banking()->get();
        $costs = Cost::all();
        $products = spares::where('quantity','>','0')->get();
        return view('spare_invoices.create_invoice',compact('clients','products','costs','accounts'));
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
            $total = $request->sub_total;
            $sales = $request->sub_total;

            if($request->discount != 0)
            {
                $total = $total - $request->discount;
            }
            $discount = $sales - $total;

            $value_added = 0;
            if($request->value_add == 1)
            {
                $value_added = $total * 0.14;
                $total = $total + ($total * 0.14 );
            }

            $total = $total + $request->additions;
            $invoice = spare_invoices::create([
                'date'         => $request->date,
                'sub_total'    => $sales,
                'additions'    => $request->additions,
                'profit'       => 0,
                'total'        => $total,
                'amount_paid'  => $request->amount_paid,
                'discount'     => $discount,
                'client_id'    => $request->client_id,
                'account_id'   => $request->account_id ? $request->account_id : null,  
                'Status'       =>  $request->dman ? 'داخل الضمان' : 'خارج الضمان',
                'Value_Status' => $request->dman,
                'type'         => "0",
                'cost_id'      => $request->cost_id ? $request->cost_id : null ,     
                'value_added'  => $value_added,
                "Created_by"   => Auth::user()->name,
            ]);

            if($request->id != null)
            {
                foreach ($request->id as $index => $value ) 
                {
                    sinvoice_products::create([
                        'invoice_id'       => $invoice->id,
                        'product_id'       => $value,
                        'product_quantity' => $request->quantity[$index],
                        'product_Purchasing_price' => $request->Purchasing_price[$index],
                        'product_selling_price'    => $request->selling_price[$index],
                    ]);
                }
            }

            if ($request->hasFile('pic')) {
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
                $invoice_number = $invoice->id;
    
                $attachments = new spare_invoice_attachments();
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice->id;
                $attachments->Created_by = Auth::user()->name;
                $attachments->invoice_id = $invoice->id;
                $attachments->save();
    
                // move pic
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/spare_invoices/' . $invoice_number), $imageName);
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/InvoiceDetails_s/'.$invoice->id)->with('message',"تم اضافه الفاتورة");
    }

    public function payment(Request $request)
    {
        DB::beginTransaction();
        try{
                $invoice = spare_invoices::find($request->id);       
                $sales_cost = 0;
                foreach ($invoice->invoice_products as $productInOffer) 
                {
                    $productInStock = spares::find($productInOffer->product_id); 
                    $productInStock->quantity = $productInStock->quantity - $productInOffer->product_quantity;
                    $sales_cost += $productInStock->Purchasing_price;
                    $productInStock->update();            
                }

                $day = day::create([
                    'date' => date('Y-m-d'),
                    'note' => "فاتورة مبيعات رقم " . " " . $invoice->id,
                    'type' => 4,
                    'type_name' => 'مبيعات (قطع غيار)',
                    'type_id' => $invoice->id,
                    'total' => $invoice->total + $invoice->amount_paid ,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                $invoice->update([
                    'day_id' => $day->id,
                    'type' => 1
                ]);
                //المبيعات
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 36,
                    'debit' => 0,
                    'credit' => $invoice->sub_total,
                    'note' => "فاتورة مبيعات رقم " . " " . $invoice->id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                //المخزون
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 108,
                    'debit' => 0,
                    'credit' => $sales_cost,
                    'note' => "فاتورة مبيعات رقم " . " " . $invoice->id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                //تكلفة البضاعة المباعه
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => 111,
                    'debit' => $sales_cost,
                    'credit' => 0,
                    'note' => "فاتورة مبيعات رقم " . " " . $invoice->id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                // الضرائب
                if($invoice->value_added > 0)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 48,
                        'debit' => 0,
                        'credit' => $invoice->value_added,
                        'note' => " ضريبة القيمة المضافة لفاتورة مبيعات رقم" . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }
                // الخصم الممنوح
                if($invoice->discount > 0)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 109,
                        'debit' => $invoice->discount,
                        'credit' => 0,
                        'note' => " الخصم الممنوح لفاتورة مبيعات رقم" . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }
    
                //  المصاريف
                if($invoice->additions > 0)
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 28,
                        'debit' => 0,
                        'credit' => $invoice->additions,
                        'note' => "   ايرادات فاتورة مبيعات رقم" . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }
    
                // العميل
                DayDetails::create([
                    'date' => date('Y-m-d'),
                    'day_id' => $day->id,
                    'account_id' => $invoice->client->id,
                    'debit' => ($invoice->sub_total + $invoice->value_added + $invoice->additions) - $invoice->discount,
                    'credit' => 0,
                    'note' => "فاتورة مبيعات رقم" . " " . $invoice->id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);

                if($invoice->Value_Status == 0)
                {
                    if($invoice->amount_paid > 0 && $invoice->account_id != null)
                    {
                        DayDetails::create([
                            'date' => date('Y-m-d'),
                            'day_id' => $day->id,
                            'account_id' => $invoice->client->id,
                            'debit' => 0,
                            'credit' => $invoice->amount_paid,
                            'note' => " مدفوعات فاتورة مبيعات رقم " . " " . $invoice->id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
        
                        DayDetails::create([
                            'date' => date('Y-m-d'),
                            'day_id' => $day->id,
                            'account_id' => $invoice->account_id,
                            'debit' => $invoice->amount_paid,
                            'credit' =>0,
                            'note' => " مدفوعات فاتورة مبيعات رقم" . " " . $invoice->id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
                    }
                }else
                {
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => $invoice->client->id,
                        'debit' => 0,
                        'credit' => $invoice->sub_total + $invoice->value_added + $invoice->additions - $invoice->discount,
                        'note' => "  فاتورة مبيعات داخل الضمان رقم " . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
    
                    DayDetails::create([
                        'date' => date('Y-m-d'),
                        'day_id' => $day->id,
                        'account_id' => 288,
                        'debit' => $invoice->sub_total + $invoice->value_added + $invoice->additions - $invoice->discount,
                        'credit' =>0,
                        'note' => "  فاتورة مبيعات داخل الضمان رقم " . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }

        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit(); 
        return redirect('/InvoiceDetails_s/'.$invoice->id)->with('message',"تم اضافه الفاتورة");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sinvoice_products  $sinvoice_products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients  = AllAccount::clients()->get();
        $accounts = AllAccount::banking()->get();
        $costs    = Cost::all();
        $products = spares::where('quantity','>','0')->get();
        $invoice  = spare_invoices::find($id);
        return view('spare_invoices.details_invoice',compact('clients','accounts','costs','products','invoice'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\spare_invoices  $spare_invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $invoice = spare_invoices::find($request->id);
            if($invoice->type == 1)
            {
                foreach ($invoice->invoice_products as $productInInvoice) 
                {
                    $productInStock = spares::find($productInInvoice->product_id);             
                    $productInStock->quantity = $productInStock->quantity + $productInInvoice->product_quantity;
                    $productInStock->update();
                }
                day::find($invoice->day_id)->delete();
            }
            $invoice->delete();
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
