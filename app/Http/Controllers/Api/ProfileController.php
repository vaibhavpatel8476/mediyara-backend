<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create([
                'full_name' => $user->name,
                'email' => $user->email,
            ]);
        }

        return response()->json($profile);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->create([
                'full_name' => $user->name,
                'email' => $user->email,
            ]);
        }

        $request->validate([
            'full_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|nullable|email|max:255',
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string',
            'date_of_birth' => 'sometimes|nullable|date',
        ]);

        $profile->update($request->only(['full_name', 'email', 'phone', 'address', 'date_of_birth']));

        return response()->json($profile);
    }
}
