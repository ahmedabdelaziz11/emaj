<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'product_id',
        'details',
    ];
}
