<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectiveOffer extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\clients','client_id','id');
    }
}

