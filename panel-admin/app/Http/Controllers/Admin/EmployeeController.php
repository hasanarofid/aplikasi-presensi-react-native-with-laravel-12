<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('role', 'employee')->with('shift')->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $shifts = Shift::all();
        return view('admin.employees.create', compact('shifts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'shift_id' => 'required|exists:shifts,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'shift_id' => $request->shift_id,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee added successfully');
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $shifts = Shift::all();
        return view('admin.employees.edit', compact('employee', 'shifts'));
    }

    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'shift_id' => 'required|exists:shifts,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'shift_id' => $request->shift_id,
            'position' => $request->position,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully');
    }
}
