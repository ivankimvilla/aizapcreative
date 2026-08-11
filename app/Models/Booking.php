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
        'timezone_label',
        'meeting_link',
        'status',
        'is_read',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'is_read' => 'boolean',
    ];
}
