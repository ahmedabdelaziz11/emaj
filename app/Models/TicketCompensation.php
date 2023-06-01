<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCompensation extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'compensation_type_id', 'amount'];
    protected $table = 'ticket_compensation';
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
    public function compensationType()
    {
        return $this->belongsTo(CompensationType::class, 'compensation_type_id');
    }
}
