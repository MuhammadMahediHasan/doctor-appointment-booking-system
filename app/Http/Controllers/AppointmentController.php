<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AppointmentController extends Controller
{
    /**
     * @param AppointmentRequest $request
     * @return JsonResponse
     */
    public function store(AppointmentRequest $request): JsonResponse
    {
        $patientId = Auth::id();
        $canBook = Appointment::canBookAppointment(
            $request->get('doctor_id'), $request->get('date'), $request->get('time_slot')
        );

        if ($canBook !== true) {
            return response()->json(['message' => $canBook], 409);
        }

        // Create the appointment
        $appointment = Appointment::query()->create([
            'doctor_id' => $request->get('doctor_id'),
            'patient_id' => $patientId,
            'date' => $request->get('date'),
            'time_slot' => $request->get('time_slot'),
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully!',
            'data' => $appointment
        ], Response::HTTP_CREATED);
    }

    /**
     * @param $patientId
     * @return JsonResponse
     */
    public function showByPatientId($patientId): JsonResponse
    {
        $appointments = Appointment::query()->where('patient_id', $patientId)
            ->with('doctor:id,name,email')
            ->orderBy('date', 'desc')
            ->paginate();

        if ($appointments->isEmpty()) {
            return response()->json([
                'message' => 'No appointments found for this patient.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $appointments
        ], Response::HTTP_OK);
    }

    /**
     * @param $doctorId
     * @return JsonResponse
     */
    public function showByDoctorId($doctorId): JsonResponse
    {
        $appointments = Appointment::query()->where('doctor_id', $doctorId)
            ->with('patient:id,name,email')
            ->orderBy('date', 'desc')
            ->paginate();

        if ($appointments->isEmpty()) {
            return response()->json([
                'message' => 'No appointments found for this doctor.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'data' => $appointments
        ], Response::HTTP_OK);
    }
}
