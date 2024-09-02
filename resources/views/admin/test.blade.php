<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Delivery Route</title>
    
</head>
<body onload="initMap()">
    <div id="map" style="height: 500px; width: 100%;"></div>
</body>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&libraries=places"></script>
    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let deliveryPoints = [
            {lat: 28.6139, lng: 76.2090, label: '1', delivered: true, info: "Delivered Parcel 1"},
            {lat: 28.7041, lng: 77.1025, label: '2', delivered: false, info: "Pending Parcel 2"},
            {lat: 28.5355, lng: 77.3910, label: '3', delivered: false, info: "Pending Parcel 3"},
            {lat: 28.4595, lng: 77.0266, label: '4', delivered: true, info: "Delivered Parcel 4"},
            {lat: 28.4089, lng: 77.3178, label: '5', delivered: false, info: "Pending Parcel 5"}
        ];
        let driverRoute = [
            {lat: 28.7041, lng: 77.1025}, // Middle point
            {lat: 28.5355, lng: 77.3910}  // Current driver location
        ];
        let driverLocation = driverRoute[driverRoute.length - 1]; // Last point in driverRoute is current location
        let startPoint = {lat: 28.6139, lng: 77.2090}; // Start point (red)
        let endPoint = {lat: 26.9124, lng: 75.7873}; // End point (green)

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: startPoint,
                zoom: 7
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                polylineOptions: {
                    strokeColor: 'black'
                }
            });

            calculateAndDisplayRoute();
            addMarkers();
        }

        function calculateAndDisplayRoute() {
            let waypoints = [];
            if (deliveryPoints.length > 0) {
                waypoints = deliveryPoints.map(point => ({
                    location: new google.maps.LatLng(point.lat, point.lng),
                    stopover: true
                }));
            }

            directionsService.route({
                origin: startPoint,
                destination: endPoint,
                waypoints: waypoints,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.DRIVING
            }, (response, status) => {
                if (status === 'OK') {
                    let route = response.routes[0];
                    if (deliveryPoints.length > 0) {
                        renderPaths(route);
                    } else {
                        directionsRenderer.setDirections(response);
                    }
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

        function renderPaths(route) {
            let greenPath = [];
            let blackPath = [];
            let reachedCurrentLocation = false;

            route.legs.forEach(leg => {
                leg.steps.forEach(step => {
                    step.path.forEach(point => {
                        if (!reachedCurrentLocation) {
                            greenPath.push(point);
                            if (Math.abs(point.lat() - driverLocation.lat) < 0.0001 && Math.abs(point.lng() - driverLocation.lng) < 0.0001) {
                                reachedCurrentLocation = true;
                            }
                        } else {
                            blackPath.push(point);
                        }
                    });
                });
            });

            // Draw green path up to current driver location
            new google.maps.Polyline({
                path: greenPath,
                geodesic: true,
                strokeColor: 'green',
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });

            // Draw black path from driver location to end point
            new google.maps.Polyline({
                path: blackPath,
                geodesic: true,
                strokeColor: 'black',
                strokeOpacity: 1.0,
                strokeWeight: 2,
                map: map
            });
        }

        function addMarkers() {
            // Info windows
            const infoWindow = new google.maps.InfoWindow();

            // Add start marker (red)
            const startMarker = new google.maps.Marker({
                position: startPoint,
                map: map,
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
                },
                title: 'Start Point'
            });
            startMarker.addListener('click', () => {
                infoWindow.setContent('<div><h2>Start Point</h2><p>Driver Info: Starting Point</p></div>');
                infoWindow.open(map, startMarker);
            });

            // Add end marker (green)
            const endMarker = new google.maps.Marker({
                position: endPoint,
                map: map,
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
                },
                title: 'End Point'
            });
            endMarker.addListener('click', () => {
                infoWindow.setContent('<div><h2>End Point</h2><p>Driver Info: Ending Point</p></div>');
                infoWindow.open(map, endMarker);
            });

            // Add delivery point markers
            deliveryPoints.forEach(point => {
                const marker = new google.maps.Marker({
                    position: point,
                    map: map,
                    label: point.label,
                    icon: {
                        url: point.delivered ? 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png' : 'http://maps.google.com/mapfiles/ms/icons/yellow-dot.png'
                    }
                });
                marker.addListener('click', () => {
                    infoWindow.setContent('<div><h2>Delivery Point ' + point.label + '</h2><p>' + point.info + '</p></div>');
                    infoWindow.open(map, marker);
                });
            });

            // Add driver current location marker
            const driverMarker = new google.maps.Marker({
                position: driverLocation,
                map: map,
                icon: 'http://maps.google.com/mapfiles/ms/icons/purple-dot.png', // Special marker color for driver location
                title: 'Driver Location'
            });
            driverMarker.addListener('click', () => {
                infoWindow.setContent('<div><h2>Driver Location</h2><p>Driver Info: Current Location</p></div>');
                infoWindow.open(map, driverMarker);
            });
        }
    </script>
</html>
