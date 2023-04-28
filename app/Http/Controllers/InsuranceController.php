<?php

namespace App\Http\Controllers;

use App\Services\InsuranceService;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    protected $service;

    public function __construct(InsuranceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('insurance.index');
    }

    public function create()
    {
        return view('insurance.create');
    }

    public function store(Request $request)
    {
        // $this->service->store();
        session()->flash('sucesse','تم اضافة الضمان بنجاح');
        return redirect('/insurances');
    }

}
