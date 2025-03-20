<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\DoctorAvailability;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::table('doctor_availabilities')->truncate();
        DB::table('appointments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::factory()->count(10)->doctor()->create();
        User::factory()->count(20)->patient()->create();

        DoctorAvailability::factory(50)->create();
        Appointment::factory(50)->create();
    }
}
