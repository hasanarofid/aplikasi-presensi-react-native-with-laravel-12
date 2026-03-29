@extends('layouts.admin')

@section('title', 'Pending Approvals')

@section('content')
<div class="mb-10">
    <p class="text-sm text-slate-500 font-medium tracking-wide">Review and authorize operational requests from your personnel.</p>
</div>

<div class="space-y-12">
    <!-- Overtime Approvals -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden w-full">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <span class="text-lg font-black text-slate-800 uppercase tracking-tight">Extra Duty Authorization</span>
            <p class="text-[10px] text-blue-600 font-black uppercase tracking-[0.2em] mt-1">Overtime Requests Pipeline</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.15em] font-black">
                        <th class="px-8 py-6">Member Profile</th>
                        <th class="px-8 py-6">Target Date</th>
                        <th class="px-8 py-6">Temporal Span</th>
                        <th class="px-8 py-6">Operational Basis</th>
                        <th class="px-8 py-6 text-right">Review Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($overtimes as $ot)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-6 text-sm font-bold text-slate-800">{{ $ot->user->name }}</td>
                        <td class="px-8 py-6 text-sm text-slate-500">{{ $ot->date }}</td>
                        <td class="px-8 py-6 text-sm font-bold text-slate-700">{{ $ot->start_time }} - {{ $ot->end_time }}</td>
                        <td class="px-8 py-6 text-sm text-slate-500 max-w-xs truncate">{{ $ot->reason }}</td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end space-x-3">
                                 <form action="{{ route('admin.approvals.handle', ['type' => 'overtime', 'id' => $ot->id, 'action' => 'approve']) }}" method="POST">
                                    @csrf
                                    <button class="bg-[#1E3A8A] text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-[#1e3a8aee] shadow-lg shadow-blue-900/10 transition-all">Authorize</button>
                                 </form>
                                 <form action="{{ route('admin.approvals.handle', ['type' => 'overtime', 'id' => $ot->id, 'action' => 'reject']) }}" method="POST">
                                    @csrf
                                    <button class="border border-rose-200 text-rose-500 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-rose-50 transition-all">Decline</button>
                                 </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-12 text-center text-slate-400 font-medium text-sm italic">Queue currently vacated. No pending overtime requests.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Attendance Submissions -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden w-full">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <span class="text-lg font-black text-slate-800 uppercase tracking-tight">External Mission Validation</span>
            <p class="text-[10px] text-blue-600 font-black uppercase tracking-[0.2em] mt-1">Outside/Dinas Submissions</p>
        </div>
        <div class="overflow-x-auto">
             <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.15em] font-black">
                        <th class="px-8 py-6">Team Member</th>
                        <th class="px-8 py-6">Mission Type</th>
                        <th class="px-8 py-6">Mission Date</th>
                        <th class="px-8 py-6">Mission Context</th>
                        <th class="px-8 py-6 text-right">Executive Decision</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($submissions as $sub)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-6 text-sm font-bold text-slate-800">{{ $sub->user->name }}</td>
                        <td class="px-8 py-6">
                            <span class="bg-blue-50 text-[#1E3A8A] px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border border-blue-100">
                                {{ str_replace('_', ' ', $sub->type) }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-sm text-slate-500">{{ $sub->date }}</td>
                        <td class="px-8 py-6 text-sm text-slate-500 max-w-xs truncate">{{ $sub->reason }}</td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end space-x-3">
                                 <form action="{{ route('admin.approvals.handle', ['type' => 'attendance', 'id' => $sub->id, 'action' => 'approve']) }}" method="POST">
                                    @csrf
                                    <button class="bg-[#1E3A8A] text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-[#1e3a8aee] shadow-lg shadow-blue-900/10 transition-all">Grant</button>
                                 </form>
                                 <form action="{{ route('admin.approvals.handle', ['type' => 'attendance', 'id' => $sub->id, 'action' => 'reject']) }}" method="POST">
                                    @csrf
                                    <button class="border border-rose-200 text-rose-500 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-rose-50 transition-all">Dismiss</button>
                                 </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-12 text-center text-slate-400 font-medium text-sm italic">Status: Dormant. No pending attendance submissions.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Profile Update Requests -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden w-full">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <span class="text-lg font-black text-slate-800 uppercase tracking-tight">Identity Maintenance</span>
            <p class="text-[10px] text-blue-600 font-black uppercase tracking-[0.2em] mt-1">Credential Update Pipeline</p>
        </div>
        <div class="overflow-x-auto">
             <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.15em] font-black">
                        <th class="px-8 py-6">Identity Subject</th>
                        <th class="px-8 py-6">Proposed Data Modifications</th>
                        <th class="px-8 py-6 text-right">Approval Nexus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($profileUpdates as $profile)
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-6 text-sm font-bold text-slate-800">{{ $profile->user->name }}</td>
                        <td class="px-8 py-6 space-y-2">
                            @foreach($profile->new_data as $key => $value)
                                <div class="flex items-center text-xs">
                                    <span class="p-1 px-2 bg-slate-100 rounded text-slate-500 font-black uppercase text-[8px] mr-2">{{ $key }}</span>
                                    <span class="text-slate-700 font-bold">{{ $value }}</span>
                                </div>
                            @endforeach
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end space-x-3">
                                 <form action="{{ route('admin.approvals.handle', ['type' => 'profile', 'id' => $profile->id, 'action' => 'approve']) }}" method="POST">
                                    @csrf
                                    <button class="bg-[#1E3A8A] text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-[#1e3a8aee] shadow-lg shadow-blue-900/10 transition-all">Authorize Updates</button>
                                 </form>
                                 <form action="{{ route('admin.approvals.handle', ['type' => 'profile', 'id' => $profile->id, 'action' => 'reject']) }}" method="POST">
                                    @csrf
                                    <button class="border border-rose-200 text-rose-500 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-rose-50 transition-all">Cancel Request</button>
                                 </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="p-12 text-center text-slate-400 font-medium text-sm italic">No profile integrity changes detected in queue.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
