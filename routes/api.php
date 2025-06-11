<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Event routes
    Route::post('/acara', [App\Http\Controllers\Api\AcaraController::class, 'store']);

    // Wakil Kesiswaan Event Approval routes
    Route::get('/events/pending', [App\Http\Controllers\Api\AcaraApprovalController::class, 'getPendingEvents']);
    Route::get('/events', [App\Http\Controllers\Api\AcaraApprovalController::class, 'getAllEvents']);
    Route::post('/events/{id}/approve', [App\Http\Controllers\Api\AcaraApprovalController::class, 'approveEvent']);
    Route::post('/events/{id}/reject', [App\Http\Controllers\Api\AcaraApprovalController::class, 'rejectEvent']);
    
    // Event registration routes for students
    Route::get('/events', [App\Http\Controllers\Api\PendaftaranController::class, 'getEvents']);
    Route::get('/events/{id}', [App\Http\Controllers\Api\PendaftaranController::class, 'getEvent']);
    Route::get('/my-registrations', [App\Http\Controllers\Api\PendaftaranController::class, 'getMyRegistrations']);
    Route::post('/register', [App\Http\Controllers\Api\PendaftaranController::class, 'register']);
    Route::delete('/registrations/{id}', [App\Http\Controllers\Api\PendaftaranController::class, 'cancelRegistration']);
});