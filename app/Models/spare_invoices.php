<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spare_invoices extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\AllAccount','client_id','id');
    }

    public function returned_invoice()
    {
        return $this->hasMany('App\Models\sreturned_invoice','invoice_id','id');
    }

    public function invoice_products()
    {
        return $this->hasMany('App\Models\sinvoice_products','invoice_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\spares','App\Models\sinvoice_products','invoice_id','product_id');
    }
}
