<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSpareRequest;
use App\Services\ProductService;

class ProductSpareController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('product-spare.index');
    }

    public function create()
    {
        return view('product-spare.create');
    }

    public function show($id)
    {
        $product = $this->service->getProductSpareByid($id);
        return view('product-spare.show',compact('product','spares'));
    }

    public function edit($id)
    {
        $product = $this->service->getProductSpareByid($id);
        return view('product-spare.edit',compact('product'));
    }
    
    public function update(ProductSpareRequest $request)
    {
        $product = $this->service->updateProductSpare($request->product_id,$request->spare_ids);
        return $product ?  back()->with('success','تمت الاضافة بنجاح') : back()->with('failed','فشلت المحاولة');
    }

    public function getAllProducts($search = null)
    {
        return $this->service->getAllProductForSelect2($search);
    }

    public function getAllSpares($search = null)
    {
        return $this->service->getAllSparesForSelect2($search);
    }
}
