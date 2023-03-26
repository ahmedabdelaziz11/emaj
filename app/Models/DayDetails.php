<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DayDetails extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function account(){
        return $this->belongsTo('App\Models\AllAccount','account_id','id');
    }

    public function cost(){
        return $this->belongsTo('App\Models\Cost','cost_id','id');
    }

    public function day(){
        return $this->belongsTo('App\Models\day','day_id','id');
    }
}
