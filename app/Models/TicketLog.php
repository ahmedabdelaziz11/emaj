<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'state', 'actor_type', 'actor_id'];
}
