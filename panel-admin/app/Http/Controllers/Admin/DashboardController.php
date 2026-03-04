<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSubmission;
use App\Models\Overtime;
use App\Models\ProfileUpdate;
use App\Models\Shift;
use App\Models\User;
use App\Models\Setting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'employees' => User::where('role', 'employee')->count(),
            'present_today' => Attendance::where('date', Carbon::today())->count(),
            'pending_approvals' => Overtime::where('status', 'pending')->count() +
                                 AttendanceSubmission::where('status', 'pending')->count() +
                                 ProfileUpdate::where('status', 'pending')->count(),
            'total_shifts' => Shift::count(),
        ];

        $lat = Setting::where('key', 'office_lat')->first()?->value ?? '-6.200000';
        $lng = Setting::where('key', 'office_lng')->first()?->value ?? '106.816666';
        $radius = Setting::where('key', 'radius_meters')->first()?->value ?? '500';

        return view('admin.dashboard', compact('stats', 'lat', 'lng', 'radius'));
    }
}
