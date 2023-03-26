<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\Cost;
use App\Models\day;
use App\Models\DayDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayController extends Controller
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
        return view('days.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = AllAccount::all();
        $costs    = Cost::all();
        return view('days.create',compact('accounts','costs'));
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
            $day = day::create([
                'date' => $request->date,
                'note' => $request->day_details,
                'type' => 0,
                'type_name' => 'قيد يدوي',
                'type_id' => null,
                'total' => $request->total_debit,
            ]);
            $debit = $credit = 0;

            foreach($request->account_id as $index => $account)
            {
                if($request->cost_id[$index] == "null")
                {
                    $cost_id = null;
                }
                else{
                    $cost_id = $request->cost_id[$index];
                }

                $debit  += $request->debit[$index];
                $credit += $request->credit[$index];
                if($request->debit[$index] != 0 && $request->credit[$index] != 0)
                {
                    session()->flash('del','خطا فى ادخال البيانات');
                    return back()->with('del','خطا فى ادخال البيانات');
                }
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => $account,
                    'debit' => $request->debit[$index],
                    'credit' => $request->credit[$index],
                    'note' => $request->details[$index],
                    'cost_id' => $cost_id,
                ]);
            }
            if($debit != $credit)
            {
                session()->flash('del','القيد غير متوازن');
                return back()->with('del','القيد غير متوازن');
            }
        } catch(\Exception $e){
            DB::rollback();
            return $e;
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return redirect('/days')->with('mss','تم اضافة القيد بنجاح');  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\day  $day
     * @return \Illuminate\Http\Response
     */
    public function show(day $day)
    {
        $day_id = $day->id;
        return view('days.index',compact('day_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\day  $day
     * @return \Illuminate\Http\Response
     */
    public function edit(day $day)
    {
        $accounts = AllAccount::all();
        $costs    = Cost::all();
        return view('days.edit',compact('day','accounts','costs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\day  $day
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, day $day)
    {
        DB::beginTransaction();
        try{
            $day_id = $day->id;
            $day->day2()->forceDelete();
            $day->update([
                'date' => $request->date,
                'note' => $request->day_details,
                'total' => $request->total_debit,
            ]);
            $debit = $credit = 0;
        

            foreach($request->account_id as $index => $account)
            {
                if($request->cost_id[$index] == "null")
                {
                    $cost_id = null;
                }
                else{
                    $cost_id = $request->cost_id[$index];
                }

                $debit  += $request->debit[$index];
                $credit += $request->credit[$index];
                DayDetails::create([
                    'date' => $request->date,
                    'day_id' => $day->id,
                    'account_id' => $account,
                    'debit' => $request->debit[$index],
                    'credit' => $request->credit[$index],
                    'note' => $request->details[$index],
                    'cost_id' => $cost_id,
                ]);
            }
        } catch(\Exception $e){
            DB::rollback();
            return back()->with('error','اعد المحاولة');
        }
        DB::commit();
        return view('days.index',compact('day_id'))->with('mss','تم تعديل القيد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\day  $day
     * @return \Illuminate\Http\Response
     */
    public function destroy(day $day)
    {
        $day_id = $day->id;
        DayDetails::where('day_id',$day->id)->delete();
        $day->delete();
        return view('days.index',compact('day_id'))->with('del','تم حذف القيد بنجاح');
    }

    public function returnDay(Request $request)
    {
        $day_id = $request->day_id ;
        day::withTrashed()
        ->where('id',$day_id)
        ->restore();
        DayDetails::withTrashed()->where('day_id',$request->day_id)->restore();
        return view('days.index',compact('day_id'))->with('mss','تمت عملية الاسترجاع بنجاح');

    }

    public function daySearch()
    {
        return view('days.search');
    }
}
