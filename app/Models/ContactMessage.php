<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $table = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'subject',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function getMessageAttribute($value): string
    {
        return str_replace(
            ['\\r\\n', '\\n', '\\r'],
            [PHP_EOL, PHP_EOL, PHP_EOL],
            (string) $value
        );
    }
}
