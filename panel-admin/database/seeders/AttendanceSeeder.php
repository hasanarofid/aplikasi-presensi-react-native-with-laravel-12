<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employee = User::where('email', 'employee@mail.com')->first();
        if (!$employee) return;

        // Generate 30 days of attendance history
        for ($i = 30; $i >= 1; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Skip weekends
            if ($date->isWeekend()) continue;

            $dateString = $date->toDateString();

            // Randomize clock in (07:45 - 08:15)
            $clockInTime = sprintf('%02d:%02d:%02d', 7, rand(45, 59), rand(0, 59));
            if (rand(0, 1)) {
                $clockInTime = sprintf('%02d:%02d:%02d', 8, rand(0, 15), rand(0, 59));
            }

            // Randomize clock out (16:00 - 17:00)
            $clockOutTime = sprintf('%02d:%02d:%02d', 16, rand(0, 59), rand(0, 59));

            Attendance::create([
                'user_id' => $employee->id,
                'date' => $dateString,
                'clock_in' => $clockInTime,
                'clock_out' => $clockOutTime,
                'lat_in' => '-6.200000',
                'lng_in' => '106.816666',
                'lat_out' => '-6.200000',
                'lng_out' => '106.816666',
                'photo_in' => 'attendances/in/demo.jpg',
                'photo_out' => 'attendances/out/demo.jpg',
            ]);
        }
    }
}
