<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clients extends Model
{
    protected $guarded = [];
    
    public function offers()
    {
        return $this->hasMany('App\Models\offers','client_id','id');
    }

    public function spare_offers()
    {
        return $this->hasMany('App\Models\spare_offers','client_id','id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\invoices','client_id','id');
    }

    public function spare_invoices()
    {
        return $this->hasMany('App\Models\spare_invoices','client_id','id');
    }
}
