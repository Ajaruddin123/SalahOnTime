<?php

use App\Http\Controllers\Api\Mosque\ProfileController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/mosque', 'as' => 'api.mosque.', 'middleware' => ['role:mosque', 'auth:api']], function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/update-profile', [ProfileController::class, 'update'])->name('update.profile');
});
