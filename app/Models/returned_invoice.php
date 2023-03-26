<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class returned_invoice extends Model
{
    protected $guarded = [];

    public function invoice_products()
    {
        return $this->hasMany('App\Models\returned_products','invoice_id','id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\AllAccount','client_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\products','App\Models\returned_products','invoice_id','product_id')->withPivot('product_quantity','product_Purchasing_price','product_selling_price');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
