<?php

namespace Database\Factories;

use App\Models\DoctorAvailability;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DoctorAvailability>
 */
class DoctorAvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timeSlots = [];
        $numSlots = rand(3, 6);
        for ($i = 0; $i < $numSlots; $i++) {
            $timeSlots[] = $this->faker->time('H:i') . ' - ' . $this->faker->time('H:i');
        }

        return [
            'doctor_id' => User::query()
                ->where('role', 'doctor')
                ->inRandomOrder()
                ->first()->id, // Random doctor
            'date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'time_slots' => json_encode($timeSlots),
        ];
    }
}
