<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        if ($this->ticket_type == 'invoice') {
            return $this->belongsTo(invoice_products::class, 'invoice_product_id');
        } else if ($this->ticket_type == 'warranty') {
            return $this->belongsTo(InsuranceSerial::class, 'invoice_product_id');
        }
        return $this->belongsTo(invoice_products::class, 'invoice_product_id');
    }
    public function getProductAttribute()
    {
        if ($this->ticket_type == 'invoice') {
            return $this->invoiceProduct->product;
        } else if ($this->ticket_type == 'warranty') {
            return $this->invoiceProduct->insurance->product;
        }
    }
    public function getStateAttribute($value)
    {
        switch ($value) {
            case 'pending':
                return 'قيد التنفيذ';
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
}
