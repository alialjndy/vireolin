<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'user_name',
        'email',
        'phone_number',
        'message',
        'is_read',
    ];
}
