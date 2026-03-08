<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    private function generateRegistrationId(): string
    {
        $dateStr = now()->format('ymd');
        $random = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        return 'MED' . $dateStr . $random;
    }

    public function index(Request $request)
    {
        $bookings = $request->user()
            ->bookings()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string|max:20',
            'patient_age' => 'nullable|integer|min:0|max:150',
            'patient_gender' => 'nullable|string|max:50',
            'test_type' => 'required|string|max:255',
            'collection_type' => 'required|string|max:255',
            'preferred_date' => 'required|date',
            'preferred_time' => 'required|string|max:50',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $email = $request->patient_email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->patient_name,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
            ]);
            $user->profile()->create([
                'full_name' => $request->patient_name,
                'email' => $email,
                'phone' => $request->patient_phone,
            ]);
        }

        $registrationId = $this->generateRegistrationId();

        $booking = Booking::create([
            'user_id' => $user->id,
            'registration_id' => $registrationId,
            'patient_name' => $request->patient_name,
            'patient_email' => $request->patient_email,
            'patient_phone' => $request->patient_phone,
            'patient_age' => $request->patient_age,
            'patient_gender' => $request->patient_gender,
            'test_type' => $request->test_type,
            'collection_type' => $request->collection_type,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'address' => $request->address,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return response()->json([
            'booking' => $booking,
            'registration_id' => $registrationId,
        ], 201);
    }

    public function showByRegistrationId(Request $request, string $registrationId)
    {
        $booking = $request->user()
            ->bookings()
            ->where('registration_id', $registrationId)
            ->firstOrFail();

        return response()->json($booking);
    }
}
