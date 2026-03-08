<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'is_blocked',
        'blocked_at',
        'deleted_at',
        'is_deleted',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_blocked' => 'boolean',
        'is_deleted' => 'boolean',
        'blocked_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
