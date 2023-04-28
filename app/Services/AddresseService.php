<?php

namespace App\Services;

use App\Models\Address;

class AddresseService 
{
    public function getAllAddresses($name = null)
    {
        return Address::when($name,function($q,$name){
            $q->where('name', 'like', '%'.$name.'%');
        })->paginate(15);
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
        $addresses = $this->getAllAddresses($search);
        
        $list = [];
        foreach ($addresses as $key => $value) {
            $list[$key]['id'] = $value->id;
            $list[$key]['text'] = $value->name; 
        }

        return json_encode($list); 
    }
}