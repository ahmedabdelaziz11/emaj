<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\AllAccount;
use App\Models\DayDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectStatementController extends Controller
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
        $costs = Cost::all();
        return view('project-statement.index',compact('accounts','costs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_at = $request->start_at ;
        $end_at = $request->end_at;
        $accounts = AllAccount::all();
        $costs = Cost::all();
        $c_cost = Cost::find($request->cost_id);
        $ids = [];
        $ids[] = $request->cost_id;
        if($c_cost->childrens->count() > 0)
        {
            $ids[] = $c_cost->childrens->pluck('id');
        }
        if($request->level == 2)
        {
            if($request->account_id == null)
            {
                $days = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])
                ->whereIn('cost_id',$ids)->get();
            }
            else
            {
                $acc_ids = [];
                $acc1 = AllAccount::find($request->account_id);
                $acc_ids[] = $acc1->id ;
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
                    
                $days = DayDetails::whereBetween('date',[$request->start_at,$request->end_at])
                ->whereIn('cost_id',$ids)->whereIn('account_id',$acc_ids)->get();
            }
            return view('project-statement.index',compact('accounts','costs','days','start_at','end_at','c_cost'));
        }elseif($request->level == 1)
        {
            $data = [];
            $d = $c = 0 ;
            $acc_ids =  DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->
                whereIn('cost_id',$ids)->groupBy('account_id')->pluck('account_id');
            foreach($acc_ids as $acc_id)
            {
                $d = $c = 0;
                $d += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(debit) as total'))
                ->where('account_id',$acc_id)->whereIn('cost_id',$ids)->value('total');

                $c += DayDetails::whereBetween('date',[$request->start_at,$request->end_at])->select(DB::raw('sum(credit) as total'))
                ->where('account_id',$acc_id)->whereIn('cost_id',$ids)->value('total');

                $account = AllAccount::find($acc_id);
                $data[] = [
                    'id' => $account->id,
                    'code' => $account->code,
                    'name' => $account->name,
                    'debit' => $d,
                    'credit' => $c,
                ];
            }
            return view('project-statement.index',compact('accounts','costs','data','start_at','end_at','c_cost'));
        }

    }
}
