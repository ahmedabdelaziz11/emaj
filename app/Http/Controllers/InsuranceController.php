<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Services\ClientService;
use App\Services\InsuranceService;
use App\Services\InvoiceService;
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

    public function create(ClientService $clientService)
    {
        $clients  = $clientService->getAllClients();
        return view('insurance.create',compact('clients'));
    }

    public function store(Request $request)
    {
        $this->service->createManyInsurance(
            $request->invoice_product_id,
            $request->is_in_isurance,
            $request->client_id,
            $request->address_id,
            $request->start_date,
            $request->end_date,
            $request->compensation
        );

        session()->flash('success','تم اضافة الضمان بنجاح');
        return redirect('/insurances');
    }

    public function show(Insurance $insurance)
    {
        return view('insurance.show',compact('insurance'));
    }

    public function update(Request $request,Insurance $insurance)
    {
        $this->service->updateInsurance(
            $request->start_date,
            $request->end_date,
            $request->compensation,
            $request->address_id,
            $insurance
        );
        session()->flash('success','تم تعديل الضمان بنجاح');
        return back();
    }


    public function destroy(Request $request)
    {
        $this->service->deleteInsurance($request->id);
        session()->flash('deleted','تم حذف الضمان بنجاح');
        return back();
    }

    public function getClientInvoices($client_id,InvoiceService $invoiceService)
    {
        return $invoiceService->getInvoicesByClientID($client_id)->pluck('id');
    }

    public function getClientInvoicesProducts(InvoiceService $invoiceService,$client_id,$invoice_id = null)
    {
        $invoiceProducts = $invoiceService->getInvoicesProducts($client_id,$invoice_id);
        return view('insurance.products-table',compact('invoiceProducts'));
    }

    public function insurancesExcel(Request $request)
    {        
        return $this->service->InsuranceExcel(
            $request->product_name,
            $request->client_name,
            $request->invoice_id,
            $request->start_date,
            $request->end_date,
        );
    }

    public function printInsuranceTable(Request $request)
    {
        $insurances = $this->service->getAllInsuranesWithOutPaginate(
            $request->product_name,
            $request->client_name,
            $request->invoice_id,
            $request->start_date,
            $request->end_date,
        );

        return view('insurance.insurance-table',compact('insurances'));
    }
}
