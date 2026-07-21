<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public auth endpoints - these issue a Sanctum token
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Returns the currently logged-in user (useful for testing the token)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// All booking API routes require a valid Sanctum token.
// This generates:
// GET    /api/bookings           index
// POST   /api/bookings           store
// GET    /api/bookings/{booking} show
// PUT    /api/bookings/{booking} update
// DELETE /api/bookings/{booking} destroy
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('bookings', BookingController::class);
});
