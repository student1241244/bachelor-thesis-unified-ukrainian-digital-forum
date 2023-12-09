<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'stripe_session_id',
        'secure_token',
        'status',
        'passcode',
        'passcode_displayed'
    ];
}
