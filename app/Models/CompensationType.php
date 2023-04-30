<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompensationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // validation rules
    public static function rules($update = false, $id = null)
    {
        $common = [
            'name' => 'string|max:255|unique:compensation_types,name',
        ];

        if ($update) {
            return $common;
        }

        return [
            'name' => 'required|string|max:255|unique:compensation_types,name',
        ];
    }
}
