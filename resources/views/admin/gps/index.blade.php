@extends('layouts.admin')

@section('title', 'GPS Tracking')

@section('content')

@includeIf('admin.partials.navbar')

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="container p-4">
    <h2 class="text-2xl font-bold mb-4">Ambulance GPS Tracking</h2>

    {{-- Select Ambulance --}}
    <div class="mb-4">
        <label for="ambulance-select" class="font-semibold text-gray-700">🚑 Select Ambulance:</label>
        <select id="ambulance-select" class="border p-2 rounded w-full">
            <option value="">-- Choose an ambulance --</option>
            @foreach ($ambulances as $ambulance)
                <option value="{{ $ambulance->id }}">{{ $ambulance->name }} (ID: {{ $ambulance->id }})</option>
            @endforeach
        </select>
    </div>



    <!-- type location -->
        <div class="mb-4">
    <label for="destination-input" class="font-semibold text-gray-700">📍 Type Destination (Optional):</label>
    <input type="text" id="destination-input" placeholder="e.g. City Hall, Barangay 12" class="border p-2 rounded w-full mb-2">
    <ul id="suggestions" class="border bg-white rounded mt-1 shadow max-h-40 overflow-y-auto text-sm hidden z-50 absolute w-full"></ul>
    <button onclick="searchDestination()" class="bg-blue-500 text-white px-4 py-2 rounded">
        Find & Set Destination
    </button>
</div>




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
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


        {{-- Notifications --}}
    <div id="notification-feed" class="bg-white p-4 rounded shadow mb-4 max-h-70 overflow-y-auto">
        <h3 class="text-lg font-semibold mb-2">📢 Notifications</h3>
        <ul id="notifications" class="space-y-2 text-sm text-gray-800">
            <!-- Messages will appear here -->
        </ul>
    </div>


    
</div>



{{-- Leaflet CSS & JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    var map = L.map('map').setView([14.5995, 120.9842], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let markers = {};
    let trails = {};
    let positions = {};
    let destMarkers = {};

    const ambulanceIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/843/843313.png',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    const destIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/128/684/684908.png',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        popupAnchor: [0, -30]
    });

    let selectedAmbulanceId = null;
    document.getElementById('ambulance-select').addEventListener('change', function () {
        selectedAmbulanceId = this.value;
    });

    function fetchAmbulanceData() {
        fetch("{{ route('admin.gps.data') }}")
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector("tbody");
                tableBody.innerHTML = "";

                if (!window.displayedNotifications) window.displayedNotifications = {};

                data.forEach((amb, index) => {
                    // --- GPS marker + trail ---
                    if (amb.latitude && amb.longitude) {
                        let latLng = [amb.latitude, amb.longitude];

                        if (!positions[amb.id]) positions[amb.id] = [];
                        positions[amb.id].push(latLng);
                        if (positions[amb.id].length > 30) positions[amb.id].shift();

                        if (markers[amb.id]) {
                            markers[amb.id].setLatLng(latLng);
                            markers[amb.id].setPopupContent(`<strong>${amb.name}</strong><br>Status: ${amb.status}`);
                        } else {
                            markers[amb.id] = L.marker(latLng, { icon: ambulanceIcon })
                                .addTo(map)
                                .bindPopup(`<strong>${amb.name}</strong><br>Status: ${amb.status}`);
                        }

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

                    // --- Destination pin ---
                    if (amb.destination_latitude && amb.destination_longitude) {
                        const destLatLng = [amb.destination_latitude, amb.destination_longitude];
                        if (destMarkers[amb.id]) {
                            destMarkers[amb.id].setLatLng(destLatLng);
                        } else {
                            destMarkers[amb.id] = L.marker(destLatLng, { icon: destIcon })
                                .addTo(map)
                                .bindPopup(`📍 Destination for ${amb.name}`);
                        }
                    } else {
                        if (destMarkers[amb.id]) {
                            map.removeLayer(destMarkers[amb.id]);
                            delete destMarkers[amb.id];
                        }
                    }

                    // --- Notification logic ---
                    if (amb.status === 'Available' &&
                        amb.destination_latitude === null &&
                        amb.destination_longitude === null) {
                        const lastUpdated = new Date(amb.updated_at).toLocaleTimeString();
                        const notifKey = `arrived-${amb.id}-${amb.updated_at}`;

                        if (!window.displayedNotifications[notifKey]) {
                            const notif = document.createElement('li');
                            notif.innerHTML = `<strong>[${lastUpdated}]</strong> ✅ Ambulance <strong>${amb.name}</strong> has arrived.`;
                            document.getElementById('notifications').prepend(notif);
                            window.displayedNotifications[notifKey] = true;

                            // Optional auto-fade
                            setTimeout(() => notif.remove(), 15000);
                        }
                    }

                    // --- Table row ---
                    const row = document.createElement("tr");
                    row.className = "border-t";
                    row.innerHTML = `
                        <td class="px-4 py-2">${index + 1}</td>
                        <td class="px-4 py-2 font-medium">${amb.name}</td>
                        <td class="px-4 py-2">${amb.latitude ?? 'N/A'}</td>
                        <td class="px-4 py-2">${amb.longitude ?? 'N/A'}</td>
                        <td class="px-4 py-2">${amb.updated_at}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-white 
                                ${amb.status === 'Available' ? 'bg-green-500' :
                                  amb.status === 'Out' ? 'bg-yellow-500' : 'bg-red-500'}">
                                ${amb.status}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <button onclick="clearDestination(${amb.id})" class="bg-red-500 text-white px-2 py-1 rounded text-xs">Clear</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            });
    }

    function clearDestination(id) {
        fetch(`/admin/ambulance/${id}/clear-destination`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(() => {
            console.log(`🧹 Destination cleared for ambulance ${id}`);
            fetchAmbulanceData();
        })
        .catch(err => console.error("❌ Clear failed:", err));
    }

    map.on('click', function (e) {
        if (!selectedAmbulanceId) {
            alert("⚠️ Please select an ambulance first.");
            return;
        }

        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        fetch(`/admin/ambulance/${selectedAmbulanceId}/set-destination`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ latitude: lat, longitude: lng })
        })
        .then(res => res.json())
        .then(data => {
            console.log("📍 Destination set:", data);
            fetchAmbulanceData();
        })
        .catch(err => console.error("❌ Set failed:", err));
    });

    fetchAmbulanceData();
    setInterval(fetchAmbulanceData, 5000);



    function searchDestination() {
    const query = document.getElementById('destination-input').value;
    if (!selectedAmbulanceId) {
        alert("⚠️ Please select an ambulance first.");
        return;
    }
    if (!query) {
        alert("❌ Please type a destination name.");
        return;
    }

    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&lang=en`)
        .then(response => response.json())
        .then(data => {
            if (!data.features || data.features.length === 0) {
                alert("❌ No results found for that location.");
                return;
            }

            // Photon gives coordinates in [lon, lat] format
            const [lon, lat] = data.features[0].geometry.coordinates;

            fetch(`/admin/ambulance/${selectedAmbulanceId}/set-destination`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ latitude: lat, longitude: lon })
            })
            .then(res => res.json())
            .then(data => {
                console.log("📍 Destination set via Photon search:", data);
                fetchAmbulanceData();
                map.setView([lat, lon], 15); // Zoom in on found location
            })
            .catch(err => console.error("❌ Set failed:", err));
        })
        .catch(err => {
            console.error("🛑 Geocoding error:", err);
            alert("Something went wrong with geocoding.");
        });
}


