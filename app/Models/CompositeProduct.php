<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompositeProduct extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\products','App\Models\CProduct','composite_product_id','product_id')->withPivot('quantity');
    }

    public function scopeCost()
    {
        return $this->products()->sum(DB::raw('c_products.quantity * products.Purchasing_price'));
    }

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }
}
