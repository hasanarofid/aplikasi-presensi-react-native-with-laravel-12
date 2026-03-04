@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-indigo-500">
        <div class="text-gray-500 text-sm font-medium">Total Employees</div>
        <div class="text-3xl font-bold text-gray-800">{{ $stats['employees'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-green-500">
        <div class="text-gray-500 text-sm font-medium">Present Today</div>
        <div class="text-3xl font-bold text-gray-800">{{ $stats['present_today'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-yellow-500">
        <div class="text-gray-500 text-sm font-medium">Pending Approvals</div>
        <div class="text-3xl font-bold text-gray-800">{{ $stats['pending_approvals'] }}</div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-blue-500">
        <div class="text-gray-500 text-sm font-medium">Active Shifts</div>
        <div class="text-3xl font-bold text-gray-800">{{ $stats['total_shifts'] }}</div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-sm">
    <h3 class="text-lg font-semibold mb-4">Office Location ({{ $radius }}m Radius)</h3>
    <div id="map" class="h-96 rounded-lg border border-gray-200"></div>
</div>
@endsection

@push('scripts')
<script>
    var map = L.map('map').setView([{{ $lat }}, {{ $lng }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    L.marker([{{ $lat }}, {{ $lng }}]).addTo(map).bindPopup('Office Location').openPopup();
    L.circle([{{ $lat }}, {{ $lng }}], { radius: {{ $radius }} }).addTo(map);
</script>
@endpush
