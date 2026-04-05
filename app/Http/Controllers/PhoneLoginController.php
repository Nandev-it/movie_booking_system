<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Twilio\Rest\Client;

class PhoneLoginController extends Controller
{
    public function index()
    {
        return view('auth.phone-login');
    }

    public function sendOtp(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string|min:8|max:15',
            ]);

            $otp = rand(100000, 999999);

            $cleanPhone = ltrim($request->phone, '0');
            $phone = '855' . $cleanPhone; // Vonage doesn't need + sign

            $user = User::firstOrCreate(
                ['phone' => $request->phone],
                [
                    'name'     => 'User ' . $request->phone,
                    'email'    => $request->phone . '@phone.cinebook.com',
                    'password' => Hash::make(uniqid()),
                ]
            );

            $user->update([
                'phone_otp'            => Hash::make($otp),
                'phone_otp_expires_at' => now()->addMinutes(5),
            ]);

            // Send SMS via Vonage
            $vonage = new \Vonage\Client(
                new \Vonage\Client\Credentials\Basic(
                    config('services.vonage.key'),
                    config('services.vonage.secret')
                )
            );

            $vonage->sms()->send(
                new \Vonage\SMS\Message\SMS(
                    $phone,
                    'CineBook',
                    "Your CineBook OTP is: {$otp}. Valid for 5 minutes."
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'OTP sent to your phone.',
                'otp'     => $otp, // ← add this back temporarily
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp'   => 'required|string|size:6',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Phone number not found.',
            ], 404);
        }

        if (now()->gt($user->phone_otp_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.',
            ], 422);
        }

        if (!Hash::check($request->otp, $user->phone_otp)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.',
            ], 422);
        }

        $user->update([
            'phone_otp'            => null,
            'phone_otp_expires_at' => null,
        ]);

        Auth::login($user);

        return response()->json([
            'success'  => true,
            'message'  => 'Login successful.',
            'redirect' => url('/'),
        ]);
    }
}
