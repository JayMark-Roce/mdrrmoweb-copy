@extends('layouts.admin')

@section('title', 'GPS Tracking')

@section('content')

@includeIf('admin.partials.navbar')

<div class="container p-4">
    <h2 class="text-2xl font-bold mb-4">Ambulance GPS Tracking</h2>

    {{-- MAP --}}
    <div id="map" class="rounded shadow mb-6" style="height: 500px; width: 100%;"></div>

    {{-- TABLE --}}
    <div class="bg-white shadow-md rounded p-4 overflow-x-auto">
        <h3 class="text-lg font-semibold mb-4">Ambulance Status Table</h3>
        <table class="w-full text-sm text-left text-gray-700 border">
            <thead class="bg-gray-100 text-xs uppercase text-gray-600 border-b">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Ambulance Name</th>
                    <th class="px-4 py-2">Latitude</th>
                    <th class="px-4 py-2">Longitude</th>
                    <th class="px-4 py-2">Last Updated</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ambulances as $index => $amb)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 font-medium">{{ $amb->name }}</td>
                        <td class="px-4 py-2">{{ $amb->latitude ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $amb->longitude ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $amb->updated_at->format('M d, Y h:i A') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-white 
                                @if($amb->status === 'Available') bg-green-500 
                                @elseif($amb->status === 'Out') bg-yellow-500 
                                @else bg-red-500 
                                @endif">
                                {{ $amb->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">No ambulance data yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

{{-- LIVE GPS SCRIPT --}}
<script>
    var map = L.map('map').setView([14.5995, 120.9842], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let markers = {};     // { ambulance_id: marker }
    let trails = {};      // { ambulance_id: polyline }
    let positions = {};   // { ambulance_id: [ [lat, lng], [lat, lng], ... ] }

    const ambulanceIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/843/843313.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    function fetchAmbulanceData() {
        fetch("{{ route('admin.gps.data') }}")
            .then(response => response.json())
            .then(data => {
                data.forEach(amb => {
                    if (amb.latitude && amb.longitude) {
                        let latLng = [amb.latitude, amb.longitude];

                        // Store path history
                        if (!positions[amb.id]) {
                            positions[amb.id] = [];
                        }
                        positions[amb.id].push(latLng);

                        // Limit trail length
                        if (positions[amb.id].length > 30) {
                            positions[amb.id].shift(); // remove oldest
                        }

                        // Update or create marker
                        if (markers[amb.id]) {
                            markers[amb.id].setLatLng(latLng);
                            markers[amb.id].setPopupContent(`<strong>${amb.name}</strong><br>Status: ${amb.status}`);
                        } else {
                            let marker = L.marker(latLng, { icon: ambulanceIcon })
                                .addTo(map)
                                .bindPopup(`<strong>${amb.name}</strong><br>Status: ${amb.status}`);
                            markers[amb.id] = marker;
                        }

                        // Draw or update trail (polyline)
                        if (trails[amb.id]) {
                            trails[amb.id].setLatLngs(positions[amb.id]);
                        } else {
                            trails[amb.id] = L.polyline(positions[amb.id], {
                                color: 'blue',
                                weight: 3,
                                opacity: 0.7
                            }).addTo(map);
                        }
                    }
                });
            });
    }

    fetchAmbulanceData();
    setInterval(fetchAmbulanceData, 5000);
</script>


@endsection
