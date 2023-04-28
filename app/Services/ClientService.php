<?php

namespace App\Services;

use App\Models\AllAccount;

class ClientService 
{
    public function getAllclients($name = null)
    {
        return AllAccount::with('accounts')->clients()->get();
    }
}