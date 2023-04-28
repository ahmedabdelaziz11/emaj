<?php

namespace App\Services;

use App\Models\Insurance;

class InsuranceService 
{
    public function getAllInsuranes()
    {
        return Insurance::with('client','address','invoiceProduct.invoice','InvoiceProduct.product')->paginate(15);
    }
}