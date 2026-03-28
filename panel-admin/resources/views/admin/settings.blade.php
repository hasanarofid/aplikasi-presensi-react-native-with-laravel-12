@extends('layouts.admin')

@section('title', 'System Configuration')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 mb-8">
        <div class="flex items-center mb-8 pb-6 border-b border-slate-50">
            <div class="p-3 bg-blue-50 text-[#1E3A8A] rounded-xl mr-4">
                <i class="fas fa-map-marked-alt text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800">Operational Boundaries</h3>
                <p class="text-sm text-slate-500">Define the headquarters location and allowed proximity radius.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Office Latitude</label>
                    <input type="text" name="lat" value="{{ $settings['lat'] }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Office Longitude</label>
                    <input type="text" name="lng" value="{{ $settings['lng'] }}" 
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-medium" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 tracking-wide uppercase text-[10px]">Detection Radius (Meters)</label>
                    <div class="relative">
                        <input type="number" name="radius" value="{{ $settings['radius'] }}" 
                            class="w-full p-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-[#1E3A8A] focus:border-transparent transition-all font-bold text-lg" required>
                        <div class="absolute right-4 top-4 text-slate-400 font-bold">Meters</div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-sm font-bold text-slate-700 tracking-wide uppercase text-[10px]">Pin Location on Map</label>
                <div id="settings-map" class="h-80 rounded-[2rem] border-4 border-slate-50 shadow-inner z-0"></div>
                <p class="text-[11px] text-slate-400 italic flex items-center">
                    <i class="fas fa-info-circle mr-1"></i> You can drag the marker or click anywhere on the map to set the office location.
                </p>
            </div>

            <div class="pt-6 border-t border-slate-50 flex justify-end">
                <button type="submit" class="bg-[#1E3A8A] text-white py-4 px-10 rounded-2xl font-bold hover:bg-[#1e3a8aee] transform active:scale-[0.98] transition-all shadow-lg shadow-blue-900/10">
                    Update Global Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var map = L.map('settings-map', { zoomControl: false }).setView([{{ $settings['lat'] }}, {{ $settings['lng'] }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
    
    var marker = L.marker([{{ $settings['lat'] }}, {{ $settings['lng'] }}], {
        draggable: true,
        icon: L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:#1E3A8A; width: 14px; height: 14px; border: 3px solid white; border-radius: 50%; box-shadow: 0 0 10px rgba(0,0,0,0.3);'></div>",
            iconSize: [20, 20],
            iconAnchor: [10, 10]
        })
    }).addTo(map);

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

    L.control.zoom({ position: 'bottomright' }).addTo(map);
</script>
@endpush

