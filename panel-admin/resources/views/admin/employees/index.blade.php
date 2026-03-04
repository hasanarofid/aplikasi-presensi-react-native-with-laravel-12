@extends('layouts.admin')

@section('title', 'Employee Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.employees.create') }}" class="bg-indigo-900 text-white px-4 py-2 rounded shadow hover:bg-indigo-800 transition">
        <i class="fas fa-plus mr-2"></i> Add Employee
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-50 text-gray-400 text-sm uppercase">
                <th class="p-4">Name</th>
                <th class="p-4">Email</th>
                <th class="p-4">Position</th>
                <th class="p-4">Shift</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($employees as $emp)
            <tr>
                <td class="p-4 font-medium">{{ $emp->name }}</td>
                <td class="p-4">{{ $emp->email }}</td>
                <td class="p-4 text-gray-600">{{ $emp->position }}</td>
                <td class="p-4">
                    <span class="bg-indigo-100 text-indigo-700 px-2 py-1 rounded text-xs">{{ $emp->shift->name ?? 'None' }}</span>
                </td>
                <td class="p-4 flex space-x-2">
                    <a href="{{ route('admin.employees.edit', $emp->id) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Delete this employee?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
