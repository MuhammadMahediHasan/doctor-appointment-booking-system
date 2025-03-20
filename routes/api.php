<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorAvailabilityController;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('v1')->group(function () {
        Route::post('doctor/availability', [DoctorAvailabilityController::class, 'store'])->middleware('isDoctor');
        Route::get('doctor/{id}/availability', [DoctorAvailabilityController::class, 'show']);

        Route::post('appointment/book', [AppointmentController::class, 'store'])->middleware('isPatient');
        Route::get('appointments/{patientId}', [AppointmentController::class, 'showByPatientId']);
        Route::get('doctor-appointments/{doctorId}', [AppointmentController::class, 'showByDoctorId']);
    });
});
