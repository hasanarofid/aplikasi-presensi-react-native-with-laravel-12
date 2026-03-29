@extends('layouts.admin')

@section('title', 'Employee Registration')

@section('content')
<div class="w-full">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500 font-medium tracking-wide">Add a new member to your operational workforce.</p>
        </div>
        <a href="{{ route('admin.employees.index') }}" class="text-slate-400 hover:text-[#1E3A8A] transition-colors font-bold flex items-center text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to Registry
        </a>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('admin.employees.store') }}" method="POST" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Full Name</label>
                    <input type="text" name="name" placeholder="e.g. John Doe" value="{{ old('name') }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Email Address</label>
                    <input type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium" required>
                </div>

                <!-- Position -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Corporate Position</label>
                    <input type="text" name="position" placeholder="e.g. Field Supervisor" value="{{ old('position') }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium">
                </div>

                <!-- Shift Selection -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Assigned Shift</label>
                    <select name="shift_id" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium appearance-none">
                        <option value="" disabled selected>Select an operational shift</option>
                        @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->name }} ({{ $shift->start_time }} - {{ $shift->end_time }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Access Password</label>
                    <input type="password" name="password" placeholder="••••••••" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium" required>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end">
                <button type="submit" class="bg-[#1E3A8A] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[#1e3a8aee] transform active:scale-[0.98] transition-all shadow-lg shadow-blue-900/10">
                    Register Employee
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
