<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\DayDetails;
use Illuminate\Http\Request;

class CostController extends Controller
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
        $costs = Cost::where('parent_id',null)->get();
        $all_costs = Cost::all();
        return view('costs.costs',compact('costs','all_costs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(['name' => 'required|unique:costs|max:255',],['name.required' =>'يرجي ادخال اسم المركز','name.unique' =>'اسم المركز مسجل مسبقا',]);
        Cost::create([
            'name' => $request->name,
            'details' => $request->details,
            'parent_id' => $request->parent_id ? $request->parent_id : null,
        ]);
        session()->flash('mss', 'تم اضافة المركز بنجاح ');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Cost $cost)
    {
        return json_encode($cost);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cost  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate(['name' => 'required|unique:costs,name,'.$request->cost_id],['name.required' =>'يرجي ادخال اسم المركز','name.unique' =>'اسم المركز مسجل مسبقا',]);
        Cost::find($request->cost_id)->update([
            'name' => $request->name,
            'details' => $request->details,
            'parent_id' => $request->parent_id ? $request->parent_id : null,
        ]);

        session()->flash('mss', 'تم تعديل المركز بنجاح ');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->id == null)
        {
            session()->flash('del', 'يرجي اختيار المركز المراد حذفه');
            return back();
        }
        $cost = Cost::find($request->id);
        if(DayDetails::where('cost_id',$cost->id)->count() > 0)
        {
            session()->flash('del', 'لا يمكن حذف المركز لوجود حركات له');
            return back();
        }
        else
        {
            $cost->delete();
            session()->flash('del', 'تم حذف المركز بنجاح');
            return back();
        }
    }
}
