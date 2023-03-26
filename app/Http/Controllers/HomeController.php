<?php

namespace App\Http\Controllers;
use App\Models\AllAccount;
use App\Models\DayDetails;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        $accounts = AllAccount::where('parent_id',26)->get(); // ايرادات
        $acc_ids = [];
        foreach($accounts as $acc1)
        {

            $acc_ids[] = $acc1->id;
            if($acc1->accounts->count() > 0)
            {
                foreach($acc1->accounts as $acc2)
                {
                    $acc_ids[] = $acc2->id;
                    if($acc2->accounts->count() > 0)
                    {
                        foreach($acc2->accounts as $acc3)
                        {
                            $acc_ids[] = $acc3->id;
                            if($acc3->accounts->count() > 0)
                            {
                                foreach($acc3->accounts as $acc4)
                                {
                                    $acc_ids[] = $acc4->id;
                                    if($acc4->accounts->count() > 0)
                                    {
                                        foreach($acc4->accounts as $acc5)
                                        {
                                            $acc_ids[] = $acc5->id;
                                            if($acc5->accounts->count() > 0)
                                            {
                                                foreach($acc5->accounts as $acc6)
                                                {
                                                    $acc_ids[] = $acc6->id;
                                                    if($acc6->accounts->count() > 0)
                                                    {
                                                        foreach($acc6->accounts as $acc7)
                                                        {
                                                            $acc_ids[] = $acc7->id;
                                                            if($acc7->accounts->count() > 0)
                                                            {
                                                                foreach($acc7->accounts as $acc8)
                                                                {
                                                                    $acc_ids[] = $acc8->id;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        $profits = DayDetails::whereIn('account_id',$acc_ids)
        ->whereYear('date', '=', date('Y'))
        ->select(DB::raw('MONTH(date) as month ,sum(credit - debit) as total'))
        ->groupBy(DB::raw('MONTH(date) DESC'))->get();

        $accounts = AllAccount::where('parent_id',29)->get(); // المصروفات
        $acc_ids = [];
        foreach($accounts as $acc1)
        {

            $acc_ids[] = $acc1->id;
            if($acc1->accounts->count() > 0)
            {
                foreach($acc1->accounts as $acc2)
                {
                    $acc_ids[] = $acc2->id;
                    if($acc2->accounts->count() > 0)
                    {
                        foreach($acc2->accounts as $acc3)
                        {
                            $acc_ids[] = $acc3->id;
                            if($acc3->accounts->count() > 0)
                            {
                                foreach($acc3->accounts as $acc4)
                                {
                                    $acc_ids[] = $acc4->id;
                                    if($acc4->accounts->count() > 0)
                                    {
                                        foreach($acc4->accounts as $acc5)
                                        {
                                            $acc_ids[] = $acc5->id;
                                            if($acc5->accounts->count() > 0)
                                            {
                                                foreach($acc5->accounts as $acc6)
                                                {
                                                    $acc_ids[] = $acc6->id;
                                                    if($acc6->accounts->count() > 0)
                                                    {
                                                        foreach($acc6->accounts as $acc7)
                                                        {
                                                            $acc_ids[] = $acc7->id;
                                                            if($acc7->accounts->count() > 0)
                                                            {
                                                                foreach($acc7->accounts as $acc8)
                                                                {
                                                                    $acc_ids[] = $acc8->id;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        $expenses = DayDetails::whereIn('account_id',$acc_ids)
        ->whereYear('date', '=', date('Y'))
        ->select(DB::raw('MONTH(date) as month ,sum(debit - credit) as total'))
        ->groupBy(DB::raw('MONTH(date) DESC'))->get();

        $expenses_per_month = array_values(array_fill(1, 12, 0));

        foreach ($expenses as $e) {
            $expenses_per_month[$e->month - 1] = $e->total;
        }

        $profits_per_month = array_values(array_fill(1, 12, 0));

        foreach ($profits as $e) {
            $profits_per_month[$e->month - 1] = $e->total;
        }

        $all_profit_after_expenses = array_map(function ($x, $y) {
            return $y - $x;
        }, $expenses_per_month, $profits_per_month);

        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 500, 'height' => 150])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July','august','septemer','october','november','december'])
        ->datasets([
            [
                "label" => "اجمالى الارباح",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' =>  $all_profit_after_expenses ,
    
            ],
        ])
        ->options([]);
        $stockNames = [];
        $stockValues = [];
        $stocks = Stock::all();
        foreach($stocks as $stock)
        {
            $value  = $stock->products()->select(DB::raw('sum(Purchasing_price * quantity  ) as total'))->value('total');
            $stockNames[] = $stock->name;
            $stockValues[] = $value;
        }

        $clients = AllAccount::find(5)->accounts->pluck('id');

        $balance1 = DayDetails::whereIn('account_id',$clients)->select(DB::raw('sum(debit - credit) as total'))->value('total');
    
        $balance2 = AllAccount::whereIn('id',$clients)->select(DB::raw('sum(start_debit - start_credit) as total'))->value('total');
    
        $c_balance = $balance1 + $balance2;    
        
        $clients = AllAccount::find(18)->accounts->pluck('id');

        $balance1 = DayDetails::whereIn('account_id',$clients)->select(DB::raw('sum(debit - credit) as total'))->value('total');
    
        $balance2 = AllAccount::whereIn('id',$clients)->select(DB::raw('sum(start_debit - start_credit) as total'))->value('total');
    
        $s_balance = $balance1 + $balance2;    
        
        $clients = AllAccount::find(6)->accounts->pluck('id');

        $balance1 = DayDetails::whereIn('account_id',$clients)->select(DB::raw('sum(debit - credit) as total'))->value('total');
    
        $balance2 = AllAccount::whereIn('id',$clients)->select(DB::raw('sum(start_debit - start_credit) as total'))->value('total');
    
        $a_balance = $balance1 + $balance2;   

        $clients1 = AllAccount::find(3)->accounts->pluck('id');
        $clients2 = AllAccount::find(58)->accounts->pluck('id');

        $balance5 = DayDetails::whereIn('account_id',$clients1)->orWhereIn('account_id',$clients2)->select(DB::raw('sum(debit - credit) as total'))->value('total');
    
        $balance5 += AllAccount::whereIn('id',$clients1)->orWhereIn('id',$clients2)->select(DB::raw('sum(start_debit - start_credit) as total'))->value('total');
    
        $b_balance = $balance5;   
        
        $balance1 = DayDetails::where('account_id',45)->select(DB::raw('sum(debit - credit) as total'))->value('total');
    
        $balance2 = AllAccount::where('id',45)->select(DB::raw('sum(start_debit - start_credit) as total'))->value('total');
    
        $m_balance = $balance1 + $balance2; 

        $balance1 = DayDetails::where('account_id',48)->select(DB::raw('sum(debit - credit) as total'))->value('total');
    
        $balance2 = AllAccount::where('id',48)->select(DB::raw('sum(start_debit - start_credit) as total'))->value('total');
    
        $t_balance = $balance1 + $balance2; 
        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels($stockNames)
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => $stockValues,
                ]
            ])
            ->options([]);

        return view('home', compact('chartjs','chartjs_2','c_balance','s_balance','a_balance','b_balance','t_balance','m_balance'));
    }
}
