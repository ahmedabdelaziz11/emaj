<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $guarded = [];

    public function account()
    {
        return $this->belongsTo('App\Models\AllAccount','account_id','id');
    }
}
