<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'registration_id',
        'patient_name',
        'patient_email',
        'patient_phone',
        'patient_age',
        'patient_gender',
        'test_type',
        'collection_type',
        'preferred_date',
        'preferred_time',
        'address',
        'notes',
        'status',
    ];

    protected $casts = [
        'preferred_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testResults()
    {
        return $this->hasMany(TestResult::class);
    }
}
