<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kalnoy\Nestedset\NodeTrait;

class Ticket extends Model
{
    use HasFactory, NodeTrait;

    protected $fillable = [
        'client_id',
        'reporter_id',
        'reporter_type',
        'state',
        'date',
        'ticket_type',
        'address',
        'received_money',
        'recommended_path',
        'closing_note',
        'invoice_product_id',
        'feedback',
    ];
    
    public function details()
    {
        return $this->hasMany(TicketDetail::class);
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class);
    }

    public function compensationType()
    {
        return $this->belongsToMany(CompensationType::class, 'ticket_compensation', 'ticket_id', 'compensation_type_id')->withPivot('amount');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_ticket', 'ticket_id', 'employee_id')->withPivot('date');
    }

    public function employeePivot()
    {
        return $this->hasMany(EmployeeTicket::class);
    }

    public function compensationPivot()
    {
        return $this->hasMany(TicketCompensation::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
    public function client()
    {
        return $this->belongsTo(AllAccount::class, 'client_id');
    }
    public function invoiceProduct()
    {
        if ($this->ticket_type == 'warranty') {
            return $this->belongsTo(InsuranceSerial::class, 'invoice_product_id');
        }
        return $this->belongsTo(products::class, 'invoice_product_id');
    }
    public function getProductAttribute()
    {
        if ($this->ticket_type == 'invoice') {
            return $this->invoiceProduct->product;
        } else if ($this->ticket_type == 'warranty') {
            return $this->invoiceProduct->insurance->product;
        }
    }

    public function products()
    {
        return $this->belongsToMany(products::class, 'ticket_products', 'ticket_id', 'product_id')->withPivot('price');
    }

    public function ticketProductsPivot()
    {
        return DB::table('ticket_products')
        ->where('ticket_id', $this->id)
            ->get();
    }
    public function getStateAttribute($value)
    {
        switch ($value) {
            case 'pending':
                return 'معطل';
                break;
            case 'in_progress':
                return 'تحت التنفيذ';
                break;
            case 'halted':
                return 'مغلق';
                break;
            case 'cancelled':
                return 'ملغي';
                break;
            default:
                return 'تمت';
                break;
        }
    }

    public function invoice()
    {
        return $this->hasOne(invoices::class);
    }
    public function getTicketEmployeeDailyPaymentAttribute()
    {
        $sameDayDateChecker = [];
        $pivotCollection = collect();
        foreach ($this->employeePivot as $pivot) {
            $date = $pivot->date;
            if (array_key_exists($date, $sameDayDateChecker)) continue;
            $pivotCollection->push($pivot);
            $sameDayDateChecker[$date] = true;
        }
        return $pivotCollection;
    }
    public function getTotalCompensationAttribute()
    {
        $ticketTotalCompensations = 0;
        foreach ($this->compensationPivot as $compensation) {
            $ticketTotalCompensations += $compensation->amount;
        }
        foreach ($this->ticket_employee_daily_payment as $pivot) {
            $employee = $pivot->employee;
            $ticketTotalCompensations += $employee->Salary / 30;
        }
        if (!$this->invoice) return $ticketTotalCompensations;
        foreach ($this->invoice->prodcuts as $spareProduct) {
            $ticketTotalCompensations += $spareProduct->pivot->product_Purchasing_price;
        }
        return $ticketTotalCompensations;
    }
    
    public static function pendingTicketCount()
    {
        return static::where('state','pending')->count();
    }
    
    public static function inProgressTicketCount()
    {
        return static::where('state','in_progress')->count();
    }

    public static function closedTicketCount()
    {
        return static::where('state','closed')
        ->whereMonth('date', Carbon::now()->month)
        ->count();
    }
}
