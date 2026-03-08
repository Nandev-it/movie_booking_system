<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            // If API request
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            // If Web request
            return back()->withErrors([
                'email' => 'Invalid credentials'
            ]);
        }

        // Login session
        Auth::login($user);

        // Create token (API)
        $token = $user->createToken('api-token')->plainTextToken;

        // If API request
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'token' => $token
            ]);
        }

        // If Web request
        return redirect('/');
    }

    // public function register(Request $request)
    // {
    //     // 1. Validate request
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 'error',
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     // 2. Create user
    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     // 3. Return success response
    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'User registered successfully',
    //         'user' => $user
    //     ], 201);
    // }


    public function register(Request $request)
    {
        // 1. Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Redirect to login page with success message
        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}
