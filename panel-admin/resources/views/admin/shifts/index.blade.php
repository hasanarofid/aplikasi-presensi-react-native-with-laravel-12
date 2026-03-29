@extends('layouts.admin')

@section('title', 'Operational Shifts')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
    <div>
        <p class="text-sm text-slate-500 font-medium tracking-wide">Configure and manage working hours for your workforce.</p>
    </div>
    <a href="{{ route('admin.shifts.create') }}" 
       class="bg-[#1E3A8A] text-white px-8 py-4 rounded-2xl shadow-lg shadow-blue-900/10 hover:bg-[#1e3a8aee] transform active:scale-[0.98] transition-all font-bold flex items-center">
        <i class="fas fa-plus-circle mr-2 text-lg"></i> Create New Shift
    </a>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden border border-slate-100 w-full font-inter">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-[0.15em] font-black">
                    <th class="px-8 py-6">Shift Name</th>
                    <th class="px-8 py-6">Start Time</th>
                    <th class="px-8 py-6 text-center">End Time</th>
                    <th class="px-8 py-6 text-right">Administrative Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($shifts as $shift)
                <tr class="hover:bg-slate-50/30 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-50 text-[#1E3A8A] flex items-center justify-center font-black mr-4 border border-blue-100/50 uppercase">
                                <i class="fas fa-clock text-xs"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-800">{{ $shift->name }}</span>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 uppercase tracking-wider">
                            {{ $shift->start_time }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-xs font-bold text-rose-600 bg-rose-50 px-3 py-1.5 rounded-lg border border-rose-100 uppercase tracking-wider">
                            {{ $shift->end_time }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end items-center space-x-3 opacity-40 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.shifts.edit', $shift->id) }}" 
                               class="h-9 w-9 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center hover:bg-blue-50 hover:text-[#1E3A8A] transition-all"
                               title="Edit Shift">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('Archive this operational shift?')">
                                @csrf @method('DELETE')
                                <button class="h-9 w-9 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-600 transition-all"
                                        title="Delete Shift">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

