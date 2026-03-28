@extends('layouts.admin')

@section('title', 'System Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="p-4 bg-blue-50 text-[#1E3A8A] rounded-2xl">
            <i class="fas fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Employees</p>
            <p class="text-2xl font-black text-slate-800">{{ $stats['employees'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl">
            <i class="fas fa-user-check text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Present Today</p>
            <p class="text-2xl font-black text-slate-800">{{ $stats['present_today'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl">
            <i class="fas fa-hourglass-half text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pending Tasks</p>
            <p class="text-2xl font-black text-slate-800">{{ $stats['pending_approvals'] }}</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 flex items-center space-x-4">
        <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl">
            <i class="fas fa-layer-group text-2xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Active Shifts</p>
            <p class="text-2xl font-black text-slate-800">{{ $stats['total_shifts'] }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Operational Radius</h3>
                <p class="text-sm text-slate-500 font-medium">Monitoring area for automated presence validation.</p>
            </div>
            <div class="bg-blue-50 px-4 py-2 rounded-xl border border-blue-100">
                <span class="text-sm font-bold text-[#1E3A8A]">{{ $radius }}m Radius</span>
            </div>
        </div>
        <div id="map" class="h-[400px] rounded-[2rem] border-4 border-slate-50 shadow-inner z-0"></div>
    </div>

    <div class="bg-[#1E3A8A] p-8 rounded-[2.5rem] shadow-xl text-white relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-lg font-bold mb-2">Quick Actions</h3>
            <p class="text-blue-200 text-sm font-medium mb-8">Efficiently manage your workforce from here.</p>
            
            <div class="space-y-4">
                <a href="{{ route('admin.employees.index') }}" class="flex items-center p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-all border border-white/5">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="font-bold">Add New Employee</span>
                </a>
                <a href="{{ route('admin.approvals.index') }}" class="flex items-center p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-all border border-white/5">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <span class="font-bold">Review Pending Logs</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center p-4 bg-white/10 rounded-2xl hover:bg-white/20 transition-all border border-white/5">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span class="font-bold">Configure Settings</span>
                </a>
            </div>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/5 rounded-full"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var map = L.map('map', { zoomControl: false }).setView([{{ $lat }}, {{ $lng }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var officeIcon = L.divIcon({
        className: 'custom-div-icon',
        html: "<div style='background-color:#1E3A8A; width: 14px; height: 14px; border: 3px solid white; border-radius: 50%; box-shadow: 0 0 10px rgba(0,0,0,0.3);'></div>",
        iconSize: [20, 20],
        iconAnchor: [10, 10]
    });

    L.marker([{{ $lat }}, {{ $lng }}], { icon: officeIcon }).addTo(map)
        .bindPopup('<b class="text-[#1E3A8A]">FMS HQ Office</b><br>Centralized Attendance Point.')
        .openPopup();

    L.circle([{{ $lat }}, {{ $lng }}], { 
        radius: {{ $radius }},
        color: '#1E3A8A',
        fillColor: '#1E3A8A',
        fillOpacity: 0.1,
        weight: 2
    }).addTo(map);

    L.control.zoom({ position: 'bottomright' }).addTo(map);
</script>
<style>
    .leaflet-popup-content-wrapper { border-radius: 12px; padding: 5px; }
    .leaflet-popup-tip { background: white; }
</style>
@endpush
