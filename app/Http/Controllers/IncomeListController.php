<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\Cost;
use App\Models\DayDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeListController extends Controller
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costs = Cost::all();
        return view('income-list.index',compact('costs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $accounts_id = [26,29];
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
        $accounts = AllAccount::whereIn('parent_id',(array)$accounts_id)->get();
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

                $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                ->whereIn('account_id',(array)$acc_ids)->value('total');

                $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                ->whereIn('account_id',(array) $acc_ids)->value('total');
            } 

            $data[] = [
                'code' => $acc1->code,
                'name' => $acc1->name,
                'account'  =>($d - $c),
            ];
            $acc_ids = [];
            $d = $c = 0;
        }
        return view('income-list.index',compact('costs','data'));
    }
}
