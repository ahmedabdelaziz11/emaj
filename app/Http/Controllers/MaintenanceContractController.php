<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceContract;
use App\Services\ClientService;
use App\Services\MaintenanceContractService;
use Illuminate\Http\Request;

class MaintenanceContractController extends Controller
{
    protected $service;

    public function __construct(MaintenanceContractService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('maintenance-contract.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ClientService $clientService)
    {
        $clients  = $clientService->getAllClients();
        return view('maintenance-contract.create',compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->service->create(
            $request->all()
        );

        session()->flash('success','تم اضافة عقد صيانة بنجاح');
        return redirect('/maintenance-contracts');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MaintenanceContract  $maintenanceContract
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceContract $maintenanceContract,ClientService $clientService)
    {
        $clients  = $clientService->getAllClients();
        return view('maintenance-contract.show',compact('maintenanceContract','clients'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MaintenanceContract  $maintenanceContract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceContract $maintenanceContract)
    {
        $this->service->update($request->all(),$maintenanceContract);
        session()->flash('success','تم تعديل عقد صيانة بنجاح');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MaintenanceContract  $maintenanceContract
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceContract $maintenanceContract)
    {
        $this->service->delete($maintenanceContract);
        session()->flash('deleted','تم حذف عقد صيانة بنجاح');
        return back();
    }

    public function maintenanceExcel(Request $request)
    {
        return $this->service->maintenanceExcel(
            $request->product_name,
            $request->client_name,
            $request->start_date,
            $request->end_date,
        );
    }

    public function printMaintenanceTable(Request $request)
    {
        $maintenances = $this->service->getAllMaintenanceContractOutPaginate(
            $request->product_name,
            $request->client_name,
            $request->start_date,
            $request->end_date,
        );

        return view('maintenance-contract.maintenance-table',compact('maintenances'));
    }

    public function checkClientMaintenance($client_id)
    {
        return $this->service->checkClientMaintenance($client_id);
    }

    public function retrieveClientMaintenance($client_id)
    {
        $maintenanceProducts = $this->service->retrieveClientMaintenance($client_id);
        return view('insurance.client-maintenance-select', compact('maintenanceProducts'));
    }
}
