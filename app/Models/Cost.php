<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $guarded = [];

    public function childrens()
    {
        return $this->hasMany('App\Models\Cost','parent_id','id');
    }
}
