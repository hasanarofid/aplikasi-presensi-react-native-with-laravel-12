@extends('layouts.admin')

@section('title', 'Pending Approvals')

@section('content')
<div class="space-y-8">
    <!-- Overtime Approvals -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 bg-gray-50 font-bold text-gray-700">Overtime Requests</div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-sm uppercase">
                        <th class="p-4">Employee</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Time</th>
                        <th class="p-4">Reason</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($overtimes as $ot)
                    <tr>
                        <td class="p-4 font-medium">{{ $ot->user->name }}</td>
                        <td class="p-4">{{ $ot->date }}</td>
                        <td class="p-4">{{ $ot->start_time }} - {{ $ot->end_time }}</td>
                        <td class="p-4 text-gray-600">{{ $ot->reason }}</td>
                        <td class="p-4 flex space-x-2">
                             <form action="{{ route('admin.approvals.handle', ['type' => 'overtime', 'id' => $ot->id, 'action' => 'approve']) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Approve</button>
                             </form>
                             <form action="{{ route('admin.approvals.handle', ['type' => 'overtime', 'id' => $ot->id, 'action' => 'reject']) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Reject</button>
                             </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400">No pending overtime requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Attendance Submissions -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 bg-gray-50 font-bold text-gray-700">Attendance Submissions (Outside/Dinas)</div>
        <div class="overflow-x-auto">
             <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-sm uppercase">
                        <th class="p-4">Employee</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">Date</th>
                        <th class="p-4">Reason</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($submissions as $sub)
                    <tr>
                        <td class="p-4 font-medium">{{ $sub->user->name }}</td>
                        <td class="p-4"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">{{ str_replace('_', ' ', $sub->type) }}</span></td>
                        <td class="p-4">{{ $sub->date }}</td>
                        <td class="p-4 text-gray-600">{{ $sub->reason }}</td>
                        <td class="p-4 flex space-x-2">
                             <form action="{{ route('admin.approvals.handle', ['type' => 'attendance', 'id' => $sub->id, 'action' => 'approve']) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Approve</button>
                             </form>
                             <form action="{{ route('admin.approvals.handle', ['type' => 'attendance', 'id' => $sub->id, 'action' => 'reject']) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Reject</button>
                             </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-8 text-center text-gray-400">No pending attendance submissions</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Profile Update Requests -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-4 border-b border-gray-200 bg-gray-50 font-bold text-gray-700">Profile Update Requests</div>
        <div class="overflow-x-auto">
             <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-400 text-sm uppercase">
                        <th class="p-4">Employee</th>
                        <th class="p-4">Proposed Data</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($profileUpdates as $profile)
                    <tr>
                        <td class="p-4 font-medium">{{ $profile->user->name }}</td>
                        <td class="p-4 text-sm">
                            @foreach($profile->new_data as $key => $value)
                                <div><span class="font-bold">{{ ucfirst($key) }}:</span> {{ $value }}</div>
                            @endforeach
                        </td>
                        <td class="p-4 flex space-x-2">
                             <form action="{{ route('admin.approvals.handle', ['type' => 'profile', 'id' => $profile->id, 'action' => 'approve']) }}" method="POST">
                                @csrf
                                <button class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Approve</button>
                             </form>
                             <form action="{{ route('admin.approvals.handle', ['type' => 'profile', 'id' => $profile->id, 'action' => 'reject']) }}" method="POST">
                                @csrf
                                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Reject</button>
                             </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-8 text-center text-gray-400">No pending profile updates</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