const input = document.getElementById('destination-input');
const suggestionBox = document.getElementById('suggestions');

// Autocomplete logic
input.addEventListener('input', () => {
    const query = input.value.trim();

    if (query.length < 3) {
        suggestionBox.innerHTML = '';
        suggestionBox.classList.add('hidden');
        return;
    }

    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&lang=en&limit=5`)
        .then(res => res.json())
        .then(data => {
            suggestionBox.innerHTML = '';
            if (!data.features || data.features.length === 0) {
                suggestionBox.classList.add('hidden');
                return;
            }

            data.features.forEach(feature => {
                const name = feature.properties.name || 'Unnamed location';
                const city = feature.properties.city || '';
                const country = feature.properties.country || '';
                const [lon, lat] = feature.geometry.coordinates;

                const li = document.createElement('li');
                li.textContent = `${name}${city ? ', ' + city : ''}${country ? ', ' + country : ''}`;
                li.className = 'px-3 py-2 hover:bg-blue-100 cursor-pointer';
                li.addEventListener('click', () => {
                    input.value = li.textContent;
                    suggestionBox.innerHTML = '';
                    suggestionBox.classList.add('hidden');

                    // Trigger destination assignment
                    fetch(`/admin/ambulance/${selectedAmbulanceId}/set-destination`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ latitude: lat, longitude: lon })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log("📍 Destination set via autocomplete:", data);
                        fetchAmbulanceData();
                        map.setView([lat, lon], 15);
                    })
                    .catch(err => console.error("❌ Autocomplete set failed:", err));
                });

                suggestionBox.appendChild(li);
            });

            suggestionBox.classList.remove('hidden');
        });
});

// Hide suggestions if clicked outside
document.addEventListener('click', function (e) {
    if (!input.contains(e.target) && !suggestionBox.contains(e.target)) {
        suggestionBox.classList.add('hidden');
    }
});


</script>

@endsection
