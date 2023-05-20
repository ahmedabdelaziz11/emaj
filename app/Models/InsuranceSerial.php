<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceSerial extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function insurance()
    {
        return $this->belongsTo(Insurance::class,'insurance_id');
    }
}
