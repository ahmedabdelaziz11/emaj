<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferCompositeProducts extends Model
{
    protected $guarded = [];

    public function composite_product()
    {
        return $this->belongsTo('App\Models\CompositeProduct','coposite_product_id','id');
    }
}
