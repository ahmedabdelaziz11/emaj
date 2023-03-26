<?php

namespace App\Http\Controllers;

use App\Models\CashReceipt;
use App\Models\clients;
use App\Models\expense_sections;
use App\Models\expenses;
use App\Models\invoices;
use App\Models\checks;
use App\Models\offers;
use App\Models\products;
use App\Models\receipts;
use App\Models\returned_invoice;
use App\Models\spare_invoices;
use App\Models\spare_receipts;
use App\Models\spares;
use App\Models\sreturned_invoice;
use App\Models\suppliers;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\MaintenanceRevenue;
use App\Models\CustomerDiscount;
use App\Models\PaymentVoucher;

class Offers_Report extends Controller 
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){

        return view('reports.Offers_Report');          
    }

    public function revenues_report()
    {
        return view('reports.revenues_Report');          
    }

    public function search_revenue(Request $request)
    {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);      
        $offers = MaintenanceRevenue::whereBetween('date',[$start_at,$end_at])->get();
        return view('reports.revenues_Report',compact('start_at','end_at','offers'));    
    }


    public function value_added_report()
    {
        return view('reports.value_added');
    }

    public function Search_value_added(Request $request)
    {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);   
        $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->sum('total');
        $invoices_count = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->count();

        $spare_invoices = spare_invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->sum('total');
        $sinvoices_count= spare_invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->count();

        $receipts = receipts::whereBetween('receipt_date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->sum('total');
        $receipts_count = receipts::whereBetween('receipt_date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->count();

        $spare_receipts = spare_receipts::whereBetween('receipt_date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->sum('total');
        $sreceipts_count= spare_receipts::whereBetween('receipt_date',[$start_at,$end_at])->where('type',1)->where('value_added',1)->count();

        return view('reports.value_added',
        compact('invoices','start_at','end_at','invoices_count','spare_invoices','sinvoices_count','receipts','receipts_count','spare_receipts','sreceipts_count'));
    }

    public function Search_offers(Request $request)
    {                      
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);      
        $offers = offers::whereBetween('offer_Date',[$start_at,$end_at])->get();
        return view('reports.offers_report',compact('start_at','end_at','offers'));        
    }  

    public function checks_report()
    {
        return view('reports.checks');
    }
    
    public function search_checks(Request $request) 
    {
        if($request->status == 0)
        {
            $status = "غير مؤكدة";
        }
        else{
            $status = "مؤكدة";
        }

        $checks = checks::where('type',$request->type)->where('status',$status)->get();
        return view('reports.checks',compact('checks'));
    }

    
    public function expenses2(){
        $expenses = expense_sections::all();
        return view('reports.expenses2_report',compact('expenses'));          
    }

    public function assets(){
        return view('reports.assets');          
    }   

    public function Search_expenses2(Request $request)
    {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        $expenses = expense_sections::all();
        if($request->rdio == 2)
        {
            if($request->expense_id == 0){
                $expenses_data = expenses::where('type',1)->whereBetween('date',[$start_at,$end_at])->get();
            }
            else{
                $expenses_data = expenses::where('type',1)->whereBetween('date',[$start_at,$end_at])->where('section_id','=',$request->expense_id)->get();
            }
        }
        elseif($request->rdio == 1)
        {
            if($request->expense_id == 0){
                $expenses_data = expenses::where('type',1)->where('spare',1)->whereBetween('date',[$start_at,$end_at])->get();
            }
            else{
                $expenses_data = expenses::where('type',1)->where('spare',1)->whereBetween('date',[$start_at,$end_at])->where('section_id','=',$request->expense_id)->get();
            }
        }
        elseif($request->rdio == 0)
        {
            if($request->expense_id == 0){
                $expenses_data = expenses::where('type',1)->where('spare',0)->whereBetween('date',[$start_at,$end_at])->get();
            }
            else{
                $expenses_data = expenses::where('type',1)->where('spare',0)->whereBetween('date',[$start_at,$end_at])->where('section_id','=',$request->expense_id)->get();
            }
        }

        return view('reports.expenses2_report',compact('start_at','end_at','expenses' ,'expenses_data')); 
    }
    
    public function expenses(){

        $expenses = expense_sections::all();
        return view('reports.expenses_Report',compact('expenses'));          
    }

    public function Search_expenses(Request $request)
    {   
        $expenses = expense_sections::all();
        $year = $request->year;
        $section_id = $request->expense_id;

        if($section_id == 0)
        {
            $expense_name = "جميع النفقات";
            for($i = 1 ; $i <= 12 ; $i++ )
            {
                $expenses_data[] = expenses::where('type',1)->whereYear('date','=',$year)->whereMonth('date','=',$i)->sum('price');
            }
        }else{
            $expense = expense_sections::find($section_id);
            $expense_name = $expense->section_name;
            for($i = 1 ; $i <= 12 ; $i++ )
            {
                $expenses_data[] = expenses::where('type',1)->where('section_id','=',$section_id)->whereYear('date','=',$year)->whereMonth('date','=',$i)->sum('price');
            }

        }

            $chartjs = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 500, 'height' => 150])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July','august','septemer','october','november','december'])
            ->datasets([
                [
                    "label" => $expense_name,
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $expenses_data,
                ],
    
            ])
            ->options([]);
            return view('reports.expenses_report',compact('chartjs','expenses','expenses_data','expense_name','year'));              
    } 

    public function invoice_report(){
        return view('reports.invoices_report');          
    }

    public function Search_invoice(Request $request)
    {                      
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);      
        $invoices = invoices::where('type',1)->whereBetween('invoice_Date',[$start_at,$end_at])->get();
        return view('reports.invoices_report',compact('start_at','end_at','invoices'));        
    } 
    
    public function invoice_report_s(){
        $clients = clients::all();
        return view('reports.sinvoices_report',compact('clients'));          
    }

    public function Search_invoice_s(Request $request)
    {               
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);   
        $clients = clients::all();
        $invoices = spare_invoices::where('type',1)->whereBetween('invoice_Date',[$start_at,$end_at]);
        if($request->client_id != 0)
        {
            $invoices = $invoices->where('client_id',$request->client_id);
        }
        if($request->type != 1)
        {
            $invoices = $invoices->where('Value_Status',$request->type);
        }
        $invoices = $invoices->get();
        return view('reports.sinvoices_report',compact('start_at','end_at','invoices','clients'));        
    }  

    public function client_report(){
        $clients = clients::all();
        return view('reports.clients_report',compact('clients'));          
    }

    public function Search_client(Request $request)
    {    
        $client_id = $request->client_id;
        $client = clients::find($client_id);
        $client_name = $client->client_name; 
        $client_debt = $client->debt;
        $clients = clients::all();
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);    

        $invoices = invoices::where('client_id',$client_id)->where('invoice_Date','<',$start_at)->where('type',1)->get();                
        $spare_invoices = spare_invoices::where('client_id',$client_id)->where('invoice_Date','<',$start_at)->where('type',1)->get(); 
        $returned_invoice = returned_invoice::where('client_id',$client_id)->where('invoice_Date','<',$start_at)->where('type',1)->get(); 
        $sreturned_invoice = sreturned_invoice::where('client_id',$client_id)->where('invoice_Date','<',$start_at)->where('type',1)->get(); 
        $cachs = CashReceipt::where('person_id',$client_id)->where('Value_Status',0)->where('date','<',$start_at)->get(); 
        $payments = PaymentVoucher::where('person_id',$client_id)->where('Value_Status',0)->where('date','<',$start_at)->get(); 
        $discount = CustomerDiscount::where('client_id',$client_id)->where('date','<',$start_at)->get(); 

 
        $invoices = $invoices->concat($spare_invoices);
        $invoices = $invoices->concat($returned_invoice);
        $invoices = $invoices->concat($sreturned_invoice);
        $invoices = $invoices->concat($cachs);
        $invoices = $invoices->concat($payments);
        $invoices = $invoices->concat($discount);
        $invoices = $invoices->sortBy('created_at')->values()->all();
        $start_debt = 0;
        foreach($invoices as $x)
        {
            if($x->Status == "فاتورة بيع قطع غيار بالضمان" || $x->Status == "فاتورة مرتجعات بيع قطع الغيار بالضمان")
            {
                $start_debt = $start_debt ;
            }
            elseif($x->Status == "فاتورة مرتجعات بيع منتجات" || $x->Status == "فاتورة مرتجعات بيع قطع الغيار")
            {
                $start_debt = $start_debt - $x->total ;
            }
            elseif($x->Value_Status == 0 && $x->type == "سند قبض من عميل")
            {
                $start_debt = $start_debt - $x->amount ;
            }
            elseif($x->Value_Status == 0 && $x->type == "سند صرف من عميل")
            {
                $start_debt = $start_debt + $x->amount ;
            }
            elseif($x->model_type == "discount")
            {
                $start_debt = $start_debt - $x->amount ;
            }
            else{
                $start_debt = $start_debt + ($x->total - $x->amount_paid);
            }
        }
        $start_debt = $start_debt + $client->start_debt;

        $invoices = invoices::where('client_id',$client_id)->whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->get();  
        $invoices = $invoices->map(function($q)
        {
            $q['model_type'] = "product";
            return $q;
        });              
        $spare_invoices = spare_invoices::where('client_id',$client_id)->whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->get(); 
        $spare_invoices = $spare_invoices->map(function($q)
        {
            $q['model_type'] = "spare";
            return $q;
        });
        $returned_invoice = returned_invoice::where('client_id',$client_id)->whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->get(); 
        $returned_invoice = $returned_invoice->map(function($q)
        {
            $q['model_type'] = "product";
            return $q;
        });   
        
        $discount = CustomerDiscount::where('client_id',$client_id)->whereBetween('date',[$start_at,$end_at])->get(); 
        foreach($discount as $x)
        {
            $x->invoice_Date = $x->date;
        } 
        $sreturned_invoice = sreturned_invoice::where('client_id',$client_id)->whereBetween('invoice_Date',[$start_at,$end_at])->where('type',1)->get(); 
        $sreturned_invoice = $sreturned_invoice->map(function($q)
        {
            $q['model_type'] = "spare";
            return $q;
        });

        $cachs = CashReceipt::where('person_id',$client_id)->where('Value_Status',0)->whereBetween('date',[$start_at,$end_at])->get(); 
        foreach($cachs as $x)
        {
            $x->invoice_Date = $x->date;
            $x->model_type = "cash";
        } 

        $payments = PaymentVoucher::where('person_id',$client_id)->where('Value_Status',0)->whereBetween('date',[$start_at,$end_at])->get(); 
        foreach($cachs as $x)
        {
            $x->invoice_Date = $x->date;
            $x->model_type = "payment";
        } 
        
        $invoices = $invoices->concat($spare_invoices);
        $invoices = $invoices->concat($returned_invoice);
        $invoices = $invoices->concat($sreturned_invoice);
        $invoices = $invoices->concat($discount);
        $invoices = $invoices->concat($cachs);
        $invoices = $invoices->concat($payments);
        
        $invoices = $invoices->sortBy('invoice_Date')->values()->all();
        return view('reports.clients_report',compact('start_at','end_at','invoices','clients','client_name','client_debt','start_debt'));        
    }
    
    public function supplier_report(){
        $suppliers = suppliers::all();
        return view('reports.suppliers_report',compact('suppliers'));          
    }

    public function Search_supplier(Request $request)
    {    
        $supplier_id = $request->supplier_id;
        $supplier = suppliers::find($supplier_id);
        $supplier_name = $supplier->name;
        $supplier_debt = $supplier->debt; 
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        $suppliers = suppliers::all();
        $receipts = receipts::where('supplier_id',$supplier_id)->where('receipt_date','<',$start_at)->where('type',1)->get(); 
        $spare_receipts = spare_receipts::where('supplier_id',$supplier_id)->where('receipt_date','<',$start_at)->where('type',1)->get();
        $cachs = CashReceipt::where('person_id',$supplier_id)->where('Value_Status',1)->where('date','<',$start_at)->get(); 
        $payments = PaymentVoucher::where('person_id',$supplier_id)->where('Value_Status',1)->where('date','<',$start_at)->get(); 
        $receipts = $receipts->concat($spare_receipts);
        $receipts = $receipts->concat($cachs);
        $receipts = $receipts->concat($payments);
        $receipts = $receipts->sortBy('created_by')->values()->all();
        $start_debt = 0;
        foreach($receipts as $x)
        {
            if($x->type == "سند قبض من مورد")
            {
                $start_debt = $start_debt + $x->amount;
            }
            if($x->type == "سند صرف من مورد")
            {
                $start_debt = $start_debt - $x->amount;
            }
            $start_debt = $start_debt + ($x->total - $x->amount_paid);
        }
        $start_debt = $start_debt + $supplier->start_debt;
        $receipts = receipts::where('supplier_id',$supplier_id)->whereBetween('receipt_date',[$start_at,$end_at])->where('type',1)->get(); 
        $receipts = $receipts->map(function($q)
        {
            $q['model_type'] = "product";
            return $q;
        });
        $spare_receipts = spare_receipts::where('supplier_id',$supplier_id)->whereBetween('receipt_date',[$start_at,$end_at])->where('type',1)->get();
        $spare_receipts = $spare_receipts->map(function($q)
        {
            $q['model_type'] = "spare";
            return $q;
        });
        $cachs = CashReceipt::where('person_id',$supplier_id)->where('Value_Status',1)->whereBetween('date',[$start_at,$end_at])->get(); 
        foreach($cachs as $x)
        {
            $x->receipt_date = $x->date;
            $x->model_type = "cash";
        } 

        $payments = PaymentVoucher::where('person_id',$supplier_id)->where('Value_Status',1)->whereBetween('date',[$start_at,$end_at])->get(); 
        foreach($cachs as $x)
        {
            $x->receipt_date = $x->date;
            $x->model_type = "payment";
        } 
        $receipts = $receipts->concat($spare_receipts);
        $receipts = $receipts->concat($cachs);
        $receipts = $receipts->concat($payments);
        $receipts = $receipts->sortBy('receipt_date')->values()->all();
        return view('reports.suppliers_report',compact('suppliers','supplier_name','supplier_debt','start_at','end_at','receipts','start_debt'));          

    }

    public function products_report()
    {
        $products = products::where('quantity','>',0)->get(['id','name','quantity','selling_price','Purchasing_price']);
        return view('reports.products_report',compact('products'));
    }

    public function spares_report()
    {
        $products = spares::where('quantity','>',0)->get(['id','name','quantity','selling_price','Purchasing_price']);
        return view('reports.spares_report',compact('products'));
    }

    public function clients_report()
    {
        $clients = clients::where('debt','!=',0)->get(['id','client_name','debt']);
        return view('reports.clientsd_report',compact('clients'));

    }

    public function suppliers_report()
    {
        $suppliers = suppliers::where('debt','!=',0)->get(['id','name','debt']);
        return view('reports.suppliersd_report',compact('suppliers'));

    }
}

    