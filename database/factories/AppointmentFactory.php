<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $availability = DoctorAvailability::query()->inRandomOrder()->first();

        if ($availability) {
            $timeSlots = json_decode($availability->time_slots);
            $timeSlot = $this->faker->randomElement($timeSlots);

            return [
                'doctor_id' => $availability->doctor_id,
                'patient_id' => User::query()
                    ->where('role', User::PATIENT)
                    ->inRandomOrder()
                    ->first()->id,
                'date' => $availability->date,
                'time_slot' => $timeSlot,
            ];
        }

        // Fallback if no availability is found
        return [];
    }
}
