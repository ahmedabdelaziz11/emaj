<?php
namespace App\Http\Controllers;

use App\Exports\BalanceSheetExport;
use App\Models\invoice_products;
use App\Models\offer_products;
use App\Models\products;
use App\Models\receipt_products;
use App\Models\sections;
use App\Models\Stock;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DayDetails;
use App\Models\receipts;
use App\Models\returned_products;
use App\Models\ReturnedReceiptProducts;

class ProductsController extends Controller
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
        $sections = sections::all();
        $stocks = Stock::all();
        return view('products.products',compact('sections','stocks'));
    }

    public function show($id)
    {

        $product = products::find($id);

        $invoices = invoice_products::where('product_id',$id)->whereHas('invoice', function ($query) {
            return $query->where('type', '=', 1);
        })->get();        

        $returned_invoice = returned_products::where('product_id',$id)->get(); 

        $receipts = receipt_products::where('product_id',$id)->whereHas('receipt', function ($query) {
            return $query->where('type', '=', 1);
        })->get(); 
        
        $returned_receipts = ReturnedReceiptProducts::where('product_id',$id)->get(); 

        $invoices = $invoices->concat($returned_invoice);
        $invoices = $invoices->concat($returned_receipts);
        $invoices = $invoices->concat($receipts);
        $invoices = $invoices->sortBy('created_at')->values()->all();
        return view('products.show',compact('product','invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:products|max:255'],['name.unique' =>'اسم المنتج مسجل مسبقا',]);
        $file_name = '';
        if ($request->hasFile('pic')) 
        {
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
        }
        $product = products::create([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'description' => $request->description,
            'description_en' => $request->description_en,
            'Purchasing_price' => $request->Purchasing_price,
            'selling_price' => $request->selling_price,
            'quantity' => $request->start_quantity,
            'start_quantity' => $request->start_quantity,
            'section_id' => $request->section_id,
            'image' => $file_name,
        ]);

        if ($request->hasFile('pic')) 
        {
            $request->pic->move(public_path('Attachments/products/' . $product->id), $file_name);
        }
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, ['name' => 'required|max:255|unique:products,name,'.$request->id,],['name.unique' =>'اسم المنتج مسجل مسبقا',]);
        
        $product = products::find($request->id);

        $quantity = $product->quantity - $product->start_quantity;
        $quantity += $request->start_quantity;

        $file_name = '';
        if ($request->hasFile('pic')) 
        {
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
        }
        $product->update([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'description' => $request->description,
            'description_en' => $request->description_en,
            'section_id' => $request->section_id,                
            'Purchasing_price' => $request->Purchasing_price,
            'selling_price' => $request->selling_price,
            'start_quantity' => $request->start_quantity,
            'quantity' => $quantity,
            'image' => $file_name,
        ]);
        if ($request->hasFile('pic')) 
        {
            $request->pic->move(public_path('Attachments/products/' . $product->id), $file_name);
        }
        session()->flash('edit','تم تعديل المنتج بنجاج');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $product = products::find($id);
        $count_1 = invoice_products::where('product_id',$product->id)->count();
        $count_2 = receipt_products::where('product_id',$product->id)->count();
        $count_3 = offer_products::where('product_id',$product->id)->count();
        $count = $count_1 + $count_2 + $count_3;
        if($count == 0)
        {
            $product->delete();
            session()->flash('delete','تم حذف المنتج بنجاح');
        }
        else{
            session()->flash('c_delete','تم حذف المنتج بنجاح');
        }
        return back();
    }

    public function product_cat($id)
    {
        $products = products::where('section_id',$id)->get();
        $sections = sections::all();
        return view('products.products_cat',compact('sections','products'));

    }
    public function downloadSheet(Request $request)
    {      
        $f_data = [];
        $f_data[] = [
            'م' => 'م',
            'اسم المنتج' => 'اسم المنتج',
            'سعر الشراء' => 'سعر الشراء',
            'سعر البيع' => 'سعر البيع',
            'الكمية' => 'الكمية',
            'الاجمالى' => 'الاجمالى' ,
        ];
        $c = 0;
        foreach($request->name as $index => $x)
        {
            $c++;
            $f_data[] = [
                'م' => $c,
                'اسم المنتج' => $request->name[$index],
                'سعر الشراء' => $request->Purchasing_price[$index],
                'سعر البيع' => $request->selling_price[$index],
                'الكمية' => $request->quantity[$index],
                'الاجمالى' => $request->quantity[$index] * $request->selling_price[$index],
            ];
        }
        return Excel::download(new BalanceSheetExport($f_data), $request->stock_name.'.xlsx');
    }
}
