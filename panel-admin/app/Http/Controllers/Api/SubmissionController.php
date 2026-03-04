<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSubmission;
use App\Models\Overtime;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function overtime(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'reason' => 'required',
        ]);

        $overtime = Overtime::create([
            'user_id' => $request->user()->id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Overtime submission successful',
            'overtime' => $overtime,
        ]);
    }

    public function attendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:outside_radius,official_duty',
            'reason' => 'required',
            'lat' => 'nullable',
            'lng' => 'nullable',
        ]);

        $submission = AttendanceSubmission::create([
            'user_id' => $request->user()->id,
            'date' => $request->date,
            'type' => $request->type,
            'reason' => $request->reason,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Attendance submission successful',
            'submission' => $submission,
        ]);
    }

    public function getHistory(Request $request)
    {
        $overtimes = $request->user()->overtimes()->orderBy('date', 'desc')->get();
        $submissions = $request->user()->attendanceSubmissions()->orderBy('date', 'desc')->get();

        return response()->json([
            'overtimes' => $overtimes,
            'attendance_submissions' => $submissions,
        ]);
    }
}
