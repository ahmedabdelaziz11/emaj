<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTicket extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'ticket_id', 'date'];
    protected $table = 'employee_ticket';
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
