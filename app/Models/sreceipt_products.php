<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sreceipt_products extends Model
{
    protected $guarded = [];

    public function product()
    {
      return $this->belongsTo('App\Models\spares');
    } 
    public function receipt()
    {
      return $this->belongsTo('App\Models\spare_receipts');
    } 
}
