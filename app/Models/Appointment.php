<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Appointment extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['doctor_id', 'patient_id', 'date', 'time_slot'];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public static function canBookAppointment($doctorId, $date, $time_slot): true|string
    {
        $availability = DoctorAvailability::query()->where('doctor_id', $doctorId)
            ->where('date', $date)
            ->first();

        if (!$availability || !in_array($time_slot, $availability->time_slots)) {
            return 'Doctor is not available for this time slot.';
        }

        $isBooked = self::query()->where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('time_slot', $time_slot)
            ->exists();

        if ($isBooked) {
            return 'Doctor is already booked for this time slot.';
        }

        return true;
    }
}
