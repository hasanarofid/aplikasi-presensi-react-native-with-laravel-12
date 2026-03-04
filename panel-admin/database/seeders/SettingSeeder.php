<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create(['key' => 'office_lat', 'value' => '-6.200000']);
        Setting::create(['key' => 'office_lng', 'value' => '106.816666']);
        Setting::create(['key' => 'radius_meters', 'value' => '500']);
    }
}
