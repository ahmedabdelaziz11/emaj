<?php

namespace App\Http\Controllers;


use App\Models\AllAccount;
use App\Models\DayDetails;
use App\Models\suppliers;
use App\Models\clients;
use Illuminate\Http\Request;


class AllAccountController extends Controller
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
        $allAccount = AllAccount::where('parent_id',null)->get();
        $parent_acc = AllAccount::all();
        $children_acc = AllAccount::where('is_main',0)->get();
        return view('all_accounts.accounts',compact('allAccount','parent_acc','children_acc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            ['name' => 'required|unique:all_accounts|max:255',],
            ['name.unique' =>'اسم الحساب مسجل مسبقا',]);
        
        $parentAccount = AllAccount::find($request->parent_id);
        if($parentAccount->accounts->count() == 0)
        {
            $parent_code = $parentAccount->code;
            $code = strval($parent_code) . "0001";
        }
        else{
            $code = $parentAccount->accounts->max('code') + 1;
        }
        $account = AllAccount::create([
            'name'        => $request->name,
            'parent_id'   => $request->parent_id,
            'code'        => $code,
            'is_main' => 0,
        ]);
        if($account->parent_id == 18)
        {
            suppliers::create([
                'name'         => $account->name,
                'all_account_id' => $account->id
            ]);
        }
        if($account->parent_id == 5)
        {
            clients::create([
                'client_name' => $account->name,
                'all_account_id' => $account->id,
            ]);
        }
        session()->flash('mss', 'تم اضافة الحساب بنجاح ');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AllAccount  $allAccount
     * @return \Illuminate\Http\Response
     */
    public function show(AllAccount $allAccount)
    {
        return json_encode($allAccount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AllAccount  $allAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,['name' => 'required|max:255|unique:all_accounts,name,'.$request->account_id,],[
            'name.unique' =>'اسم الحساب مسجل مسبقا',
        ]);

        $account = AllAccount::find($request->account_id);
        $account->name = $request->name;

        if($request->parent_id != $account->parent_id)
        {
            $parentAccount = AllAccount::find($request->parent_id);
            if($parentAccount->accounts->count() == 0)
            {
                $parent_code = $parentAccount->code;
                $code = strval($parent_code) . "0001";
            }
            else{
                $code = $parentAccount->accounts->max('code') + 1;
            }
            $account->code = $code;
            $account->parent_id = $request->parent_id ;
        }
        $account->start_debit  = $request->start_debit;
        $account->start_credit  = $request->start_credit;
        $account->save();
        session()->flash('mss', 'تم تعديل الحساب بنجاح ');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AllAccount  $allAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->id == null)
        {
            session()->flash('del', 'يرجي اختيار الحساب المراد حذفه');
            return back();
        }
        $account = AllAccount::find($request->id);
        if(DayDetails::where('account_id',$account->id)->count() > 0)
        {
            session()->flash('del', 'لا يمكن حذف الحساب لوجود حركات له');
            return back();
        }
        else
        {
            $account->delete();
            session()->flash('del', 'تم حذف الحساب بنجاح');
            return back();
        }
    }
}
