<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class BalanceSheetExport implements FromArray
{
    protected $balance_sheet;

    public function __construct(array $balance_sheet)
    {
        $this->balance_sheet = $balance_sheet;
    }

    public function array(): array
    {
        return $this->balance_sheet;
    }
}
