<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SettingSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that UserSeeder populates the database correctly.
     */
    public function test_user_seeder_populates_data(): void
    {
        $this->seed(\Database\Seeders\ShiftSeeder::class);
        $this->seed(UserSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@mail.com',
            'role' => 'admin',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'employee@mail.com',
            'role' => 'employee',
        ]);

        $this->assertEquals(2, User::count());
    }

    /**
     * Test that SettingSeeder populates the database correctly.
     */
    public function test_setting_seeder_populates_data(): void
    {
        $this->seed(SettingSeeder::class);

        $this->assertDatabaseHas('settings', [
            'key' => 'office_lat',
            'value' => '-6.200000',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'office_lng',
            'value' => '106.816666',
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'radius_meters',
            'value' => '500',
        ]);

        $this->assertEquals(3, Setting::count());
    }

    /**
     * Test that AttendanceSeeder populates the database correctly.
     */
    public function test_attendance_seeder_populates_data(): void
    {
        $this->seed(\Database\Seeders\ShiftSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(\Database\Seeders\AttendanceSeeder::class);

        $employee = User::where('email', 'employee@mail.com')->first();

        $this->assertDatabaseHas('attendances', [
            'user_id' => $employee->id,
            'clock_in' => '08:00:00',
        ]);

        $this->assertEquals(7, Attendance::where('user_id', $employee->id)->count());
    }
}
