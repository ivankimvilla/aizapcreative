<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
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

    protected static function newFactory(): BookingFactory
    {
        return BookingFactory::new();
    }
}
