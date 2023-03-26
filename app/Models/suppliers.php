<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    protected $guarded = [];

    public function receipts()
    {
        return $this->hasMany('App\Models\receipts','supplier_id','id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\AllAccount','all_account_id');
    }

    public function spare_receipts()
    {
        return $this->hasMany('App\Models\spare_receipts','supplier_id','id');
    }
}
