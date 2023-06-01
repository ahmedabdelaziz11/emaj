<?php

namespace App\Services;

use App\Models\Insurance;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Models\AllAccount;
use App\Models\InsuranceSerial;
use App\Models\MaintenanceContract;

class MaintenanceContractService 
{
    public function getAllMaintenanceContract($product_name = null,$client_name = null,$start_date = null,$end_date = null)
    {
        return MaintenanceContract::with('client','address','products')
        ->when($product_name,function($q,$product_name){
            $q->whereHas('products',function($q)use($product_name){
                $q->where('name','like','%'.$product_name.'%');
            });
        })
        ->when($client_name,function($q,$client_name){
            $q->whereHas('client',function($q)use($client_name){
                $q->where('name','like','%'.$client_name.'%');
            });
        })
        ->when($start_date,function($q,$start_date){
            $q->where('start_date','>=',$start_date);
        })
        ->when($end_date,function($q,$end_date){
            $q->where('end_date','>=',$end_date);
        })
        ->paginate(15);
    }

    public function getAllMaintenanceContractOutPaginate($product_name = null,$client_name = null,$start_date = null,$end_date = null)
    {
        return MaintenanceContract::with('client','address','products')
        ->when($product_name,function($q,$product_name){
            $q->whereHas('products',function($q)use($product_name){
                $q->where('name','like','%'.$product_name.'%');
            });
        })
        ->when($client_name,function($q,$client_name){
            $q->whereHas('client',function($q)use($client_name){
                $q->where('name','like','%'.$client_name.'%');
            });
        })
        ->when($start_date,function($q,$start_date){
            $q->where('start_date','>=',$start_date);
        })
        ->when($end_date,function($q,$end_date){
            $q->where('end_date','>=',$end_date);
        })
        ->get();
    }

    public function create($formData)
    {
        $maintenance_contract = MaintenanceContract::create([
            'start_date' => $formData['start_date'],
            'end_date' => $formData['end_date'],
            'address_id' => $formData['address_id'],
            'client_id' => $formData['client_id'],
            'contract_amount' => $formData['contract_amount'],
            'periodic_visits_count' => $formData['periodic_visits_count'],
            'emergency_visits_count' => $formData['emergency_visits_count'],
        ]);

        $maintenance_contract->products()->sync($formData['product_ids']);
    }

    public function update($formData,MaintenanceContract $maintenanceContract)
    {
        $maintenanceContract->update([
            'start_date' => $formData['start_date'],
            'end_date' => $formData['end_date'],
            'address_id' => $formData['address_id'],
            'client_id' => $formData['client_id'],
            'contract_amount' => $formData['contract_amount'],
            'periodic_visits_count' => $formData['periodic_visits_count'],
            'emergency_visits_count' => $formData['emergency_visits_count'],
        ]);

        $maintenanceContract->products()->sync($formData['product_ids']);
    }

    public function delete(MaintenanceContract $maintenanceContract)
    {
        return $maintenanceContract->delete();
    }

    public function maintenanceExcel($product_name = null,$client_name = null,$start_date = null,$end_date = null)
    {
        $maintenances = $this->getAllMaintenanceContractOutPaginate(
            $product_name,
            $client_name,
            $start_date,
            $end_date,
        );

        $i = 0;
        $data = [];

        $data[] = [
            'م' => 'م',
            'العميل' => 'العميل',
            'تاريخ البدء' => 'تاريخ البدء',
            'تاريخ الانتهاء' => 'تاريخ الانتهاء' ,
            'قيمة العقد' => 'قيمة العقد',
            'العنوان' => 'العنوان',
            'عدد الزيارات الدورية' => 'عدد الزيارات الدورية',
            'عدد الزيارات الطارئة' => 'عدد الزيارات الطارئة',
        ];
        
        foreach($maintenances as $maintenance)
        {
            $i++;
            $data[] = [
                'م' => $i,
                'العميل' => $maintenance->client->name ?? '',
                'تاريخ البدء' => $maintenance->start_date ?? '',
                'تاريخ الانتهاء' => $maintenance->end_date ?? '',
                'قيمة العقد' => $maintenance->contract_amount ?? '',
                'العنوان' => $maintenance->address->name ?? '',
                'عدد الزيارات الدورية' => $maintenance->periodic_visits_count ?? '',
                'عدد الزيارات الطارئة' => $maintenance->emergency_visits_count ?? '',
            ];
        }
        
        return Excel::download(new DataExport($data),'maintenance.xlsx');
    }
}