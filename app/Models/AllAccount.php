<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllAccount extends Model
{
    protected $guarded = [];

    public function accounts()
    {
        return $this->hasMany('App\Models\AllAccount','parent_id','id');
    }

    public function parentAcount()
    {
        return $this->belongsTo('App\Models\AllAccount','parent_id','id');
    }
    public function scopeSuppliers($query)
    {
        return $query->where('parent_id',18);
    }

    public function scopeAssets($query)
    {
        return $query->where('parent_id',13);
    }

    public function scopeClients($query)
    {
        return $query->where('parent_id',5);
    }

    public function scopeParentSuppliers($query)
    {
        return $query->where('id',18);
    }

    public function scopeParentClients($query)
    {
        return $query->where('id',5);
    }

    public function scopeBanking($query)
    {
        return $query->where('parent_id',3);
    }
}
