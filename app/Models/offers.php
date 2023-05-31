<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offers extends Model
{
    protected $guarded = [];


    public function client()
    {
        return $this->belongsTo('App\Models\clients');
    }

    public function composite_products()
    {
        return $this->belongsToMany('App\Models\CompositeProduct','App\Models\OfferCompositeProducts','offer_id','coposite_product_id')->withPivot('selling_price','quantity');
    }

    public function offer_products()
    {
        return $this->hasMany('App\Models\offer_products','offer_id','id');
    }

    public function offer_services()
    {
        return $this->hasMany('App\Models\OfferService','offer_id','id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\products','App\Models\offer_products','offer_id','product_id')->withPivot('product_quantity','product_price');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket','ticket_id','id');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address','address_id','id');
    }
}



