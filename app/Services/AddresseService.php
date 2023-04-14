<?php

namespace App\Services;

use App\Models\Address;

class AddresseService 
{
    public function getAllAddresses()
    {

    }

    public function create($name,$parent_id)
    {
        return Address::create([
            'name' => $name,
            'parent_id' => $parent_id
        ]);
    }

    public function getAllAddressesForSelect2($search = null)
    {
        if($search == 'undefined') $search = '';

        $addresses = Address::when($search,function($q,$search){
            $q->where('name', 'like', '%'.$search.'%');
        })->paginate(15);

        $list = [];
        foreach ($addresses as $key => $value) {
            $list[$key]['id'] = $value->id;
            $list[$key]['text'] = $value->name; 
        }

        return json_encode($list); 
    }

    public function getProductSpareByid($id)
    {
        return products::with('spares')->findOrFail($id);
    }
}