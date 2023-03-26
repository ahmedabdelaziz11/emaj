<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spare_offers extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\clients');
    }

    public function offer_products()
    {
        return $this->hasMany('App\Models\soffer_products','offer_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\spares','App\Models\soffer_products','offer_id','product_id');
    }
}
