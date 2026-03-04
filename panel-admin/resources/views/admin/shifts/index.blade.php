@extends('layouts.admin')

@section('title', 'Manage Shifts')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.shifts.create') }}" class="bg-indigo-900 text-white px-4 py-2 rounded shadow hover:bg-indigo-800 transition">
        <i class="fas fa-plus mr-2"></i> Add Shift
    </a>
</div>

<div class="bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
    <table class="w-full text-left">
        <thead>
            <tr class="bg-gray-50 text-gray-400 text-sm uppercase">
                <th class="p-4">Shift Name</th>
                <th class="p-4">Start Time</th>
                <th class="p-4">End Time</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($shifts as $shift)
            <tr>
                <td class="p-4 font-medium">{{ $shift->name }}</td>
                <td class="p-4">{{ $shift->start_time }}</td>
                <td class="p-4">{{ $shift->end_time }}</td>
                <td class="p-4 flex space-x-2">
                    <a href="{{ route('admin.shifts.edit', $shift->id) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('Delete this shift?')">
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
