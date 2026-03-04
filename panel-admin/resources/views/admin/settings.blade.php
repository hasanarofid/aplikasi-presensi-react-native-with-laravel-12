@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="max-w-2xl bg-white p-8 rounded-lg shadow-sm">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Office Latitude</label>
                <input type="text" name="lat" value="{{ $settings['lat'] }}" class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Office Longitude</label>
                <input type="text" name="lng" value="{{ $settings['lng'] }}" class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Presence Radius (Meters)</label>
                <input type="number" name="radius" value="{{ $settings['radius'] }}" class="w-full p-3 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div id="settings-map" class="h-64 rounded-lg border border-gray-200"></div>
            <button type="submit" class="bg-indigo-900 text-white py-3 px-6 rounded font-bold hover:bg-indigo-800 transition">Save Settings</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    var map = L.map('settings-map').setView([{{ $settings['lat'] }}, {{ $settings['lng'] }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    var marker = L.marker([{{ $settings['lat'] }}, {{ $settings['lng'] }}], {draggable: true}).addTo(map);

    marker.on('dragend', function(e) {
        var position = marker.getLatLng();
        document.getElementsByName('lat')[0].value = position.lat;
        document.getElementsByName('lng')[0].value = position.lng;
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementsByName('lat')[0].value = e.latlng.lat;
        document.getElementsByName('lng')[0].value = e.latlng.lng;
    });
</script>
@endpush
