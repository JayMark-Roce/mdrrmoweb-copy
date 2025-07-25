<!DOCTYPE html>
<html>
<head>
    <title>Driver Location Sender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 2rem; background: #f0f0f0; }
        button { background: #007bff; color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 5px; }
        #status { margin-top: 1rem; }
    </style>
</head>
<body>
    <h2>🚑 Ambulance GPS Sender</h2>
    <p>This device will send location every 5 seconds.</p>

    <input type="hidden" id="ambulance_id" value="1"> {{-- Replace 1 with the real ID later --}}

    <button onclick="startTracking()">Start Sending Location</button>

    <div id="status"></div>

    <script>
        let tracking = false;

        function startTracking() {
            tracking = true;
            document.getElementById('status').innerText = 'Tracking started...';

            setInterval(() => {
                if (!tracking) return;

                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const id = document.getElementById('ambulance_id').value;

                    fetch("{{ route('update.location') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            id: id,
                            latitude: latitude,
                            longitude: longitude
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log("✅ GPS sent:", data);
                        document.getElementById('status').innerText =
                            `Last sent: ${new Date().toLocaleTimeString()}`;
                    })
                    .catch(err => {
                        console.error("❌ Failed to send location:", err);
                        document.getElementById('status').innerText = '❌ Failed to send location';
                    });
                }, function(error) {
                    console.error("Geolocation error:", error.message);
                    document.getElementById('status').innerText = '❌ GPS not allowed or not available';
                });
            }, 5000);
        }
    </script>
</body>
</html>
