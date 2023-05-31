<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoices extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\AllAccount','client_id','id');
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket','ticket_id','id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address','address_id','id');
    }

    public function invoice_products()
    {
        return $this->hasMany('App\Models\invoice_products','invoice_id','id');
    }

    public function services()
    {
        return $this->hasMany('App\Models\InvoiceService','invoice_id','id');
    }

    public function composite_products()
    {
        return $this->belongsToMany('App\Models\CompositeProduct','App\Models\InvoiceCompositeProduct','invoice_id','coposite_product_id')->withPivot('selling_price','quantity','cost');
    }

    public function returned_invoice()
    {
        return $this->hasMany('App\Models\returned_invoice','invoice_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\products','App\Models\invoice_products','invoice_id','product_id')->withPivot('product_quantity','product_Purchasing_price','product_selling_price');
    }

    public function c_products()
    {
        return $this->belongsToMany('App\Models\products','App\Models\InvoiceCProduct','invoice_id','product_id')->withPivot('quantity','Purchasing_price');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
