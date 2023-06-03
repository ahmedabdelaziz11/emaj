<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        return view('addresses.index',compact('addresses'));
    }

    public function store(Request $request)
    {
        Address::create([
            'name' => $request->name,
        ]);
        return back();
    }

    public function update(Request $request)
    {
        $address = Address::find($request->id)->update([
            'name' => $request->name,
        ]);
        return back();
    }

    public function destroy(Request $request)
    {
        $address = Address::find($request->id)->destroy();
        return back();
    }
    
    public function getAddressesSelect2($search = null)
    {
        return Address::when($search,function($q,$search){
            $q->where('name', 'like', '%'.$search.'%');
        })->paginate(15); 
    }
}
