<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\CompositeProduct;
use App\Models\invoices;
use App\Models\Cost;
use App\Models\day;
use App\Models\DayDetails;
use App\Models\invoice_attachments;
use App\Models\products;
use App\Models\invoice_products;
use App\Models\InvoiceCompositeProduct;
use App\Models\InvoiceCProduct;
use App\Models\offer_products;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\OfferService;
use App\Models\InvoiceService;
use App\Models\OfferCompositeProducts;
use App\Models\offers;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
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
        $invoices = invoices::orderBy('id', 'desc')->get();   
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients  = AllAccount::whereIn('parent_id',[18,5])->get();
        $accounts = AllAccount::banking()->get();
        $costs = Cost::all();
        $stocks = Stock::all();
        $tickets = Ticket::get('id');

        return view('invoices.create_invoice',compact('clients','stocks','accounts','costs','tickets'));
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
            $request->validate(['client_id' => 'required','offer_id' => 'required','cost_id' => 'required']);
            $total = $sales = $request->total;
            $value_added = 0;
            $total += $request->t_service;
            if($request->discount != 0)
            {
                $total -= ($total * ($request->discount / 100));
            }

            if($request->value_add == 1)
            {
                $value_added = $total  * 0.14;
                $total += $value_added;
            }


            $invoice = invoices::create([
                'date'         => $request->date,
                'sub_total'    => $sales,
                't_service'    => $request->t_service,
                'profit'       => $request->profit,
                'total'        => $total,
                'amount_paid'  => $request->amount_paid,
                'discount'     => $request->discount,
                'client_id'    => $request->client_id,
                'account_id'   => $request->account_id ? $request->account_id : null,  
                'offer_id'     => $request->offer_id,
                'Status'       =>  $request->dman ? 'خارج التكلفة' : 'داخل التكلفة',
                'Value_Status' => $request->dman,
                'type'         => "0",
                'cost_id'      => $request->cost_id ? $request->cost_id : null ,     
                'stock_id'      => $request->stock_id,     
                'ticket_id'      => $request->ticket_id,     
                'address'      => $request->address,     
                'value_added'  => $value_added,
                "Created_by"   => Auth::user()->name,
            ]);


            $composite_prodcuts = OfferCompositeProducts::where('offer_id',$request->offer_id)->get();
            foreach ($composite_prodcuts as $cproductInOffer) 
            {

                InvoiceCompositeProduct::create([
                    'invoice_id'       => $invoice->id,
                    'coposite_product_id' => $cproductInOffer->coposite_product_id,
                    'quantity' => $cproductInOffer->quantity,
                    'selling_price' => $cproductInOffer->selling_price,
                    'cost' => $cproductInOffer->composite_product->cost(), 
                ]);
                // total cost = cost * quantity
                $c_products = CompositeProduct::find($cproductInOffer->coposite_product_id);
                foreach($c_products->products as $c_product)
                {
                    InvoiceCProduct::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $c_product->id,
                        'coposite_product_id' => $cproductInOffer->coposite_product_id,
                        'quantity' => $c_product->pivot->quantity * $cproductInOffer->quantity,
                        'Purchasing_price' => $c_product->Purchasing_price,
                    ]);
                }
            }

            $products = offer_products::where('offer_id',$request->offer_id)->get();
            foreach ($products as $productInOffer) 
            {
                $Purchasing_price = products::find($productInOffer->product_id)->Purchasing_price;           
                invoice_products::create([
                    'invoice_id'       => $invoice->id,
                    'product_id'       => $productInOffer->product_id,
                    'product_quantity' => $productInOffer->product_quantity,
                    'product_Purchasing_price' => $Purchasing_price,
                    'product_selling_price'    => $productInOffer->product_price,
                ]);
            }

            $services = OfferService::where('offer_id',$request->offer_id)->get();
            foreach ($services as $service) 
            {
                InvoiceService::create([
                    'invoice_id' => $invoice->id,
                    'details' => $service->details,
                    'price' => $service->price,
                ]);
            }

            if ($request->hasFile('pic')) 
            {
                $image = $request->file('pic');
                $file_name = $image->getClientOriginalName();
                $invoice_number = $invoice->id;

                $attachments = new invoice_attachments();
                $attachments->file_name = $file_name;
                $attachments->invoice_number = $invoice->id;
                $attachments->Created_by = Auth::user()->name;
                $attachments->invoice_id = $invoice->id;
                $attachments->save();

                // move pic
                $imageName = $request->pic->getClientOriginalName();
                $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
            }

        } catch(\Exception $e){
            return $e;
            DB::rollback();
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/InvoiceDetails/'.$invoice->id)->with('message',"تم اضافه الفاتورة");
    }

    public function makePayment()
    {
        $invoices = invoices::where('type',0)->orderBy('id','desc')->get();
        $accounts = AllAccount::where('parent_id',26)->orderBy('id','desc')->get();
        return view('invoices.make-payment',compact('invoices','accounts'));
    }

    public function payment(Request $request)
    {

        DB::beginTransaction();
        try{
            $invoice = invoices::find($request->invoice_id);
            $sales_cost = 0;
            foreach ($invoice->invoice_products as $productInOffer) 
            {
                $productInStock = products::find($productInOffer->product_id); 
                $productInStock->quantity = $productInStock->quantity - $productInOffer->product_quantity;
                $sales_cost += ($productInStock->Purchasing_price * $productInOffer->product_quantity) ;
                $productInStock->update();            
            }

            foreach ($invoice->c_products as $productInOffer) 
            {
                $productInStock = products::find($productInOffer->id); 
                $productInStock->quantity = $productInStock->quantity - $productInOffer->pivot->quantity;
                $sales_cost += ($productInStock->Purchasing_price * $productInOffer->pivot->quantity) ;
                $productInStock->update();    
            }

            
            $day = day::create([
                'date' => $invoice->date,
                'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                'type' => 3,
                'type_name' => 'مبيعات (منتجات)',
                'type_id' => $request->invoice_id,
                'total' => $invoice->total + $invoice->amount_paid ,
                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
            ]);
            $invoice->update([
                'day_id' => $day->id,
                'type' => 1,
                'p_num'  => $request->p_num,
            ]);
            if($invoice->Value_Status == 1)
            {
                //المخزون
                DayDetails::create([
                    'date' => $invoice->date,
                    'day_id' => $day->id,
                    'account_id' => $invoice->stock->account_id,
                    'debit' => 0,
                    'credit' => $sales_cost,
                    'note' => "فاتورة مبيعات خارج التكلفة رقم " . " " . $request->invoice_id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);

                if($invoice->value_added > 0)
                {
                    DayDetails::create([
                        'date' => $invoice->date,
                        'day_id' => $day->id,
                        'account_id' => 48,
                        'debit' => 0,
                        'credit' => $invoice->value_added,
                        'note' => " ضريبة القيمة المضافة لفاتورة مبيعات خارج التكلفة رقم" . " " . $request->invoice_id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }

                DayDetails::create([
                    'date' => $invoice->date,
                    'day_id' => $day->id,
                    'account_id' => 288,
                    'debit' => $invoice->value_added + $sales_cost ,
                    'credit' =>0,
                    'note' => "  فاتورة مبيعات خارج التكلفة رقم " . " " . $invoice->id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
            }else
            {
                //المبيعات
                DayDetails::create([
                    'date' => $invoice->date,
                    'day_id' => $day->id,
                    'account_id' => $request->revune_id,
                    'debit' => 0,
                    'credit' => $invoice->sub_total,
                    'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                //المخزون
                DayDetails::create([
                    'date' => $invoice->date,
                    'day_id' => $day->id,
                    'account_id' => $invoice->stock->account_id,
                    'debit' => 0,
                    'credit' => $sales_cost,
                    'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                //تكلفة البضاعة المباعه
                DayDetails::create([
                    'date' => $invoice->date,
                    'day_id' => $day->id,
                    'account_id' => 111,
                    'debit' => $sales_cost,
                    'credit' => 0,
                    'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);
                // الضرائب
                if($invoice->value_added > 0)
                {
                    DayDetails::create([
                        'date' => $invoice->date,
                        'day_id' => $day->id,
                        'account_id' => 48,
                        'debit' => 0,
                        'credit' => $invoice->value_added,
                        'note' => " ضريبة القيمة المضافة لفاتورة مبيعات رقم" . " " . $request->invoice_id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }

                $services = OfferService::where('offer_id',$invoice->offer_id)->get();   
                $t_services = 0; 
                foreach ($services as $service) 
                {
                    DayDetails::create([
                        'date' => $invoice->date,
                        'day_id' => $day->id,
                        'account_id' => 294,
                        'debit' => 0,
                        'credit' => $service->price,
                        'note' => $service->details,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                    $t_services += $service->price;
                }
                // الخصم الممنوح
                if($invoice->discount > 0)
                {
                    DayDetails::create([
                        'date' => $invoice->date,
                        'day_id' => $day->id,
                        'account_id' => 109,
                        'debit' => $invoice->sub_total * ($invoice->discount / 100),
                        'credit' => 0,
                        'note' => " الخصم الممنوح لفاتورة مبيعات رقم" . " " . $request->invoice_id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }

                // المورد
                DayDetails::create([
                    'date' => $invoice->date,
                    'day_id' => $day->id,
                    'account_id' => $invoice->client->id,
                    'debit' => $t_services + $invoice->sub_total + $invoice->value_added - ($invoice->sub_total * ($invoice->discount / 100)),
                    'credit' => 0,
                    'note' => "فاتورة مبيعات رقم" . " " . $request->invoice_id,
                    'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                ]);

                if($invoice->amount_paid > 0 && $invoice->account_id != null)
                {
                    DayDetails::create([
                        'date' => $invoice->date,
                        'day_id' => $day->id,
                        'account_id' => $invoice->client->id,
                        'debit' => 0,
                        'credit' => $invoice->amount_paid,
                        'note' => " مدفوعات فاتورة مبيعات رقم " . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
    
                    DayDetails::create([
                        'date' => $invoice->date,
                        'day_id' => $day->id,
                        'account_id' => $invoice->account_id,
                        'debit' => $invoice->amount_paid,
                        'credit' =>0,
                        'note' => " مدفوعات فاتورة مبيعات رقم" . " " . $invoice->id,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);
                }
            
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/InvoiceDetails/'.$request->invoice_id)->with('message',"تم اضافه الفاتورة");
    }

    public function show($id)
    {
        $collection = new Collection();
        $cost = 0;
        foreach(invoices::find($id)->prodcuts as $item){
            $cost += ($item->Purchasing_price * $item->pivot->product_quantity);
            $collection->push((object)
            [
                'id' => $item->id,
                'name' => $item->name,
                'quantity'=> $item->pivot->product_quantity,
                'type' => 1,
            ]);
        }
        $composite_products = invoices::find($id)->composite_products;
        foreach($composite_products as $composite_product){
            foreach($composite_product->products as $c_product )
            {
                $cost += ($c_product->Purchasing_price * $c_product->pivot->quantity * $composite_product->pivot->quantity);
            }
            $collection->push((object)
            [
                'id' => $composite_product->id,
                'name' => $composite_product->name,
                'quantity'=> $composite_product->pivot->quantity,
                'type' => 2,
            ]);
        }
        $collection->push((object)
        [
            'id' => 0,
            'name' => 'اجمالى التكلفة للبضاعة',
            'quantity'=> $cost,
        ]);
        return $collection;
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
            $invoice = invoices::find($request->invoice_id);

            if(isset($request->p_num))
            { 
                $invoice->update([
                    'p_num'  => $request->p_num,
                ]);
            }
            else
            {
                $request->validate(['client_id' => 'required','offer_id' => 'required']);

                $total = $sales = $request->total;
                $value_added = 0;
                $total += $request->t_service;

                if($request->discount != 0)
                {
                    $total -= ($total * ($request->discount / 100));
                }
    
                if($request->value_add == 1)
                {
                    $value_added = $total  * 0.14;
                    $total += $value_added;
                }

                $invoice->update([
                    'date'         => $request->date,
                    'sub_total'    => $sales,
                    'profit'       => $request->profit,
                    'total'        => $total,
                    'amount_paid'  => $request->amount_paid,
                    'discount'     => $request->discount,
                    'client_id'    => $request->client_id,
                    'account_id'   => $request->account_id ? $request->account_id : null,  
                    'offer_id'     => $request->offer_id,
                    'Status'       =>  $request->dman ? 'خارج التكلفة' : 'داخل التكلفة',
                    'Value_Status' => $request->dman,
                    'cost_id'      => $request->cost_id ? $request->cost_id : null ,     
                    'stock_id'      => $request->stock_id,   
                    'ticket_id'      => $request->ticket_id,  
                    'address'      => $request->address,     
                    'value_added'  => $value_added,
                ]);

                // return products to stock
                if($invoice->type == 1)
                {
                    foreach ($invoice->invoice_products as $productInOffer) 
                    {
                        $productInStock = products::find($productInOffer->product_id); 
                        $productInStock->quantity = $productInStock->quantity + $productInOffer->product_quantity;
                        $productInStock->update();            
                    }

                    foreach ($invoice->c_products as $productInOffer) 
                    {
                        $productInStock = products::find($productInOffer->id); 
                        $productInStock->quantity = $productInStock->quantity + $productInOffer->pivot->quantity;
                        $productInStock->update();    
                    }
                }
                invoice_products::where('invoice_id',$request->invoice_id)->delete();
                InvoiceService::where('invoice_id',$request->invoice_id)->delete();
                InvoiceCompositeProduct::where('invoice_id',$request->invoice_id)->delete();
                InvoiceCProduct::where('invoice_id',$request->invoice_id)->delete();
                $sales_cost = 0;


                $composite_prodcuts = OfferCompositeProducts::where('offer_id',$request->offer_id)->get();
                foreach ($composite_prodcuts as $cproductInOffer) 
                {
    
                    InvoiceCompositeProduct::create([
                        'invoice_id'       => $invoice->id,
                        'coposite_product_id' => $cproductInOffer->coposite_product_id,
                        'quantity' => $cproductInOffer->quantity,
                        'selling_price' => $cproductInOffer->selling_price,
                        'cost' => $cproductInOffer->composite_product->cost(),
                    ]);
                    foreach($cproductInOffer->composite_product->products as $c_product)
                    {
                        InvoiceCProduct::create([
                            'invoice_id' => $invoice->id,
                            'product_id' => $c_product->id,
                            'coposite_product_id' => $cproductInOffer->coposite_product_id,
                            'quantity' => $c_product->pivot->quantity * $cproductInOffer->quantity,
                            'Purchasing_price' => $c_product->Purchasing_price,
                        ]);
                    }

                    if($invoice->type == 1)
                    {
                        foreach($cproductInOffer->composite_product->products as $productInOffer)
                        {
                            $productInStock = products::find($productInOffer->id); 
                            $productInStock->quantity = $productInStock->quantity - ($productInOffer->pivot->quantity * $cproductInOffer->quantity);
                            $productInStock->update();     
                        }
                    }
                    $sales_cost += ($cproductInOffer->composite_product->cost() * $cproductInOffer->quantity) ;                   
                }                
                
                $products = offer_products::where('offer_id',$request->offer_id)->get();
                foreach ($products as $productInOffer) 
                {

                    $Purchasing_price = products::find($productInOffer->product_id)->Purchasing_price;           
                    invoice_products::create([
                        'invoice_id'       => $request->invoice_id,
                        'product_id'       => $productInOffer->product_id,
                        'product_quantity' => $productInOffer->product_quantity,
                        'product_Purchasing_price' => $Purchasing_price,
                        'product_selling_price'    => $productInOffer->product_price,
                    ]);
                    $sales_cost += ($Purchasing_price * $productInOffer->product_quantity) ;

                    if($invoice->type == 1)
                    {
                        $productInStock = products::find($productInOffer->product_id); 
                        $productInStock->quantity = $productInStock->quantity - $productInOffer->product_quantity;
                        $productInStock->update();  
                    }
                }

                $services = OfferService::where('offer_id',$request->offer_id)->get();
                foreach ($services as $service) 
                {
                    InvoiceService::create([
                        'invoice_id'       => $invoice->id,
                        'details' => $service->details,
                        'price' => $service->price,
                    ]);
                }

                if($invoice->type == 1)
                {
                    $day = day::find($invoice->day_id);
                    $day->day2()->forceDelete();

                    $day->update([
                        'date' => $invoice->date,
                        'note' => "فاتورة مبيعات رقم " . " " . $invoice->id,
                        'type' => 3,
                        'type_name' => 'مبيعات (منتجات)',
                        'type_id' => $invoice->id,
                        'total' => $invoice->total + $invoice->amount_paid ,
                        'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                    ]);

                    if($invoice->Value_Status == 1)
                    {
                        //المخزون
                        DayDetails::create([
                            'date' => $invoice->date,
                            'day_id' => $day->id,
                            'account_id' => $invoice->stock->account_id,
                            'debit' => 0,
                            'credit' => $sales_cost,
                            'note' => "فاتورة مبيعات خارج التكلفة رقم " . " " . $request->invoice_id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
        
                        if($invoice->value_added > 0)
                        {
                            DayDetails::create([
                                'date' => $invoice->date,
                                'day_id' => $day->id,
                                'account_id' => 48,
                                'debit' => 0,
                                'credit' => $invoice->value_added,
                                'note' => " ضريبة القيمة المضافة لفاتورة مبيعات خارج التكلفة رقم" . " " . $request->invoice_id,
                                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                            ]);
                        }
        
                        DayDetails::create([
                            'date' => $invoice->date,
                            'day_id' => $day->id,
                            'account_id' => 288,
                            'debit' => $invoice->value_added + $sales_cost ,
                            'credit' =>0,
                            'note' => "  فاتورة مبيعات خارج التكلفة رقم " . " " . $invoice->id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
                    }else
                    {
                        //المبيعات
                        DayDetails::create([
                            'date' => $invoice->date,
                            'day_id' => $day->id,
                            'account_id' => 36,
                            'debit' => 0,
                            'credit' => $invoice->sub_total,
                            'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
                        //المخزون
                        DayDetails::create([
                            'date' => $invoice->date,
                            'day_id' => $day->id,
                            'account_id' => $invoice->stock->account_id,
                            'debit' => 0,
                            'credit' => $sales_cost,
                            'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
                        //تكلفة البضاعة المباعه
                        DayDetails::create([
                            'date' => $invoice->date,
                            'day_id' => $day->id,
                            'account_id' => 111,
                            'debit' => $sales_cost,
                            'credit' => 0,
                            'note' => "فاتورة مبيعات رقم " . " " . $request->invoice_id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
                        // الضرائب
                        if($invoice->value_added > 0)
                        {
                            DayDetails::create([
                                'date' => $invoice->date,
                                'day_id' => $day->id,
                                'account_id' => 48,
                                'debit' => 0,
                                'credit' => $invoice->value_added,
                                'note' => " ضريبة القيمة المضافة لفاتورة مبيعات رقم" . " " . $request->invoice_id,
                                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                            ]);
                        }
                        $services = OfferService::where('offer_id',$invoice->offer_id)->get();   
                        $t_services = 0; 
                        foreach ($services as $service) 
                        {
                            DayDetails::create([
                                'date' => $invoice->date,
                                'day_id' => $day->id,
                                'account_id' => 294,
                                'debit' => 0,
                                'credit' => $service->price,
                                'note' => $service->details,
                                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                            ]);
                            $t_services += $service->price;
                        }
                        // الخصم الممنوح
                        if($invoice->discount > 0)
                        {
                            DayDetails::create([
                                'date' => $invoice->date,
                                'day_id' => $day->id,
                                'account_id' => 109,
                                'debit' => $invoice->sub_total * ($invoice->discount / 100),
                                'credit' => 0,
                                'note' => " الخصم الممنوح لفاتورة مبيعات رقم" . " " . $request->invoice_id,
                                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                            ]);
                        }
        
                        // المورد
                        DayDetails::create([
                            'date' => $invoice->date,
                            'day_id' => $day->id,
                            'account_id' => $invoice->client->id,
                            'debit' => $t_services + $invoice->sub_total + $invoice->value_added - ($invoice->sub_total * ($invoice->discount / 100)),
                            'credit' => 0,
                            'note' => "فاتورة مبيعات رقم" . " " . $request->invoice_id,
                            'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                        ]);
        
                        if($invoice->amount_paid > 0 && $invoice->account_id != null)
                        {
                            DayDetails::create([
                                'date' => $invoice->date,
                                'day_id' => $day->id,
                                'account_id' => $invoice->client->id,
                                'debit' => 0,
                                'credit' => $invoice->amount_paid,
                                'note' => " مدفوعات فاتورة مبيعات رقم " . " " . $invoice->id,
                                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                            ]);
            
                            DayDetails::create([
                                'date' => $invoice->date,
                                'day_id' => $day->id,
                                'account_id' => $invoice->account_id,
                                'debit' => $invoice->amount_paid,
                                'credit' =>0,
                                'note' => " مدفوعات فاتورة مبيعات رقم" . " " . $invoice->id,
                                'cost_id' => $invoice->cost_id ? $invoice->cost_id : null ,
                            ]);
                        }
                    }
                }
            } 
        }catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/InvoiceDetails/'.$request->invoice_id)->with('message',"تم اضافه الفاتورة");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice_products  $invoice_products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clients  = AllAccount::whereIn('parent_id',[18,5])->get();
        $accounts = AllAccount::banking()->get();
        $costs    = Cost::all();
        $stocks   = Stock::all();
        $invoice  = invoices::where('id',$id)->first();
        $attachments = invoice_attachments::where('invoice_id',$id)->get();
        $tickets = Ticket::get('id');
        return view('invoices.details_invoice',compact('stocks','attachments','clients','accounts','costs','invoice','tickets'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try{
            $invoice = invoices::find($request->id);
            if($invoice->type == 1)
            {
                foreach ($invoice->invoice_products as $productInInvoice) 
                {
                    $productInStock = products::find($productInInvoice->product_id);             
                    $productInStock->quantity = $productInStock->quantity + $productInInvoice->product_quantity;
                    $productInStock->update();
                }

                foreach ($invoice->c_products as $product) 
                {
                    $productInStock = products::find($product->id);             
                    $productInStock->quantity = $productInStock->quantity + $product->pivot->quantity;
                    $productInStock->update();
                }

                DayDetails::where('day_id',$invoice->day_id)->delete();
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
        return redirect('/invoices')->with('delete',"تم حذف الفاتورة بنجاح");
    }
    

    public function getoffer($id)
    {
        $offer = offers::find($id);
        $discount = $offer->discount;
        $address = $offer->address;
        $ticket_id = $offer->ticket_id;
        $discount = $offer->discount;
        $products = offer_products::where('offer_id',$id)->get();
        $services = OfferService::where('offer_id',$id)->get();
        $c_products = OfferCompositeProducts::where('offer_id',$id)->get();
        $total = $profit = $c_sales = $t_service = 0;
        foreach($products as $product)
        {
            $total = $total + ($product->product_quantity * $product->product_price );
            $Purchasing_price = products::where('id',$product->product_id)->value('Purchasing_price');
            $profit = $profit + ( ($product->product_price - $Purchasing_price) * $product->product_quantity ) ;
            $c_sales += $Purchasing_price;
        }
        foreach($c_products as $product)
        {
            $total = $total + ($product->selling_price * $product->quantity);
            $composite_prodcut = CompositeProduct::find($product->coposite_product_id);
            $Purchasing_price = $profit = 0;
            foreach($composite_prodcut->products as $pr)
            {
                $Purchasing_price += products::where('id',$pr->product_id)->value('Purchasing_price');
            }
            $profit = $profit + ( ($product->selling_price - $Purchasing_price) * $product->quantity) ;
            $c_sales += $Purchasing_price;
        }
        
        foreach($services as $service)
        {
            $t_service = $t_service  + $service->price;
        }
        $offer_data['t_service'] = $t_service;
        $offer_data['total']    = $total;
        $offer_data['profit']   = $profit - ($profit * ($discount / 100));
        $offer_data['discount'] = $discount;
        $offer_data['c_sales']  = $c_sales;
        $offer_data['address']  = $address;
        $offer_data['ticket_id']  = $ticket_id;
        return json_encode($offer_data);
    }

    public function invoicesExcel(Request $request)
    {
        $invoices = invoices::where(function($query)use($request){
                $query->where('id', $request->search)
                ->orWhere('id', $request->search)
                ->orWhereHas('client',function($q)use($request){
                    $q->where('name','like','%'.$request->search.'%');
                });
            })->when($request->selectedStock,function($q)use($request){
                $q->whereHas('stock' , function($q)use($request){
                    $q->where('stock_id', '=', $request->stock_id);
                });
            })->when($request->offer_id,function($q)use($request){
                $q->where('offer_id',$request->offer_id);
            })->orderBy('id', 'desc')->get();

        $i = 0;
        $data = [];

        $data[] = [
            'م' => 'م',
            'رقم الفاتورة' => 'رقم الفاتورة',
            'رقم اذن الصرف' => 'رقم اذن الصرف',
            'التاريخ' => 'التاريخ',
            'الحالة' => 'الحالة',
            'النوع' => 'النوع',
            'العميل' => 'العميل',
            'الاجمالى' => 'الاجمالى',
            'المخزن' => 'المخزن',
        ];
        
        foreach($invoices as $invoice)
        {
            $i++;
            $data[] = [
                'م' => $i,
                'رقم الفاتورة' => $invoice->id,
                'رقم اذن الصرف' => $invoice->p_num ?? '',
                'التاريخ' => $invoice->date ?? '', 
                'النوع' => $invoice->type ? 'مؤكدة':'غير مؤكدة',
                'الحالة' => $invoice->Status ?? '',
                'العميل' => $invoice->client->name ?? '',
                'الاجمالى' => $invoice->total ?? '',
                'المخزن' => $invoice->stock->name ?? '',
            ];
        }
        
        return Excel::download(new DataExport($data),'invoices.xlsx');
    }
}
