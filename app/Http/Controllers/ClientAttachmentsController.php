<?php

namespace App\Http\Controllers;

use App\Models\client_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ClientAttachmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
    
            $attachments =  new client_attachments();
            $attachments->file_name = $file_name;
            $attachments->client_id = $request->client_id;
            $attachments->Created_by = Auth::user()->name;
            $attachments->save();
               
            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/clients/'. $request->client_id), $imageName);
            
            session()->flash('Add', 'تم اضافة المرفق بنجاح');
            return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client_attachments  $client_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoices = client_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete('clients/'.$request->client_id.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

    public function get_file($client_id,$file_name)
    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('clients/'.$client_id.'/'.$file_name);
        return response()->download( $contents);
    }



    public function open_file($client_id,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix('clients/'.$client_id.'/'.$file_name);
        return response()->file($files);
    }
}
