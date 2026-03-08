<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    public $timestamps = false;
    const UPDATED_AT = null;

    protected $fillable = [
        'otp_code',
        'otp_type',
        'email',
        'phone',
        'user_id',
        'expires_at',
        'attempts',
        'max_attempts',
        'verified',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
