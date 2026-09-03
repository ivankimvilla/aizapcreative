<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'name',
        'email',
        'role',
        'subject',
        'rating',
        'message',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];
}
