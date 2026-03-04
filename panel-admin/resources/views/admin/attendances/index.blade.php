@extends('layouts.admin')

@section('title', 'Attendance Logs')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
        <span class="font-bold text-gray-700">Recent Attendance Logs</span>
        <div class="text-sm text-gray-500">Showing last 50 entries</div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-400 text-sm uppercase">
                    <th class="p-4">Employee</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Clock In</th>
                    <th class="p-4">Clock Out</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($attendances as $att)
                <tr>
                    <td class="p-4 font-medium">{{ $att->user->name }}</td>
                    <td class="p-4">{{ $att->date }}</td>
                    <td class="p-4">{{ $att->clock_in ?? '-' }}</td>
                    <td class="p-4">{{ $att->clock_out ?? '-' }}</td>
                    <td class="p-4">
                        @if($att->clock_in && $att->clock_out)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Complete</span>
                        @elseif($att->clock_in)
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Active</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Absent</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
