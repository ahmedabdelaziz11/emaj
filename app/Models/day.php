<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class day extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function day2()
    {
        return $this->hasMany('App\Models\DayDetails','day_id','id');
    }
}
