<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;

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

// routes/web.php
Route::post('/set-language', function (Request $request) {
    $locale = $request->getLocale;
    $supported = ['en', 'kh', 'kr', 'jp'];

    if (in_array($locale, $supported)) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }

    return response()->json([
        'translations' => trans('messages', [], $locale)
    ]);
});

// routes/web.php
Route::get('/search', [SearchController::class, 'index']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
