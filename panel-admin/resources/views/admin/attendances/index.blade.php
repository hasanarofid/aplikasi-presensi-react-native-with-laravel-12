@extends('layouts.admin')

@section('title', 'Attendance Logs')

@section('content')
<div class="mb-10">
    <p class="text-sm text-slate-500 font-medium tracking-wide">Historical track record of employee presence and clocking operations.</p>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden w-full">
    <div class="p-8 border-b border-slate-50 bg-slate-50/30 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
        <div>
            <span class="text-lg font-black text-slate-800 uppercase tracking-tight">Recent Activity Logs</span>
            <p class="text-[10px] text-blue-600 font-black uppercase tracking-[0.2em] mt-1">Operational Audit Trail</p>
        </div>
        <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100">
            <span class="text-xs font-bold text-[#1E3A8A]">Showing last 50 entries</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-slate-400 text-[10px] uppercase tracking-[0.15em] font-black">
                    <th class="px-8 py-6">Operational Member</th>
                    <th class="px-8 py-6">Logging Date</th>
                    <th class="px-8 py-6">Clock In</th>
                    <th class="px-8 py-6 text-center">Clock Out</th>
                    <th class="px-8 py-6 text-right">Verification Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($attendances as $att)
                <tr class="hover:bg-slate-50/30 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="h-9 w-9 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold mr-3 border border-slate-200/50 text-xs">
                                {{ substr($att->user->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-bold text-slate-800">{{ $att->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500 font-medium">{{ $att->date }}</td>
                    <td class="px-8 py-6 text-sm">
                        <span class="font-bold text-slate-700">{{ $att->clock_in ?? '--:--' }}</span>
                    </td>
                    <td class="px-8 py-6 text-center text-sm">
                        <span class="font-bold text-slate-700">{{ $att->clock_out ?? '--:--' }}</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        @if($att->clock_in && $att->clock_out)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-wider border border-emerald-100">
                                <i class="fas fa-check-double mr-1.5"></i> Complete
                            </span>
                        @elseif($att->clock_in)
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-wider border border-amber-100">
                                <i class="fas fa-spinner fa-spin mr-1.5"></i> In Progress
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-rose-50 text-rose-700 text-[10px] font-black uppercase tracking-wider border border-rose-100">
                                <i class="fas fa-user-slash mr-1.5"></i> Absentee
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
