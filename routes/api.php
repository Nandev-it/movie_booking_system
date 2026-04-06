<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MovieController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/user_login', [AuthController::class, 'login']);
Route::get('/status', [AuthController::class, 'index']);


Route::get('/movies', [MovieController::class, 'lists']);

