<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo('App\Models\AllAccount','account_id');
    }

    public function products()
    {
        return $this->hasManyThrough(products::class,sections::class,'stock_id','section_id');
    }

    public function sections()
    {
        return $this->hasMany(sections::class);
    }
}
