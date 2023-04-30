<?php

namespace App\Services;

use App\Models\invoice_products;
use App\Models\invoices;

class InvoiceService 
{
    public function getAllInvoices()
    {
        return invoices::all();
    }

    public function getInvoicesByClientID($client_id)
    {
        return invoices::where('client_id',$client_id)->get();
    }

    public function getInvoicesProducts($client_id,$invoice_id = null)
    {
        return invoice_products::WhereDoesntHave('insurance')->wherehas('invoice',function($q)use($client_id){
            $q->where('client_id',$client_id);
        })
        ->when($invoice_id,function($q,$invoice_id){
            $q->where('invoice_id',$invoice_id);
        })
        ->get();
    }
}