<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function section(){
        return $this->belongsTo('App\Models\sections');
    }

    public function stock(){
        return $this->hasOneThrough(Stock::class, sections::class,'id','id','section_id','stock_id');
    }

    public function spares()
    {
        return $this->belongsToMany(products::class,'product_spares','product_id','spare_id');
    }
}
