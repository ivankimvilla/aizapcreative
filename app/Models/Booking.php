<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'service',
        'name',
        'email',
        'phone',
        'company',
        'message',
        'starts_at',
        'timezone',
        'meeting_link',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
    ];
}
