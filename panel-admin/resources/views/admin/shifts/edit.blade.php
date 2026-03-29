@extends('layouts.admin')

@section('title', 'Modify Operational Shift')

@section('content')
<div class="w-full">
    <div class="mb-10 flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500 font-medium tracking-wide">Adjusting temporal parameters for **{{ $shift->name }}**.</p>
        </div>
        <a href="{{ route('admin.shifts.index') }}" class="text-slate-400 hover:text-[#1E3A8A] transition-colors font-bold flex items-center text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back to Shift Matrix
        </a>
    </div>

    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 mb-8">
        <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Name -->
                <div class="md:col-span-1">
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Shift Designation</label>
                    <input type="text" name="name" value="{{ old('name', $shift->name) }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium" required>
                </div>

                <!-- Start Time -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Commencement Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time', $shift->start_time) }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium font-mono" required>
                </div>

                <!-- End Time -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Termination Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time', $shift->end_time) }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium font-mono" required>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end">
                <button type="submit" class="bg-[#1E3A8A] text-white py-4 px-12 rounded-2xl font-bold hover:bg-[#1e3a8aee] transform active:scale-[0.98] transition-all shadow-lg shadow-blue-900/10">
                    Propagate Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
