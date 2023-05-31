<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceContract extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany('App\Models\products','App\Models\MaintenanceContractProduct','maintenance_contract_id','product_id');
    }

    public function client()
    {
        return $this->belongsTo(AllAccount::class, 'client_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
