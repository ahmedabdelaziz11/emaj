<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spares extends Model
{
    protected $guarded = [];

    public function section(){
        return $this->belongsTo('App\Models\spare_sections');
    }
}
