<?php

namespace App\Http\Controllers;

use App\Models\day;
use App\Models\DayDetails;
use App\Models\invoice_products;
use App\Models\InvoiceCompositeProduct;
use App\Models\InvoiceCProduct;
use App\Models\invoices;
use App\Models\products;
use App\Models\returned_invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnedInvoiceController extends Controller
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
        $invoices = returned_invoice::orderBy('id', 'desc')->get();   
        return view('returned-invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $invoices = invoices::where('type',1)->get();
        return view('returned-invoices.create',compact('invoices'));
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
            $o_invoice = invoices::find($request->invoice_id);
            $stock_cost = $sub_total = $total = $value_added = 0;
            foreach($request->id as $index => $product_id)
            {
                if($request->type[$index] == 1)
                {
                    $productInStock = products::find($product_id);
                    $productInStock->quantity += $request->quantity[$index];
                    $productInStock->update();
    
                    $productInInvo = invoice_products::where('invoice_id',$request->invoice_id)->where('product_id',$product_id)->first();
                    $stock_cost += ($productInInvo->product_Purchasing_price * $request->quantity[$index] );
                    $sub_total += ($productInInvo->product_selling_price * $request->quantity[$index] );
    
                    $products[] = [
                        'product_id'               => $product_id,
                        'product_quantity'         => $request->quantity[$index],
                        'product_Purchasing_price' => $productInInvo->product_Purchasing_price,
                        'product_selling_price'    => $productInInvo->product_selling_price,
                    ];
                }

                if($request->type[$index] == 2)
                {
                    $composite_product = InvoiceCompositeProduct::where('invoice_id',$request->invoice_id)
                    ->where('coposite_product_id',$product_id)
                    ->first();

                    $stock_cost += ($composite_product->cost * $request->quantity[$index] );
                    $sub_total += ($composite_product->selling_price * $request->quantity[$index] );

                    $p_quantity =  $request->quantity[$index]  / $composite_product->quantity;


                    $products = InvoiceCProduct::where('invoice_id',$request->invoice_id)
                        ->where('coposite_product_id',$product_id)
                        ->get();

                    foreach($products as $product)
                    {
                        $quantity = $product->quantity * $p_quantity;
                        $productInStock = products::find($product->id);
                        $productInStock->quantity += $quantity;
                        $productInStock->update();
                    }
                }

            }

            $total = $sub_total - ($sub_total * ($o_invoice->discount / 100));

            if($o_invoice->value_added != 0)
            {
                $value_added = $total * 0.14;
                $total += $value_added;
            }

            $invoice = returned_invoice::create([
                'date' => $request->date,
                'total' => $total,
                'sub_total' => $sub_total,
                'value_added' => $value_added,
                'discount' => $o_invoice->discount,
                'Status'       =>  $o_invoice->Status,
                'Value_Status' => $o_invoice->Value_Status,
                'Created_by' => auth()->user()->name,
                'stock_id' => $o_invoice->stock_id, 
                'invoice_id' => $o_invoice->id,
                'client_id' => $o_invoice->client_id,
            ]);

            $invoice->invoice_products()->createMany($products);


            $day = day::create([
                'date' => $request->date,
                'note' => "فاتورة مرتجع مبيعات رقم " . " " . $invoice->id,
                'type' => 5,
                'type_name' => 'مرتجع مبيعات',
                'type_id' => $invoice->id,
                'total' => $invoice->total ,
                'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
            ]);
            $invoice->update([
                'day_id' => $day->id,
                'type' => 1
            ]);

            if($invoice->Value_Status == 0)
            {
                //المبيعات
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => 36,
                    'debit' => $invoice->sub_total,
                    'credit' => 0,
                    'note' => "فاتورة مرتجع مبيعات رقم " . " " . $invoice->id,
                    'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
                ]);
                //المخزون
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => $invoice->stock->account_id,
                    'debit' => $stock_cost,
                    'credit' => 0,
                    'note' => "فاتورة مرتجع مبيعات رقم " . " " . $invoice->id,
                    'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
                ]);
                //تكلفة البضاعة المباعه
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => 111,
                    'debit' => 0,
                    'credit' => $stock_cost,
                    'note' => "فاتورة مرتجع مبيعات رقم " . " " . $invoice->id,
                    'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
                ]);
                // الضرائب
                if($invoice->value_added > 0)
                {
                    DayDetails::create([
                        'date' => $request->date,
                        'day_id' => $day->id,
                        'account_id' => 48,
                        'debit' => $invoice->value_added,
                        'credit' => 0,
                        'note' => " ضريبة القيمة المضافة لفاتورة مرتجع مبيعات رقم" . " " . $invoice->id,
                        'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
                    ]);
                }
                // الخصم الممنوح
                if($invoice->discount > 0)
                {
                    DayDetails::create([
                        'date' => $request->date,
                        'day_id' => $day->id,
                        'account_id' => 109,
                        'debit' => 0,
                        'credit' => $invoice->sub_total * ($invoice->discount / 100),
                        'note' => " الخصم الممنوح لفاتورة مرتجع مبيعات رقم" . " " . $invoice->id,
                        'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
                    ]);
                }

                // المورد
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => $invoice->client->id,
                    'debit' => 0,
                    'credit' => $invoice->sub_total + $invoice->value_added - ($invoice->sub_total * ($invoice->discount / 100)),
                    'note' => "فاتورة مرتجع مبيعات رقم" . " " . $invoice->id,
                    'cost_id' => $o_invoice->cost_id ? $o_invoice->cost_id : null ,
                ]);
            }
            else
            {
                //المخزون
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => $invoice->stock->account_id,
                    'debit' => $stock_cost,
                    'credit' => 0,
                    'note' => "فاتورة مبيعات داخل الضمان رقم " . " " . $request->invoice_id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);

                if($invoice->value_added > 0)
                {
                    DayDetails::create([
                        'date' => $request->date,
                        'day_id' => $day->id,
                        'account_id' => 48,
                        'debit' => $invoice->value_added,
                        'credit' => 0,
                        'note' => " ضريبة القيمة المضافة لفاتورة مبيعات داخل الضمان رقم" . " " . $request->invoice_id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }

                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => 288,
                    'debit' => 0,
                    'credit' => $invoice->value_added + $stock_cost,
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
        return redirect('/returned_invoices/'.$invoice->id)->with('mss',"تم اضافه الفاتورة");
    }

    public function show($id)
    {
        $invoice = returned_invoice::find($id);
        return view('returned-invoices.show',compact('invoice'));
    }

    public function destroy(Request $request)
    {
        return back();
    }
}
