<?php

namespace App\Http\Controllers;

use App\Services\AddresseService;
use Illuminate\Http\Request;

class AddresseController extends Controller
{
    protected $service;

    public function __construct(AddresseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        //
    }

    public function create()
    {
        return view('addresses.create');
    }

    public function store(Request $request)
    {
        return $this->service->create($request->name,$request->parent_id);
    }

    public function getAddressesSelect2($search = null)
    {
        return $this->service->getAllAddressesForSelect2($search); 
    }
}
