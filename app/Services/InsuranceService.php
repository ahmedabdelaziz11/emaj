<?php

namespace App\Services;

use App\Models\Insurance;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Models\AllAccount;
use App\Models\InsuranceSerial;

class InsuranceService 
{
    public function getClientSerials($client_id)
    {
        return InsuranceSerial::whereHas('insurance', function ($q) use ($client_id) {
            $q->where('client_id',$client_id);
        })
        ->where('serial', '!=', '')
        ->get();
    }


    public function getAllInsuranesSerials($product_name = null,$client_name = null,$invoice_id = null,$start_date = null,$end_date = null)
    {
        return InsuranceSerial::with('insurance','insurance.client','insurance.invoiceProduct.invoice','insurance.InvoiceProduct.product')
        ->whereHas('insurance.client',function($q){
            $q->where('end_date','>=',now());
        })
        ->when($product_name,function($q,$product_name){
            $q->whereHas('insurance.invoiceProduct.product',function($q)use($product_name){
                $q->where('name','like','%'.$product_name.'%');
            });
        })
        ->when($client_name,function($q,$client_name){
            $q->whereHas('insurance.client',function($q)use($client_name){
                $q->where('name','like','%'.$client_name.'%');
            });
        })
        ->when($invoice_id,function($q,$invoice_id){
            $q->whereHas('insurance.invoiceProduct',function($q)use($invoice_id){
                $q->where('invoice_id',$invoice_id);
            });
        })
        ->when($start_date,function($q,$start_date){
            $q->whereHas('insurance.client',function($q)use($start_date){
                $q->where('start_date','>=',$start_date);
            });
        })
        ->when($end_date,function($q,$end_date){
            $q->whereHas('insurance.client',function($q)use($end_date){
                $q->where('end_date','>=',$end_date);
            });
        })
        ->paginate(15);
    }

    public function getAllInsuranes($product_name = null,$client_name = null,$invoice_id = null,$start_date = null,$end_date = null)
    {
        return Insurance::with('client','invoiceProduct.invoice','InvoiceProduct.product')

        ->when($product_name,function($q,$product_name){
            $q->whereHas('insurance.invoiceProduct.product',function($q)use($product_name){
                $q->where('name','like','%'.$product_name.'%');
            });
        })
        ->when($client_name,function($q,$client_name){
            $q->whereHas('insurance.client',function($q)use($client_name){
                $q->where('name','like','%'.$client_name.'%');
            });
        })
        ->when($invoice_id,function($q,$invoice_id){
            $q->whereHas('insurance.invoiceProduct',function($q)use($invoice_id){
                $q->where('invoice_id',$invoice_id);
            });
        })
        ->when($start_date,function($q,$start_date){
            $q->whereHas('insurance',function($q)use($start_date){
                $q->where('start_date','>=',$start_date);
            });
        })
        ->when($end_date,function($q,$end_date){
            $q->whereHas('insurance',function($q)use($end_date){
                $q->where('end_date','>=',$end_date);
            });
        })
        ->paginate(15);
    }

    public function createManyInsurance($invoice_product_id,$is_in_isurance,$client_id,$address,$start_date,$end_date,$compensation)
    {
        foreach($invoice_product_id as $key => $value)
        {
            if($is_in_isurance[$key])
            {
                $insurance = Insurance::create([
                    'invoice_product_id' => $value,
                    'client_id' => $client_id,
                    'address' => $address[$key] ?? null,
                    'start_date' => $start_date[$key],
                    'end_date' => $end_date[$key],
                    'compensation' => $compensation[$key],
                ]);
                $serials = $insurance->invoiceProduct->product_quantity;
                for($i = 0 ; $i <  $serials ; $i++ )
                {
                    InsuranceSerial::create([
                        'insurance_id' => $insurance->id,
                        'serial' => '',
                        'model_number' => '',
                    ]);
                }
            }
        }
    }

    public function updateInsurance($start_date,$end_date,$compensation,$address,$serial,$model_number,InsuranceSerial $insurance)
    {
        $insurance->update([
            'serial' => $serial,
            'model_number' => $model_number,
        ]);
        $insurance->insurance->update([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'compensation' => $compensation,
            'address' => $address,
        ]);
    }

    public function deleteInsurance($insurance_id)
    {
        return InsuranceSerial::find($insurance_id)->delete();
    }

    public function getAllInsuranesWithOutPaginate($product_name = null,$client_name = null,$invoice_id = null,$start_date = null,$end_date = null)
    {
        return InsuranceSerial::with('insurance','insurance.client','insurance.invoiceProduct.invoice','insurance.InvoiceProduct.product')
        ->when($product_name,function($q,$product_name){
            $q->whereHas('insurance.invoiceProduct.product',function($q)use($product_name){
                $q->where('name','like','%'.$product_name.'%');
            });
        })
        ->when($client_name,function($q,$client_name){
            $q->whereHas('insurance.client',function($q)use($client_name){
                $q->where('name','like','%'.$client_name.'%');
            });
        })
        ->when($invoice_id,function($q,$invoice_id){
            $q->whereHas('insurance.invoiceProduct',function($q)use($invoice_id){
                $q->where('invoice_id',$invoice_id);
            });
        })
        ->when($start_date,function($q,$start_date){
            $q->whereHas('insurance.client',function($q)use($start_date){
                $q->where('start_date','>=',$start_date);
            });
        })
        ->when($end_date,function($q,$end_date){
            $q->whereHas('insurance.client',function($q)use($end_date){
                $q->where('end_date','>=',$end_date);
            });
        })
        ->get();
    }

    public function InsuranceExcel($product_name = null,$client_name = null,$invoice_id = null,$start_date = null,$end_date = null)
    {
        $insurances = $this->getAllInsuranesWithOutPaginate(
            $product_name,
            $client_name,
            $invoice_id,
            $start_date,
            $end_date,
        );

        $i = 0;
        $data = [];

        $data[] = [
            'م' => 'م',
            'السريل' => 'السريل',
            'الموديل' => 'الموديل',
            'المنتج' => 'المنتج',
            'العميل' => 'العميل',
            'الفاتورة' => 'الفاتورة',
            'تاريخ البدء' => 'تاريخ البدء',
            'تاريخ الانتهاء' => 'تاريخ الانتهاء' ,
            'الحد الاقصى' => 'الحد الاقصى',
        ];
        
        foreach($insurances as $insurance)
        {
            $i++;
            $data[] = [
                'م' => $i,
                'السريل' => $insurance->serial ?? '',
                'الموديل' => $insurance->model_number ?? '',
                'المنتج' => $insurance->insurance->InvoiceProduct->product->name ?? '',
                'العميل' => $insurance->insurance->client->name ?? '',
                'الفاتورة' => $insurance->insurance->InvoiceProduct->invoice_id ?? '',
                'تاريخ البدء' => $insurance->insurance->start_date ?? '',
                'تاريخ الانتهاء' => $insurance->insurance->end_date ?? '',
                'الحد الاقصى' => $insurance->insurance->compensation ?? '',
            ];
        }
        
        return Excel::download(new DataExport($data),'insurances.xlsx');
    }

    public function checkClientInsuranceState(AllAccount $client)
    {
        return Insurance::query()
            ->where('client_id', $client->id)
            ->where('end_date', '>', now())
            ->exists();
    }

}