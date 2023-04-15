<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function invoiceProduct()
    {
        return $this->belongsTo(invoice_products::class,'invoice_product_id');
    }

    public function client()
    {
        return $this->belongsTo(clients::class,'client_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
