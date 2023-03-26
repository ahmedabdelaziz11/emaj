<?php

namespace App\Http\Controllers;

use App\Models\AllAccount;
use App\Models\clients;
use App\Models\invoices;
use Illuminate\Http\Request;

class ClientsController extends Controller
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
        $clients = clients::all();
        return view('clients.clients',compact('clients'));
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
            ['client_name' => 'required|unique:clients|max:255',],
            [
            'client_name.required' =>'يرجي ادخال اسم العميل',
            'client_name.unique' =>'اسم العميل مسجل مسبقا',
            ]
        );
        $client = clients::create([
            'client_name' => $request->client_name,
            'client_name_en' => $request->client_name_en,
            'sgel' => $request->sgel,
            'dreba' => $request->dreba,
            'email' => $request->email,
            'address' => $request->address,
            'address_en' => $request->address_en,
            'phone' => $request->phone,
            'Commercial_Register' => $request->Commercial_Register,
            'Commercial_Register_en' => $request->Commercial_Register_en,
        ]);

        session()->flash('Add', 'تم اضافة العميل بنجاح ');
        return redirect('/clients');
    }   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clients  $clients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, clients $clients)
    {        
        $id = $request->id;

        $this->validate($request, [
            'client_name' => 'required|max:255|unique:clients,client_name,'.$id, 
        ],[
            'client_name.required' =>'يرجي ادخال اسم العميل',
            'client_name.unique' =>'اسم العميل مسجل مسبقا',
        ]);

        $clients = clients::find($id);  

        $clients->update([
            'client_name' => $request->client_name,
            'client_name_en' => $request->client_name_en,
            'sgel' => $request->sgel,
            'dreba' => $request->dreba,
            'email' => $request->email,
            'address' => $request->address,
            'address_en' => $request->address_en,
            'phone' => $request->phone,
            'Commercial_Register' => $request->x,
            'Commercial_Register_en' => $request->x_en,
        ]);
        
        session()->flash('edit','تم تعديل العميل بنجاج');
        return back();
    }

    public function clientReport()
    {
        $clients = AllAccount::clients()->get();
        return view('clients.client-report',compact('clients'));
    }

    public function createClientReport(Request $request)
    {
        $clients = AllAccount::clients()->get();
        $client = AllAccount::find($request->client_id);
        $invoices = invoices::where('client_id',$request->client_id)->where('Value_Status',1)->where('type', '=', 1)
            ->whereBetween('date',[$request->start_at,$request->end_at])->get();
        $start_at = $request->start_at;
        $end_at = $request->end_at;
        return view('clients.client-report',compact('clients','client','invoices','end_at','start_at'));
    }

    public function destroy(Request $request)
    {
        clients::find($request->id)->delete();

        session()->flash('delete','تم حذف المنتج بنجاح');
        return back();
    }
}
