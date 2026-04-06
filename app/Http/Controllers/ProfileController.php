<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show profile page
    public function show()
    {
        return view('profile.profile');
    }

    // Show edit profile form
    public function edit()
    {
        return view('profile.edit');
    }

    // Update profile
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
        ]);

        Auth::user()->update($validated);

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }
}
