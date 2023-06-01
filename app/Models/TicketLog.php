<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketLog extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'state', 'actor_type', 'actor_id', 'action'];

    public function getStateAttribute($value)
    {
        switch ($value) {
            case 'created':
                return 'إنشاء طلب إصلاح جديد';
                break;
            case 'updated':
                return 'تعديل في حالة الطلب';
                break;
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

}
