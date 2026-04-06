<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PhoneLoginController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/user_login', [AuthController::class, 'login']);
Route::post('/user_register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
});

// Profile routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Maintenance page
Route::get('/maintenance', function () {
    return view('components.maintenance');
});

// Set language (desktop & mobile)
// Route::post('/set-language', function (Request $request) {
//     $locale = $request->locale;

//     // Save in session
//     session(['locale' => $locale]);

//     // Save in database if user is logged in
//     if (Auth::check()) {
//         Auth::user()->update(['locale' => $locale]);
//     }

//     return response()->json(['status' => 'ok']);

// });

Route::post('/set-language', function (Request $request) {
    $locale = $request->input('locale'); // ✅ was: $request->getLocale (wrong)
    $supported = ['en', 'kh', 'kr', 'jp'];

    if (!in_array($locale, $supported)) {
        $locale = 'en'; // fallback
    }

    session(['locale' => $locale]);
    App::setLocale($locale);

    // ✅ Correct way to return the full translations array
    $translations = require resource_path("lang/{$locale}/messages.php");

    return response()->json([
        'success'      => true,
        'translations' => $translations,
    ]);
});

// Get current language translations (for dynamic updates)
Route::get('/set-language-get', function (Request $request) {
    $locale = session('locale', app()->getLocale());
    $translations = require resource_path("lang/{$locale}/messages.php");

    return response()->json([
        'success'      => true,
        'locale'       => $locale,
        'translations' => $translations,
    ]);
});

// routes/web.php
Route::get('/search', [SearchController::class, 'index']);
Route::get('/movies/search', [MovieController::class, 'search']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);


// routes/web.php
Route::get('/login/phone',         [PhoneLoginController::class, 'index'])->name('phone.login');
Route::post('/login/phone/otp',    [PhoneLoginController::class, 'sendOtp'])->name('phone.otp.send');
Route::post('/login/phone/verify', [PhoneLoginController::class, 'verifyOtp'])->name('phone.otp.verify');

Route::get('/test-phone', function () {
    return response()->json(['success' => true, 'message' => 'Route working']);
});
