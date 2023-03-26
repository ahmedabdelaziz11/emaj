<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sreturned_invoice extends Model
{
    protected $guarded = [];

    public function invoice_products()
    {
        return $this->hasMany('App\Models\sreturned_products','invoice_id','id');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\AllAccount','client_id','id');
    }

    public function returned_invoice_products()
    {
        return $this->hasMany('App\Models\sreturned_products','invoice_id','id');
    }

    public function prodcuts()
    {
        return $this->belongsToMany('App\Models\spares','App\Models\sreturned_products','invoice_id','product_id');
    }

    public function returned_prodcuts()
    {
        return $this->belongsToMany('App\Models\spares','App\Models\sreturned_products','invoice_id','product_id');
    }
}
