<!DOCTYPE html>
<html>
<head>
    <title>Driver GPS Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        body { margin: 0; font-family: sans-serif; background: #f9f9f9; }
        #map { height: 500px; width: 100%; }
        .controls { padding: 1rem; text-align: center; }
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
        }
        #status { margin-top: 10px; }
    </style>
</head>
<body>

<div class="controls">
    <h2>🚑 Ambulance GPS Tracker</h2>
    <p><strong>Ambulance ID:</strong> {{ $ambulanceId }}</p>
    <div id="status">Tracking not started yet.</div>
    <button onclick="startTracking()">Start Sending Location</button>
    <br>
    <button onclick="markArrived()" style="background: #28a745;">✅ Mark as Arrived</button>
</div>

<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

<script>
    let ambulanceId = {{ $ambulanceId }};
    let map = L.map('map').setView([14.5995, 120.9842], 13);
    let routeControl = null;
    let currentMarker = null;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let tracking = false;

    function startTracking() {
        if (tracking) return;

        tracking = true;
        document.getElementById('status').innerText = "📡 Sending GPS every 5 seconds...";

        setInterval(() => {
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // Update backend with current position
                fetch("{{ route('update.location') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        id: ambulanceId,
                        latitude: lat,
                        longitude: lng
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('status').innerText = `✅ GPS sent at ${new Date().toLocaleTimeString()}`;

                    // Show current position on map
                    if (!currentMarker) {
                        currentMarker = L.marker([lat, lng]).addTo(map).bindPopup("🚑 You are here").openPopup();
                    } else {
                        currentMarker.setLatLng([lat, lng]);
                    }

                    // Refresh route to destination
                    updateRoute([lat, lng]);
                });

            }, error => {
                document.getElementById('status').innerText = "❌ GPS Error: " + error.message;
            });
        }, 5000);
    }

    function updateRoute(currentLocation) {
        fetch(`/driver/ambulance/${ambulanceId}/destination`)
            .then(response => response.json())
            .then(data => {
                const { destination_latitude, destination_longitude } = data;

                if (destination_latitude && destination_longitude) {
                    if (routeControl) {
                        routeControl.setWaypoints([
                            L.latLng(currentLocation[0], currentLocation[1]),
                            L.latLng(destination_latitude, destination_longitude)
                        ]);
                    } else {
                        routeControl = L.Routing.control({
                            waypoints: [
                                L.latLng(currentLocation[0], currentLocation[1]),
                                L.latLng(destination_latitude, destination_longitude)
                            ],
                            routeWhileDragging: false
                        }).addTo(map);
                    }
                }
            });
    }

    function markArrived() {
        fetch(`/driver/ambulance/${ambulanceId}/arrived`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            alert("🎉 Marked as arrived!");
            document.getElementById('status').innerText = "Status: ✅ Available";
            if (routeControl) {
                routeControl.setWaypoints([]); // clear route
                map.removeControl(routeControl);
                routeControl = null;
            }
        })
        .catch(err => {
            console.error("❌ Failed to mark as arrived:", err);
        });
    }
</script>

</body>
</html>
