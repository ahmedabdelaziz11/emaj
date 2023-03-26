<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\DayDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\BalanceSheetExport;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;


class AccountStatementController extends Controller
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
        return view('account-statement.index',compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_date = new DateTime($request->start_at);
        $start_date = $start_date->modify("-1 days")->format('Y-m-d');
        $start_at = $request->start_at ;
        $end_at = $request->end_at;
        $accounts = AllAccount::all();

        if($request->level == 0)
        {
            $account1 = AllAccount::find($request->account_id);
    
            $start_account1 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
            ->where('account_id',$request->account_id)->value('total');
    
            $start_account2 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
            ->where('account_id',$request->account_id)->value('total');
    
            $start_account1 += AllAccount::find($request->account_id)->start_debit;
            $start_account2 += AllAccount::find($request->account_id)->start_credit;
    
            $start_account = $start_account1 - $start_account2;
    
            $days = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])
            ->where('account_id',$request->account_id)->orderBy('date','asc')->get();
            $level = $request->level;
    
            return view('account-statement.index',compact('accounts','start_account','days','account1','start_at','end_at','start_date','level'));
        }elseif($request->level != 0)
        {
            $data = [] ;
            $accountHasntAccounts = [];
            $account1 = AllAccount::find($request->account_id);
            $levelAccounts = AllAccount::find($request->account_id)->accounts->pluck('id')->values();
            $level = $request->level -  1;
            while($level)
            {
                foreach($levelAccounts as $levelAccount)
                {
                    if(AllAccount::find($levelAccount)->accounts->count() == 0)
                    {
                        $accountHasntAccounts[] = $levelAccount;
                    }
                }
                $levelAccounts = AllAccount::whereIn('parent_id',$levelAccounts)->pluck('id')->values();
                $level -- ;
            }
            $levelAccounts = array_merge($levelAccounts->toArray(), $accountHasntAccounts);
            foreach($levelAccounts as $id)
            {
                $acc_ids = [];
                $acc_ids [] = $id;
                $account = AllAccount::find($id);
                foreach($account->accounts as $acc1)
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
                $start_account1 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
        
                $start_account2 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
        
                $start_account1 += AllAccount::find($account->id)->start_debit;
                $start_account2 += AllAccount::find($account->id)->start_credit;
        
                $start_account = $start_account1 - $start_account2;

                $debet = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
        
                $credit = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');

                $balance = ($debet - $credit) + $start_account ;
                if($start_account != 0 || $debet != 0 || $credit != 0)
                {
                    $data [] = [
                        'id' => $account->id,
                        'code' => $account->code,
                        'name' => $account->name,
                        'p_account' => $start_account,
                        'debit' => $debet,
                        'credit' => $credit,
                        'c_account' => $balance,
                    ];
                }
            }
            $level = $request->level;
            return view('account-statement.index',compact('accounts','data','start_at','end_at','start_date','account1','level'));
        }

    }


    public function excel(Request $request)
    {
        $start_date = Carbon::createFromDate(date('Y'), 1, 1)->format('Y-m-d');
        if($request->level == 0)
        {
            $account1 = AllAccount::find($request->account_id);
    
            $start_account1 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
            ->where('account_id',$request->account_id)->value('total');
    
            $start_account2 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
            ->where('account_id',$request->account_id)->value('total');
    
            $start_account1 += AllAccount::find($request->account_id)->start_debit;
            $start_account2 += AllAccount::find($request->account_id)->start_credit;
    
            $start_account = $start_account1 - $start_account2;
    
            $days = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])
            ->where('account_id',$request->account_id)->orderBy('date','asc')->get();
            

            $f_data = [];
            $f_data[] = [
                'التاريخ' => 'التاريخ',
                'البيان' => 'البيان',
                'مدين' => 'مدين',
                'دائن' => 'دائن',
                'رصيد' => 'رصيد',
            ];
            $x = $y = 0;
            if($start_account != 0)
            {
                if($start_account > 0)
                {
                    $x = $start_account ;
                    $y = 0;
                }
                else
                {
                    $x = 0; 
                    $y = $start_account * -1 ;
                }
                $f_data[] = [
                    'التاريخ' => $start_date,
                    'البيان' => 'رصيد دفترى',
                    'مدين' => $x,
                    'دائن' => $y,
                    'رصيد' => $start_account,
                ];
            }

            $total_debit = $total_credit = 0;
            if($start_account > 0)
            {
                $total_debit += $start_account;
            }elseif($start_account < 0){
                $total_credit += (-1 * $start_account); 
            } 
            foreach($days as $x)
            {
                $total_debit +=$x->debit;
                $total_credit += $x->credit;
                $start_account += $x->debit - $x->credit;
                $f_data[] = [
                    'التاريخ' => $x->date,
                    'البيان' => $x->note ?? 'لا يوجد',
                    'مدين' => $x->debit,
                    'دائن' => $x->credit,
                    'رصيد' => $start_account,
                ];
            }

            $f_data[] = [
                'التاريخ' => 'الاجمالى',
                'البيان' => '',
                'مدين' => $total_debit,
                'دائن' => $total_credit,
                'رصيد' => $start_account,
            ];

            return Excel::download(new BalanceSheetExport($f_data), 'balance_sheet.xlsx');
        }
        elseif($request->level != 0)
        {
            $account1 = AllAccount::find($request->account_id);
            $data = [] ;
            $levelAccounts = AllAccount::find($request->account_id)->accounts->pluck('id')->values();
            $level = $request->level -  1;
            while($level)
            {
                $levelAccounts = AllAccount::whereIn('parent_id',$levelAccounts)->pluck('id')->values();
                $level -- ;
            }
            foreach($levelAccounts as $id)
            {
                $acc_ids = [];
                $acc_ids [] = $id;
                $account = AllAccount::find($id);
                foreach($account->accounts as $acc1)
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
                $start_account1 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
        
                $start_account2 = DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
        
                $start_account1 += AllAccount::find($account->id)->start_debit;
                $start_account2 += AllAccount::find($account->id)->start_credit;
        
                $start_account = $start_account1 - $start_account2;

                $debet = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
        
                $credit = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');

                $balance = ($debet - $credit) + $start_account ;
                if($start_account != 0 || $debet != 0 || $credit != 0)
                {
                    $data [] = [
                        'id' => $account->id,
                        'code' => $account->code,
                        'name' => $account->name,
                        'p_account' => $start_account,
                        'debit' => $debet,
                        'credit' => $credit,
                        'c_account' => $balance,
                    ];
                }
            }
            $level = $request->level;

            $f_data = [];
            $f_data[] = [
                'الكود' => 'الكود',
                'الاسم' => 'الاسم',
                'رصيد سابق' => 'رصيد سابق',
                'مدين' => 'مدين',
                'دائن' => 'دائن',
                'رصيد' => 'رصيد',
            ];

            $total_acc = $total_p_acc = $total_debit = $total_credit = 0;
            foreach($data as $x) 
            {
                $total_acc += $x['c_account'];
                $total_p_acc += $x['p_account'];
                $total_debit += $x['debit'];
                $total_credit += $x['credit'];

                $f_data[] = [
                    'الكود' => $x['code'],
                    'الاسم' => $x['name'],
                    'رصيد سابق' => $x['p_account'],
                    'مدين' => $x['debit'],
                    'دائن' => $x['credit'],
                    'رصيد' => $x['c_account'],
                ];
            }
            $f_data[] = [
                'الكود' => 'الاجمالى',
                'الاسم' => '',
                'رصيد سابق' => $total_p_acc,
                'مدين' => $total_debit,
                'دائن' => $total_credit,
                'رصيد' => $total_acc,
            ];

            return Excel::download(new BalanceSheetExport($f_data), 'balance_sheet.xlsx');

        }
    }


    public function accountGraph()
    {
        $accounts = AllAccount::all();
        return view('account-statement.graph',compact('accounts'));
    }


    public function getAccountGraph(Request $request)
    {
        $start_at = $request->start_at ;
        $end_at = $request->end_at;
        $report_name = $request->report_name;

        $allAccounts = AllAccount::whereIn('id',$request->account_ids)->get();

        foreach($allAccounts as $account1)
        {
            $account_ids [] = $account1->id;
            foreach($account1->accounts as $acc2)
            {
                $account_ids[] = $acc2->id;
                if($acc2->accounts->count() > 0)
                {
                    foreach($acc2->accounts as $acc3)
                    {
                        $account_ids[] = $acc3->id;
                        if($acc3->accounts->count() > 0)
                        {
                            foreach($acc3->accounts as $acc4)
                            {
                                $account_ids[] = $acc4->id;
                                if($acc4->accounts->count() > 0)
                                {
                                    foreach($acc4->accounts as $acc5)
                                    {
                                        $account_ids[] = $acc5->id;
                                        if($acc5->accounts->count() > 0)
                                        {
                                            foreach($acc5->accounts as $acc6)
                                            {
                                                $account_ids[] = $acc6->id;
                                                if($acc6->accounts->count() > 0)
                                                {
                                                    foreach($acc6->accounts as $acc7)
                                                    {
                                                        $account_ids[] = $acc7->id;
                                                        if($acc7->accounts->count() > 0)
                                                        {
                                                            foreach($acc7->accounts as $acc8)
                                                            {
                                                                $account_ids[] = $acc8->id;
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

        
        

        $account_statement = DayDetails::whereIn('account_id',$account_ids)
        ->whereBetween('date',[$request->start_at,$request->end_at])
        ->select(DB::raw('MONTH(date) as month ,sum(debit - credit) as total'))
        ->groupBy(DB::raw('MONTH(date) DESC'))->get();

        $account_per_month = array_values(array_fill(1, 12, 0));

        foreach ($account_statement as $e) {
            $account_per_month[$e->month - 1] = $e->total;
        }

        $chartjs = app()->chartjs
        ->name('Randomize')
        ->type('bar')
        ->size(['width' => 2500, 'height' => 2800])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July','august','septemer','october','november','december'])
        ->datasets([
            [
                "label" => "اجمالى رصيد الحساب",
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                  ],
                'borderColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                  ],
                  "borderWidth" => 1,
                'data' =>  $account_per_month ,
    
            ],
        ])
        ->options([]);

        $accounts = AllAccount::all();

        return view('account-statement.graph',compact('accounts','chartjs','account_per_month','report_name','start_at','end_at'));
    }
}
