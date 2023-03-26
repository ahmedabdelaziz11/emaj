<?php

namespace App\Http\Controllers;

use App\Models\supplier_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupplierAttachmentsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',
    
            ], [
                'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
            ]);
            
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
    
            $attachments =  new supplier_attachments();
            $attachments->file_name = $file_name;
            $attachments->supplier_id = $request->supplier_id;
            $attachments->Created_by = Auth::user()->name;
            $attachments->save();
               
            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/suppliers/'. $request->supplier_id), $imageName);
            
            session()->flash('Add', 'تم اضافة المرفق بنجاح');
            return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\supplier_attachments  $supplier_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(supplier_attachments $supplier_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\supplier_attachments  $supplier_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier_attachments $supplier_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supplier_attachments  $supplier_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, supplier_attachments $supplier_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supplier_attachments  $supplier_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = supplier_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete('suppliers/'.$request->supplier_id.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($supplier_id,$file_name)
    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('suppliers/'.$supplier_id.'/'.$file_name);
        return response()->download( $contents);
    }



    public function open_file($supplier_id,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('suppliers/'.$supplier_id.'/'.$file_name);
        return response()->file($files);
    }
}
