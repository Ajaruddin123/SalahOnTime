<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return response()->json([
        'statusCode' => 401,
        'message' => 'Unauthenticated'
    ], 401);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/auth/login-with-email', [AuthController::class, 'loginWithEmail']);
Route::post('/auth/login-with-mobile-number', [AuthController::class, 'loginWithMobileNumber']);

Route::middleware(['auth:api'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
