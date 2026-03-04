<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Attendance
    Route::get('/attendance-history', [AttendanceController::class, 'index']);
    Route::post('/clock-in', [AttendanceController::class, 'clockIn']);
    Route::post('/clock-out', [AttendanceController::class, 'clockOut']);
    Route::get('/presence-settings', [AttendanceController::class, 'getSettings']);

    // Submissions
    Route::post('/submit-overtime', [SubmissionController::class, 'overtime']);
    Route::post('/submit-attendance', [SubmissionController::class, 'attendance']);
    Route::get('/submission-history', [SubmissionController::class, 'getHistory']);

    // Profile
    Route::post('/update-profile', [ProfileController::class, 'updateProfile']);
    Route::post('/update-password', [ProfileController::class, 'updatePassword']);
});
