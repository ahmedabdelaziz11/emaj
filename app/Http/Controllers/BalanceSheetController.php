<?php

namespace App\Http\Controllers;

use App\Exports\BalanceSheetExport;
use App\Models\AllAccount;
use App\Models\Cost;
use App\Models\DayDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BalanceSheetController extends Controller
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
        $costs = Cost::all();
        return view('balance-sheet.index',compact('costs'));
    }

    public function getReport(Request $request)
    {

        $data = [] ;
        if($request->cost_id != 0)
        {
            $Cost = Cost::find($request->cost_id);
            if($Cost->childrens->count() > 0)
            {
                foreach($Cost->childrens as $costch)
                $cost_ids[] = $costch->id;
            }
            $cost_ids[] = $Cost->id;
        }else{
            $Cost = null;
        }
        $costs = Cost::all();


        if($request->level == 1)
        {
            $accounts = AllAccount::where('parent_id',null)->get();
            foreach($accounts as $acc1)
            {
                $acc_ids = [];
                $d = $sd = $sc = $c = 0;
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
                if($request->cost_id != 0)
                {
                    $sd += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $sc += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
                }else
                {
                    $sd += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->value('total');
    
                    $sc += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->value('total');

                    $sd += AllAccount::whereIn('id',(array)$acc_ids)->select(DB::raw('sum(start_debit) as total'))->value('total');
                    $sc += AllAccount::whereIn('id',(array)$acc_ids)->select(DB::raw('sum(start_credit) as total'))->value('total');
    
                    $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->value('total');
    
                    $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->value('total');
                } 
    
                $data[] = [
                    'code' => $acc1->code,
                    'name' => $acc1->name,
                    'prv_debit'  => $sd,
                    'debit' => $d,
                    'prv_cerdit' =>$sc,
                    'credit' => $c,
                ];
                $acc_ids = [];
                $d = $c = 0;
            }
        }elseif($request->level == 2)
        {
            $accounts_id = AllAccount::where('parent_id',null)->pluck('id');
            $accounts = AllAccount::whereIn('parent_id',$accounts_id)->get();
            foreach($accounts as $acc1)
            {
                $acc_ids = [];
                $d = $sd = $sc = $c = 0;
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
                if($request->cost_id != 0)
                {
                    $sd += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $sc += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->whereIn('cost_id',(array)$cost_ids)->value('total');
                }else
                {
                    $sd += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->value('total');
    
                    $sc += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->value('total');

                    $sd += AllAccount::whereIn('id',(array)$acc_ids)->select(DB::raw('sum(start_debit) as total'))->value('total');
                    $sc += AllAccount::whereIn('id',(array)$acc_ids)->select(DB::raw('sum(start_credit) as total'))->value('total');
    
                    $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                    ->whereIn('account_id',(array)$acc_ids)->value('total');
    
                    $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                    ->whereIn('account_id',(array) $acc_ids)->value('total');
                } 
    
                $data[] = [
                    'code' => $acc1->code,
                    'name' => $acc1->name,
                    'prv_debit'  => $sd,
                    'debit' => $d,
                    'prv_cerdit' =>$sc,
                    'credit' => $c,
                ];
                $acc_ids = [];
                $d = $c = 0;
            }
        }
        elseif($request->level == 3){
            $ids =  DayDetails::groupBy('account_id')->pluck('account_id');
            
            foreach($ids as $id)
            {
                $account = AllAccount::find($id);
                $sd = $d = $sc = $c = 0;
                if($request->cost_id != 0)
                {
                    $sd += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                    ->where('account_id',$id)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $sc += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                    ->where('account_id',$id)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                    ->where('account_id',$id)->whereIn('cost_id',(array)$cost_ids)->value('total');
    
                    $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                    ->where('account_id',$id)->whereIn('cost_id',(array)$cost_ids)->value('total');
                }else
                {
                    $sd += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(debit) as total'))
                    ->where('account_id',$id)->value('total');
    
                    $sc += DayDetails::where('date','<',$request->start_at)->select(DB::raw('sum(credit) as total'))
                    ->where('account_id',$id)->value('total');

                    $sd += $account->start_debit;
                    $sc += $account->start_credit;
    
                    $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                    ->where('account_id',$id)->value('total');
    
                    $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                    ->where('account_id',$id)->value('total');
                } 
    
                $data[] = [
                    'code' => $account->code,
                    'name' => $account->name,
                    'prv_debit'  => $sd,
                    'debit' => $d,
                    'prv_cerdit' =>$sc,
                    'credit' => $c,
                ];
                
            }

            $accWithStartDebt = AllAccount::whereNotIn('id',$ids)->get();
            foreach($accWithStartDebt as $accDebt)
            {
                if($accDebt->start_debit != 0 || $accDebt->start_credit != 0 )
                {
                    $data[] = [
                        'code' => $accDebt->code,
                        'name' => $accDebt->name,
                        'prv_debit'  => $accDebt->start_debit,
                        'debit' => 0,
                        'prv_cerdit' => $accDebt->start_credit,
                        'credit' => 0,
                    ];
                }
            }
        }

        $level = $request->level;
        $end_at = $request->end_at;
        $start_at = $request->start_at;
        $cost_id = $request->cost_id;
        $data = collect($data)->sortBy('code')->toArray(); 
        return view('balance-sheet.index',compact('cost_id','level','data','costs','start_at','end_at','Cost'));
    }

    public function downloadSheet(Request $request)
    {
        $f_data = [];
        $f_data[] = [
            'الكود' => 'الكود',
            'اسم الحساب' => 'اسم الحساب',
            'مدين سابق' => 'مدين سابق',
            'دائن سابق' => 'دائن سابق',
            'مدين حركة' => 'مدين حركة',
            'دائن حركة' => 'دائن حركة' ,
            'مدين اجمالي' => 'مدين اجمالي' ,
            'دائن اجمالي' => 'دائن اجمالي' ,
            'مدين رصيد' => 'مدين رصيد',
            'دائن رصيد' => 'دائن رصيد',
        ];
        foreach($request->code as $index => $x)
        {
            $f_data[] = [
                'الكود' => $x,
                'اسم الحساب' => $request->name[$index],
                'مدين سابق' => $request->predebit[$index],
                'دائن سابق' => $request->precredit[$index],
                'مدين حركة' => $request->debit[$index],
                'دائن حركة' => $request->credit[$index],
                'مدين اجمالي' => $request->totdebit[$index],
                'دائن اجمالي' => $request->totcredit[$index],
                'مدين رصيد' => $request->findebit[$index],
                'دائن رصيد' => $request->fincredit[$index],
            ];
        }
        return Excel::download(new BalanceSheetExport($f_data), 'balance_sheet.xlsx');
    }
    
  

}
