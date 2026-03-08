<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone|nullable|email',
            'phone' => 'required_without:email|nullable|string',
            'otp_type' => 'nullable|string|in:login,verify',
        ]);

        $identifier = $request->email ?? $request->phone;
        $type = $request->input('otp_type', 'login');
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        Otp::where(function ($q) use ($request) {
            if ($request->email) {
                $q->where('email', $request->email);
            }
            if ($request->phone) {
                $q->orWhere('phone', $request->phone);
            }
        })->where('otp_type', $type)->delete();

        Otp::create([
            'otp_code' => $code,
            'otp_type' => $type,
            'email' => $request->email,
            'phone' => $request->phone,
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0,
            'max_attempts' => 5,
        ]);

        // TODO: Send email/SMS with $code (e.g. Mail, Twilio). For now just return in dev.
        return response()->json([
            'message' => 'OTP sent',
            'identifier' => $identifier,
            // Remove in production: 'otp' => $code,
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required_without:phone|nullable|email',
            'phone' => 'required_without:email|nullable|string',
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = Otp::where('otp_code', $request->otp_code)
            ->where(function ($q) use ($request) {
                if ($request->email) {
                    $q->where('email', $request->email);
                }
                if ($request->phone) {
                    $q->where('phone', $request->phone);
                }
            })
            ->where('expires_at', '>', now())
            ->where('verified', false)
            ->first();

        if (!$otp) {
            return response()->json(['error' => 'Invalid or expired OTP'], 422);
        }

        $otp->increment('attempts');
        if ($otp->attempts > $otp->max_attempts) {
            return response()->json(['error' => 'Too many attempts'], 422);
        }

        $otp->update(['verified' => true]);

        $user = User::where('email', $otp->email)->first();
        if (!$user && $otp->phone) {
            return response()->json(['error' => 'User not found for this phone'], 422);
        }

        if (!$user) {
            return response()->json(['error' => 'User not found. Please register first.'], 422);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'user' => $user->load('profile'),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
