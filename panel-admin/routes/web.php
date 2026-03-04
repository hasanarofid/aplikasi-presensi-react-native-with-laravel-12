<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ShiftController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('employees', EmployeeController::class);
    Route::resource('shifts', ShiftController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::get('approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::post('approvals/{type}/{id}/{action}', [ApprovalController::class, 'handle'])->name('approvals.handle');

    Route::get('/settings', function() {
        $settings = [
            'lat' => Setting::where('key', 'office_lat')->first()?->value ?? '-6.200000',
            'lng' => Setting::where('key', 'office_lng')->first()?->value ?? '106.816666',
            'radius' => Setting::where('key', 'radius_meters')->first()?->value ?? '500',
        ];
        return view('admin.settings', compact('settings'));
    })->name('settings');

    Route::post('/settings', function(Request $request) {
        Setting::updateOrCreate(['key' => 'office_lat'], ['value' => $request->lat]);
        Setting::updateOrCreate(['key' => 'office_lng'], ['value' => $request->lng]);
        Setting::updateOrCreate(['key' => 'radius_meters'], ['value' => $request->radius]);
        return back()->with('success', 'Settings updated successfully.');
    })->name('settings.update');
});
