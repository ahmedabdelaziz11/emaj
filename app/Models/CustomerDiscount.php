<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDiscount extends Model
{
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo('App\Models\clients');
    }
}
