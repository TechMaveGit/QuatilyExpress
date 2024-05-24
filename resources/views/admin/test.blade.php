


<?php
$locations = [
        ["id" => "7649", "lat" => 37.7749, "lng" => -122.4194, "info" => "Driver 7649 details"],
        ["id" => "0097", "lat" => 37.7849, "lng" => -122.4294, "info" => "Driver 0097 details"],
        ["id" => "3042", "lat" => 37.7949, "lng" => -122.4394, "info" => "Driver 3042 details"],
        ["id" => "9281", "lat" => 37.7049, "lng" => -122.4094, "info" => "Driver 9281 details"]
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
            var specificLocations = @json($specificLocations??null);
            
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


<!DOCTYPE html>
<html>
<head>
    <title>Driver Locations</title>
    <style>
        #map { height: 600px; width: 100%; }
        .custom-marker {
            background-color: #ffa500;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>
    <script>
        // Initialize the map
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 37.7749, lng: -122.4194},
                zoom: 12
            });

            // Fetch driver data from PHP
            fetch('drivers.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(driver => {
                        // Create a custom marker element
                        var markerDiv = document.createElement('div');
                        markerDiv.className = 'custom-marker';
                        markerDiv.innerHTML = 'TRACKING #' + driver.id;

                        // Create an info window
                        var infoWindow = new google.maps.InfoWindow({
                            content: `<div>
                                <h3>Tracking #${driver.id}</h3>
                                <p>Name: ${driver.name}</p>
                                <p>Status: ${driver.status}</p>
                            </div>`
                        });

                        // Create a custom marker
                        var customMarker = new google.maps.Marker({
                            position: {lat: driver.lat, lng: driver.lng},
                            map: map,
                            label: {
                                text: ' ',
                                className: 'custom-marker-label'
                            },
                            icon: {
                                labelOrigin: new google.maps.Point(0, 0),
                                url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="40">
                                        <rect x="0" y="0" width="100" height="40" fill="#ffa500"/>
                                        <text x="50%" y="50%" alignment-baseline="middle" text-anchor="middle" font-size="14" font-family="Arial" fill="white">TRACKING #${driver.id}</text>
                                    </svg>
                                `)
                            }
                        });

                        // Add click event to the marker to show info window
                        customMarker.addListener('click', function() {
                            infoWindow.open(map, customMarker);
                        });
                    });
                })
                .catch(error => console.error('Error fetching driver data:', error));
        }

        // Load the map
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
</body>
</html>

