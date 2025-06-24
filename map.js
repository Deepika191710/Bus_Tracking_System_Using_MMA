const map = L.map('map').setView([13.052, 80.234], 14);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

let gpsPoints = [];

// Watch your mobile position in real-time
navigator.geolocation.watchPosition(
  position => {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;

    // Add new GPS point
    gpsPoints.push([lng, lat]);

    // Draw latest point
    L.circleMarker([lat, lng], { radius: 6, color: 'green' }).addTo(map);
    map.setView([lat, lng], 16);

    // Once we have 5+ points, do map matching
    if (gpsPoints.length >= 5) {
      const coordsStr = gpsPoints.map(c => c.join(',')).join(';');
      fetch(`https://router.project-osrm.org/match/v1/driving/${coordsStr}?geometries=geojson&overview=full`)
        .then(res => res.json())
        .then(result => {
          if (result.matchings && result.matchings.length > 0) {
            const matched = result.matchings[0].geometry.coordinates;
            const latlngs = matched.map(c => [c[1], c[0]]);
            L.polyline(latlngs, { color: 'blue' }).addTo(map);

            const duration = result.matchings[0].duration;
            const stops = ["Stop 1", "Stop 2", "Stop 3"];
            const interval = duration / stops.length;
            stops.forEach((stop, i) => {
              const eta = new Date(Date.now() + interval * 1000 * (i + 1));
              console.log(`${stop} ETA: ${eta.toLocaleTimeString()}`);
            });
          }
        });
    }
  },
  error => {
    alert("Geolocation error: " + error.message);
  },
  { enableHighAccuracy: true, maximumAge: 10000 }
);
