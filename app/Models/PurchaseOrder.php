<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $guarded = [];


    public function products()
    {
        return $this->belongsToMany('App\Models\products','App\Models\OrderProduct','purchase_order_id','product_id')->withPivot('quantity','Purchasing_price');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

}
