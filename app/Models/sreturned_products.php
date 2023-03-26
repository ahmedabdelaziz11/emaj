<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sreturned_products extends Model
{
  protected $guarded = [];

  public function product()
  {
    return $this->belongsTo('App\Models\spares');
  }
  public function returned_invoice()
  {
    return $this->belongsTo('App\Models\sreturned_invoice');
  }
}
