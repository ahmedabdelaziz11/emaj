<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\AllAccount;
use App\Models\checks;
use App\Models\receipts;
use App\Models\supplier_attachments;
use App\Models\suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuppliersController extends Controller
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
        $suppliers = suppliers::all();
        return view('suppliers.suppliers',compact('suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\suppliers  $suppliers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, suppliers $suppliers)
    {
        $id = $request->id;
        $this->validate($request, ['name' => 'required|max:255|unique:suppliers,name,'.$id,],['name.unique' =>'اسم المورد مسجل مسبقا']);

        $suppliers = suppliers::find($id);

        $suppliers->update([
            'name'         => $request->name,
            'c_register'   => $request->c_register,
            'tax_card'     => $request->tax_card,
            'email'        => $request->email,
            'address'      => $request->address,
            'phone'        => $request->phone,
            'company_name' => $request->company_name,
            'account_number' => $request->account_number,
        ]);
        
        session()->flash('edit','تم تعديل المورد بنجاج');
        return back();
    }
}
