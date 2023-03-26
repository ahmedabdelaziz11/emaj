<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $guarded = [];

    public function stock()
    {
        return $this->belongsTo('App\Models\Stock');
    }
}
