<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceSubmission;
use App\Models\Overtime;
use App\Models\ProfileUpdate;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $overtimes = Overtime::with('user')->where('status', 'pending')->get();
        $submissions = AttendanceSubmission::with('user')->where('status', 'pending')->get();
        $profileUpdates = ProfileUpdate::with('user')->where('status', 'pending')->get();

        return view('admin.approvals', compact('overtimes', 'submissions', 'profileUpdates'));
    }

    public function handle($type, $id, $action)
    {
        $status = $action === 'approve' ? 'approved' : 'rejected';

        if ($type === 'overtime') {
            Overtime::findOrFail($id)->update(['status' => $status]);
        } elseif ($type === 'attendance') {
            AttendanceSubmission::findOrFail($id)->update(['status' => $status]);
        } elseif ($type === 'profile') {
            $update = ProfileUpdate::findOrFail($id);
            if ($status === 'approved') {
                $update->user->update($update->new_data);
            }
            $update->update(['status' => $status]);
        }

        return back()->with('success', 'Request ' . $status . ' successfully.');
    }
}
