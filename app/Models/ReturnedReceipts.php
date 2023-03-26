<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnedReceipts extends Model
{
    protected $guarded = [];

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\products','App\Models\ReturnedReceiptProducts','receipt_id','product_id')->withPivot('product_quantity','product_Purchasing_price');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    
    public function supplier()
    {
        return $this->belongsTo('App\Models\AllAccount','supplier_id');
    }

    public function cost()
    {
        return $this->belongsTo('App\Models\Cost','cost_id');
    }

    public function receipt_products()
    {
        return $this->hasMany('App\Models\ReturnedReceiptProducts','receipt_id','id');
    }
}
