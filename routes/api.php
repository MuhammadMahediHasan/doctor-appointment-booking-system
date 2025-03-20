<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorAvailabilityController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::post('/doctor/availability', [DoctorAvailabilityController::class, 'store']);
    Route::get('/doctor/{id}/availability', [DoctorAvailabilityController::class, 'show']);

    Route::post('/appointment/book', [AppointmentController::class, 'store']);
    Route::get('/appointments/{patientId}', [AppointmentController::class, 'showByPatientId']);
    Route::get('/doctor-appointments/{doctorId}', [AppointmentController::class, 'showByDoctorId']);
});
