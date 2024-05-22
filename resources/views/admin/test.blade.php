


<?php
$locations = DB::table('track_location')->where('shiftid','1')->select('latitude','longitude')->get()->toArray();
$specificLocations = [
        ['lat' => 28.6299631, 'lng' => 77.3809043], // Add your specific latitude and longitude values
        // Add more specific locations as needed
    ];
// dd($locations);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Route Tracking on Google Maps</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s"></script>
    <style>
        .info-window-content {
            text-align: center;
        }
        .info-window-content img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
    <script>
        function initMap() {
            var locations = @json($locations);
            var specificLocations = @json($specificLocations);
            
            // Ensure that latitude and longitude are numbers
            locations = locations.map(function(location) {
                return {
                    lat: parseFloat(location.latitude),
                    lng: parseFloat(location.longitude)
                };
            });

            specificLocations = specificLocations.map(function(location) {
                return {
                    lat: parseFloat(location.lat),
                    lng: parseFloat(location.lng)
                };
            });

            if (!locations.length) {
                console.error('No location data available.');
                return;
            }

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: locations[0]  // Center the map on the first point
            });

            var routeCoordinates = locations;

            var routePath = new google.maps.Polyline({
                path: routeCoordinates,
                geodesic: true,
                strokeColor: '#0000FF',
                strokeOpacity: 1.0,
                strokeWeight: 2
            });

            routePath.setMap(map);

            // Custom Icons
            var truckIcon = 'http://maps.google.com/mapfiles/kml/shapes/truck.png';
            var packageIcon = 'http://maps.google.com/mapfiles/kml/paddle/grn-stars.png';

            // Start Marker
            var startMarker = new google.maps.Marker({
                position: routeCoordinates[0],
                map: map,
                title: 'Start Point',
                icon: truckIcon
            });

            var startInfoWindow = new google.maps.InfoWindow({
                content: '<div class="info-window-content"><img src="https://via.placeholder.com/50" alt="User Profile"><h3>Start Location</h3><p>User details here</p></div>'
            });

            startMarker.addListener('click', function() {
                startInfoWindow.open(map, startMarker);
            });

            // End Marker
            var endMarker = new google.maps.Marker({
                position: routeCoordinates[routeCoordinates.length - 1],
                map: map,
                title: 'End Point',
                icon: truckIcon
            });

            var endInfoWindow = new google.maps.InfoWindow({
                content: '<div class="info-window-content"><img src="https://via.placeholder.com/50" alt="User Profile"><h3>End Location</h3><p>User details here</p></div>'
            });

            endMarker.addListener('click', function() {
                endInfoWindow.open(map, endMarker);
            });

            // Special markers along the route if they match specific locations
            routeCoordinates.forEach(function(location, index) {
                specificLocations.forEach(function(specificLocation) {
                    if (location.lat === specificLocation.lat && location.lng === specificLocation.lng) {
                        var packageMarker = new google.maps.Marker({
                            position: location,
                            map: map,
                            title: 'Package Location',
                            icon: packageIcon
                        });

                        var packageInfoWindow = new google.maps.InfoWindow({
                            content: '<div class="info-window-content"><img src="https://via.placeholder.com/50" alt="Package"><h3>Package Location</h3><p>Delivery details here</p></div>'
                        });

                        packageMarker.addListener('click', function() {
                            packageInfoWindow.open(map, packageMarker);
                        });
                    }
                });
            });
        }
    </script>
</head>
<body onload="initMap()">
    <h3>Route Tracking on Google Maps</h3>
    <div id="map" style="height: 600px; width: 100%;"></div>
</body>
</html>


