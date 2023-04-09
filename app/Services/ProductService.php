<?php

namespace App\Services;

use App\Models\products;

class ProductService 
{
    public function getAllProductSpare($search = '',$stock_id = null)
    {
        return products::whereHas('spares')
        ->with('spares')
        ->when($search,function($q,$search){
            $q->where('name', 'like', '%'.$search.'%');
        })->when($stock_id,function($q,$stock_id){
            $q->where('stock_id',$stock_id);
        })->orderBy('id','desc')->paginate(15);
    }

    public function createProductSpare()
    {
        return products::all();
    }

    public function updateProductSpare($product_id,$spares_ids)
    {
        $product = products::find($product_id);
        $product->spares()->sync($spares_ids);
        return $product;
    }

    public function getProductSpareByid($id)
    {
        return products::with('spares')->findOrFail($id);
    }

    public function getAllProductForSelect2($search = null)
    {
        if($search == 'undefined') $search = ' ';

        $products = products::when($search,function($q,$search){
            $q->where('name', 'like', '%'.$search.'%');
        })->paginate(15);

        foreach ($products as $key => $value) {
            $list[$key]['id'] = $value->id;
            $list[$key]['text'] = $value->name; 
        }

        return json_encode($list); 
    }
}