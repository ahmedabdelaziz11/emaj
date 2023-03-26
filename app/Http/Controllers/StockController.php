<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\Stock;
use Illuminate\Http\Request;
use App\Exports\BalanceSheetExport;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
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
        $accounts = AllAccount::all();
        $stocks = Stock::all();
        return view('stocks.index',compact('stocks','accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Stock::create($request->all());
        session()->flash('mss', 'تم اضافة المخزن بنجاح ');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        return json_encode($stock->sections->pluck('name','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $stock = Stock::find($request->id)->update($request->all());
        session()->flash('mss', 'تم تعديل المخزن بنجاح ');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $stock = Stock::find($request->id);
        
        if($stock->sections->count() == 0)
        {
            $stock->delete();
            session()->flash('delete','تم حذف المخزن بنجاح');
        }
        else{
            session()->flash('c_delete','تم حذف المخزن بنجاح');
        }
        return back();
    }

    public function stockReport()
    {
        $stocks = Stock::all();
        return view('stocks.stock-report',compact('stocks'));
    }

    public function createStockReport(Request $request)
    {
        $type = $request->type;
        $stocks = Stock::all();
        $stock = Stock::find($request->stock_id);
        return view('stocks.stock-report',compact('stocks','stock','type'));

    }

    public function exel($id)
    {
        $stock = Stock::find($id);

        $f_data = [];
        $f_data[] = [
            'الكود' => 'الكود',
            'الاسم' => 'الاسم',
            'name' => 'name',
            'سعر الشراء' => 'سعر الشراء',
            'سعر البيع	' => 'سعر البيع	',
            'الكمية الافتتاحية' => 'الكمية الافتتاحية',
            'الكمية' => 'الكمية',
            'القسم' => 'القسم',
        ];

        foreach($stock->products as $x)
        {
            if($x->quantity > 0)
            {
                $f_data[] = [
                    'الكود' => $x->id,
                    'الاسم' => $x->name,
                    'name' => $x->name_en,
                    'سعر الشراء' => $x->Purchasing_price,
                    'سعر البيع	' => $x->selling_price,
                    'الكمية الافتتاحية' => $x->start_quantity,
                    'الكمية' => $x->quantity,
                    'القسم' => $x->section->name,
                ];
            }
        }
        return Excel::download(new BalanceSheetExport($f_data), $stock->name.'.xlsx');
    }
}
