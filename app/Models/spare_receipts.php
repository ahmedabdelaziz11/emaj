<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spare_receipts extends Model
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
        return $this->hasMany('App\Models\sreceipt_products','receipt_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\spares','App\Models\sreceipt_products','receipt_id','product_id');
    }
}
