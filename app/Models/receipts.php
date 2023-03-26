<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class receipts extends Model
{
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo('App\Models\AllAccount','supplier_id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\AllAccount','account_id');
    }

    public function cost()
    {
        return $this->belongsTo('App\Models\Cost','cost_id');
    }

    public function receipt_products()
    {
        return $this->hasMany('App\Models\receipt_products','receipt_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\products','App\Models\receipt_products','receipt_id','product_id')->withPivot('product_quantity','product_Purchasing_price');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'stock_id');
    }
}
