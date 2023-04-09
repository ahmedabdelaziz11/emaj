<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSpare extends Pivot
{
    use HasFactory;
    protected $fillable = ['product_id','spare_id'];
}
