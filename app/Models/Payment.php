<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'stripe_session_id',
        'secure_token',
        'total',
        'status',
        'passcode',
        'passcode_displayed'
    ];

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
