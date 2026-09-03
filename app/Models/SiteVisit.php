<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = [
        'url',
        'ip_address',
        'user_agent',
        'referer',
    ];
}
