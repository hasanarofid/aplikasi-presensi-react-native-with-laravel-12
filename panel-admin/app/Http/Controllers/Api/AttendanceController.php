<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->attendances();

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->orderBy('date', 'desc')->get());
    }

    public function clockIn(Request $request)
    {
        $request->validate([
            'lat' => 'required',
            'lng' => 'required',
            'photo' => 'required|image|max:2048',
        ]);

        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $existing = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if ($existing && $existing->clock_in) {
            return response()->json(['message' => 'Already clocked in today'], 422);
        }

        $photoPath = $request->file('photo')->store('attendances/in', 'public');

        $attendance = Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            [
                'clock_in' => Carbon::now()->toTimeString(),
                'lat_in' => $request->lat,
                'lng_in' => $request->lng,
                'photo_in' => $photoPath,
            ]
        );

        return response()->json([
            'message' => 'Clock in successful',
            'attendance' => $attendance,
        ]);
    }

    public function clockOut(Request $request)
    {
        $request->validate([
            'lat' => 'required',
            'lng' => 'required',
            'photo' => 'required|image|max:2048',
        ]);

        $user = $request->user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();

        if (! $attendance || ! $attendance->clock_in) {
            return response()->json(['message' => 'You must clock in first'], 422);
        }

        if ($attendance->clock_out) {
            return response()->json(['message' => 'Already clocked out today'], 422);
        }

        $photoPath = $request->file('photo')->store('attendances/out', 'public');

        $attendance->update([
            'clock_out' => Carbon::now()->toTimeString(),
            'lat_out' => $request->lat,
            'lng_out' => $request->lng,
            'photo_out' => $photoPath,
        ]);

        return response()->json([
            'message' => 'Clock out successful',
            'attendance' => $attendance,
        ]);
    }

    public function getSettings()
    {
        $officeLat = Setting::where('key', 'office_lat')->first()?->value ?? '-6.200000';
        $officeLng = Setting::where('key', 'office_lng')->first()?->value ?? '106.816666';
        $radius = Setting::where('key', 'radius_meters')->first()?->value ?? '500';

        return response()->json([
            'office_lat' => (float) $officeLat,
            'office_lng' => (float) $officeLng,
            'radius_meters' => (int) $radius,
        ]);
    }
}
