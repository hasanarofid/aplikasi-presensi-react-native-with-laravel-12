@extends('layouts.admin')

@section('title', 'Workforce Registry')

@section('content')
<div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
    <div>
        <p class="text-sm text-slate-500 font-medium tracking-wide">Manage your team members and their assignments.</p>
    </div>
    <a href="{{ route('admin.employees.create') }}" 
       class="bg-[#1E3A8A] text-white px-8 py-4 rounded-2xl shadow-lg shadow-blue-900/10 hover:bg-[#1e3a8aee] transform active:scale-[0.98] transition-all font-bold flex items-center">
        <i class="fas fa-plus-circle mr-2 text-lg"></i> Register New Employee
    </a>
</div>

<div class="bg-white rounded-[2.5rem] shadow-sm overflow-hidden border border-slate-100">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase tracking-[0.15em] font-black">
                    <th class="px-8 py-6">Member Profile</th>
                    <th class="px-8 py-6">Department/Role</th>
                    <th class="px-8 py-6 text-center">Shift Schedule</th>
                    <th class="px-8 py-6 text-right">Administrative Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($employees as $emp)
                <tr class="hover:bg-slate-50/30 transition-colors group">
                    <td class="px-8 py-6">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-50 text-[#1E3A8A] flex items-center justify-center font-black mr-4 border border-blue-100/50 uppercase">
                                {{ substr($emp->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $emp->name }}</p>
                                <p class="text-[11px] text-slate-400 font-medium">{{ $emp->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200/50 uppercase tracking-wider">
                            {{ $emp->position ?? 'Staff Member' }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-center">
                        @if($emp->shift)
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                <i class="fas fa-clock mr-1.5"></i> {{ $emp->shift->name }}
                            </div>
                        @else
                            <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-50 text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-100">
                                Unassigned
                            </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end items-center space-x-3 opacity-40 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.employees.edit', $emp->id) }}" 
                               class="h-9 w-9 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center hover:bg-blue-50 hover:text-[#1E3A8A] transition-all"
                               title="Edit Profile">
                                <i class="fas fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.employees.destroy', $emp->id) }}" method="POST" onsubmit="return confirm('Archive this employee record?')">
                                @csrf @method('DELETE')
                                <button class="h-9 w-9 bg-slate-100 text-slate-400 rounded-xl flex items-center justify-center hover:bg-rose-50 hover:text-rose-600 transition-all"
                                        title="Archive Record">
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
    
    @if($employees->hasPages())
    <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
        {{ $employees->links() }}
    </div>
    @endif
</div>
@endsection

