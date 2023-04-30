<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_products extends Model
{
    protected $guarded = [];

    public function product()
    {
      return $this->belongsTo('App\Models\products');
    } 
    public function invoice()
    {
      return $this->belongsTo('App\Models\invoices');
    }

    public function insurance()
    {
      return $this->hasOne(Insurance::class,'invoice_product_id','id');
    }
}
