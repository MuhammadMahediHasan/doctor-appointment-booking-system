<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorAvailabilityRequest;
use App\Models\DoctorAvailability;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DoctorAvailabilityController extends Controller
{
    public function store(DoctorAvailabilityRequest $request): JsonResponse
    {
        $doctorId = Auth::id();
        $availability = DoctorAvailability::query()->updateOrCreate(
            ['doctor_id' => $doctorId, 'date' => $request->get('date')],
            ['time_slots' => $request->get('time_slots')]
        );

        return response()->json([
            'message' => 'Availability updated successfully!',
            'data' => $availability
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $availability = DoctorAvailability::query()
            ->select('date', 'time_slots')
            ->where('doctor_id', $id)
            ->orderBy('date')
            ->get();

        if ($availability->isEmpty()) {
            return response()->json(['message' => 'No availability found for this doctor.'], 404);
        }

        return response()->json([
            'message' => 'Availability updated successfully!',
            'data' => $availability
        ], Response::HTTP_OK);
    }

}
