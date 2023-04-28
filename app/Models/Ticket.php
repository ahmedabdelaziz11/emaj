<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

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
        return $this->belongsToMany(CompensationType::class, 'ticket_compensation_type', 'ticket_id', 'compensation_type_id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_ticket', 'ticket_id', 'employee_id')->withPivot('quantity', 'price_per_unit', 'estimated_time', 'approved');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
