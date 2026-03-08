<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'user_id',
        'registration_id',
        'test_name',
        'status',
        'result_file_url',
        'result_data',
        'report_date',
    ];

    protected $casts = [
        'result_data' => 'array',
        'report_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
