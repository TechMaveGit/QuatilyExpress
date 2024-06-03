@extends('admin.layout')
@section('content')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s"></script>
    <style>
        .info-window-content {
            text-align: center;
        }

        .info-window-content img {
            width: 150px;
            height: 150px;
        }

        .no-routes-message {
            text-align: center;
            font-size: 24px;
            color: red;
            margin-top: 20px;
        }
    </style>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        .locations_hints_options ul li {
            display: flex;
            margin-bottom: 12px;
            margin-right: 10px;
        }

        .locations_hints_options ul {
            display: flex;
            justify-content: end;
        }

        .color_boxhint {
            width: 22px;
            height: 22px;
            margin-right: 10px;
        }

        .color_boxhint.redhint {
            background: #f00;
        }

        .color_boxhint.greenhint {
            background: #038103;
        }

        .color_boxhint.yellowhint {
            background: #ff0;
        }

        .color_boxhint.bluehint {
            background: #00f;
        }

        .info-window-content {
            color: black;
        }
    </style>
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Live Tracking</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
                    <li class="breadcrumb-item active" aria-current="page">Live Tracking</li>
                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <div class="row">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="check_box">
                                <label class="form-label" for="exampleInputEmail1">Active Driver</label>
                                <div class="form-group">
                                    <form action="{{ route('driver.location') }}" method="post"> @csrf
                                        <select class="form-control select2" name="driverName" onchange="getShift(this)"
                                            data-placeholder="Choose one" required>
                                            <option value="">Select Any One</option>
                                            @if ($driver)
                                                @foreach ($driver as $alldriver)
                                                    @if ($alldriver->status == '1')
                                                        <option value="{{ $alldriver->id }}"
                                                            {{ $alldriver->id == $driverName ? 'selected="selected"' : '' }}>
                                                            {{ $alldriver->userName }} {{ $alldriver->surname }}
                                                            ({{ $alldriver->email }})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                        <button type="submit" class="btn btn-info">Refresh</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="display:flex;">
                            <div class="col-lg-12">
                                <div class="card">
                                    <span class="text-danger" id="error_msg" style="display: none;"></span>
                                    <div id="map" style="height: 734px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="locations_hints_options">
                                <ul>
                                    <li>
                                        <div class="color_boxhint redhint"></div>
                                        <div class="location_status">Deliver Start Points</div>
                                    </li>
                                    <li>
                                        <div class="color_boxhint bluehint"></div>
                                        <div class="location_status">Delivered Point</div>
                                    </li>
                                    <li>
                                        <div class="color_boxhint yellowhint"></div>
                                        <div class="location_status">Un-Delivered Point</div>
                                    </li>
                                    <li>
                                        <div class="color_boxhint greenhint"></div>
                                        <div class="location_status">End Location</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
        .black {
            color: #000;
            font-weight: bold;
        }
    </style>
    <script>
        var storage_path = "{{ asset(env('STORAGE_URL')) }}";
    </script>
    @if (!$driverName)
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: 0,
                        lng: 0
                    },
                    zoom: 2
                });

                // Assuming you have only one map
                var locations = @json($locations);

                if (locations && locations.length > 0) {
                    var lastLocation = locations[locations.length - 1];
                    map.setCenter({
                        lat: parseFloat(lastLocation.lat),
                        lng: parseFloat(lastLocation.lng)
                    });
                    map.setZoom(13);

                    // Create an InfoWindow for displaying titles
                    var infoWindow = new google.maps.InfoWindow();

                    // Add markers for the locations
                    locations.forEach(function(location) {
                        var marker2 = new google.maps.Marker({
                            position: {
                                lat: parseFloat(location.lat),
                                lng: parseFloat(location.lng)
                            },
                            map: map,
                            title: location.name,
                            icon: {
                                url: '{{ asset('assets/images/newimages/map-circle.png') }}',
                                scaledSize: new google.maps.Size(35,
                                    35) // Set the width and height for resizing
                            }
                        });

                        // Add a click event listener to each marker
                        marker2.addListener('click', function() {
                            var driverDetails = location; // Use the location directly
                            var contentString = `
                    <div style="text-align: center;">
                        <img src="${storage_path}/${driverDetails['driver']['profile_image']}" alt="${this.title}" style="width: 150px; height: 150px; border-radius: 50%;" />
                        <p class="black">Driver Name: ${driverDetails['driver']['fullName']}</p>
                        <p class="black">Driver Mobile No.: ${driverDetails['driver']['mobileNo']}</p>
                        <p class="black">Driver Email: ${driverDetails['driver']['email']}</p>
                        <hr>
                        <h4 class="black">Shift Details:</h4>
                        <p class="black">Shift ID: QE${driverDetails['shift']['shiftRandId']}</p>
                        <p class="black">Rego: ${driverDetails['shift']['rego']}</p>
                        <p class="black">Odometer: ${driverDetails['shift']['odometer']}</p>
                        <p class="black">Shift Start: ${driverDetails['shift']['shiftStartDate']}</p>
                        <p class="black">Start Address: ${driverDetails['shift']['startaddress']}</p>
                        <p class="black">End Address: ${driverDetails['shift']['endaddress']}</p>
                    </div>
                `;
                            infoWindow.setContent(contentString);
                            // Open the InfoWindow at the clicked marker
                            infoWindow.open(map, marker2);
                            // Set a specific zoom level when a marker is clicked (e.g., zoom to level 16)
                            map.setZoom(16);
                            // Optionally, you can also set the center to the clicked marker's position
                            map.setCenter(marker2.getPosition());
                        });
                    });
                }
            }
        </script>
    @else
        <script>
            let locations = @json($locations ?? []);
            let parcelLocation = @json($parcelLocation ?? []);
            let map;
            let directionsService;
            let directionsRenderers = [];
            let deliveryPoints = parcelLocation.length ? parcelLocation : [];
            let driverRoute = locations.length ? locations : [];
            let driverLocation = driverRoute[driverRoute.length - 1]; // Last point in driverRoute is current location
            let startPoint = @json($startpoints ?? []); // Start point (red)
            let start_address = startPoint.address != undefined ? `<p><b>Driver Address:</b> ${startPoint.address}</p>` : '';
            if (startPoint != undefined && startPoint.lat) startPoint = {
                lat: parseFloat(startPoint.lat),
                lng: parseFloat(startPoint.lng)
            };
            let endPoint = @json($endpoints ?? []); // End point (green)
            let end_address = endPoint.address != undefined ? `<p><b>Driver Address:</b> ${endPoint.address}</p>` : '';
            if (endPoint != undefined && endPoint.lat) endPoint = {
                lat: parseFloat(endPoint.lat),
                lng: parseFloat(endPoint.lng)
            };
            if (startPoint.lat && startPoint.lng && endPoint.lat && endPoint.lng && deliveryPoints.length > 0) {} else if (
                startPoint && deliveryPoints) {
                $("#error_msg").css('display', 'block');
                $("#error_msg").text("Shift tracking data not found. Please check your shift.");
            }

            function createSVGMarker(color, label) {
                const textColor = (color === 'yellow') ? 'black' : 'white'; // Set text color based on marker color
                const svgString = `
                <svg class="makersvg" width="32" height="32" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg">
                    <path d="M956.952 0c-362.4 0-657 294.6-657 656.88 0 180.6 80.28 347.88 245.4 511.56 239.76 237.96 351.6 457.68 351.6 691.56v60h120v-60c0-232.8 110.28-446.16 357.6-691.44 165.12-163.8 245.4-331.08 245.4-511.68 0-362.28-294.6-656.88-663-656.88" fill="${color}" fill-rule="evenodd"/>
                    <text x="50%" y="50%" text-anchor="middle" fill="${textColor}" font-size="700" font-weight="bold" font-family="Arial">${label}</text>
                </svg>
            `;
                return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svgString);
            }

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: locations.length ? {
                        lat: locations[0].lat,
                        lng: locations[0].lng
                    } : {
                        lat: 0,
                        lng: 0
                    },
                    zoom: locations.length ? 7 : 2
                });

                directionsService = new google.maps.DirectionsService();

                calculateAndDisplayRoutes();
                addMarkers();
            }

            function calculateAndDisplayRoutes() {
                if (deliveryPoints.length === 0) {
                    let directionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        suppressMarkers: true,
                        polylineOptions: {
                            strokeColor: 'black'
                        }
                    });
                    directionsRenderers.push(directionsRenderer);

                    directionsService.route({
                        origin: startPoint,
                        destination: endPoint,
                        travelMode: google.maps.TravelMode.DRIVING
                    }, (response, status) => {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(response);
                            renderPaths(response.routes[0]);
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
                    return;
                }

                let waypointsChunks = [];
                for (let i = 0; i < deliveryPoints.length; i += 23) {
                    waypointsChunks.push(deliveryPoints.slice(i, i + 23));
                }

                let previousEndPoint = startPoint;
                waypointsChunks.forEach((chunk, index) => {
                    let directionsRenderer = new google.maps.DirectionsRenderer({
                        map: map,
                        suppressMarkers: true,
                        polylineOptions: {
                            strokeColor: 'black'
                        }
                    });
                    directionsRenderers.push(directionsRenderer);

                    let waypoints = chunk.map(point => ({
                        location: new google.maps.LatLng(point.lat, point.lng),
                        stopover: true
                    }));

                    let request = {
                        origin: previousEndPoint,
                        destination: endPoint,
                        waypoints: waypoints,
                        optimizeWaypoints: true,
                        travelMode: google.maps.TravelMode.DRIVING
                    };

                    directionsService.route(request, (response, status) => {
                        if (status === 'OK') {
                            directionsRenderer.setDirections(response);
                            let route = response.routes[0];
                            if (index === waypointsChunks.length - 1) {
                                renderPaths(route);
                            }
                            previousEndPoint = route.legs[route.legs.length - 1].end_location;
                        } else {
                            window.alert('Directions request failed due to ' + status);
                        }
                    });
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
                                if (Math.abs(point.lat() - driverLocation.lat) < 0.0001 && Math.abs(
                                        point.lng() - driverLocation.lng) < 0.0001) {
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
                    strokeColor: 'black',
                    strokeOpacity: 1.0,
                    strokeWeight: 5,
                    map: map
                });

                // Draw black path from driver location to end point
                new google.maps.Polyline({
                    path: blackPath,
                    geodesic: true,
                    strokeColor: 'black',
                    strokeOpacity: 1.0,
                    strokeWeight: 5,
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
                    icon: createSVGMarker('red', 'S'),
                    title: 'Start Point'
                });
                startMarker.addListener('click', () => {
                    infoWindow.setContent(
                        `<div class="info-window-content"><h2>Start Point</h2>${start_address}</div>`);
                    infoWindow.open(map, startMarker);
                });

                // Add end marker (green)
                const endMarker = new google.maps.Marker({
                    position: endPoint,
                    map: map,
                    icon: createSVGMarker('green', 'E'),
                    title: 'End Point'
                });
                endMarker.addListener('click', () => {
                    infoWindow.setContent(`<div class="info-window-content"><h2>End Point</h2>${end_address}</div>`);
                    infoWindow.open(map, endMarker);
                });

                // Add delivery point markers
                deliveryPoints.forEach((point, ind) => {
                    let delived_date = point.parcelDeliverdDate ?
                        `<p><b>Deliverd Date : ${point.parcelDeliverdDate}</b></p>` : '';
                    let receiverName = point.receiverName ? `<p><b>Receiver Name : ${point.receiverName}</b></p>` : '';
                    let deliveredTo = point.deliveredTo ? `<p><b>Received By : ${point.deliveredTo}</b></p>` : '';
                    let deliver_address = point.deliver_address ?? point.location;
                    let beforeImage = '{{$beforeParcelImage}}';
                    let beforeParselImage = beforeImage ? `<p>Parcel Before Delivered : <br/><img style="width: 100px;" src="${storage_path}/${beforeImage}" /></p>`:'';
                    let parselImage = point.parcelphoto ? `<p>Parcel After Delivered : <br/><img style="width: 100px;" src="${storage_path}/${point.parcelphoto}" /></p>`:'';
                    let delivered_latitude = (point.delivered_latitude && point.delivered_latitude != "") ? point
                        .delivered_latitude : point.lat;
                    let delivered_longitude = (point.delivered_longitude && point.delivered_longitude != "") ? point
                        .delivered_longitude : point.lng;
                    let LatLong = {
                        lat: parseFloat(delivered_latitude),
                        lng: parseFloat(delivered_longitude)
                    };
                    const markerColor = point.status == "2" ? 'blue' : 'yellow';
                    const marker = new google.maps.Marker({
                        position: LatLong,
                        map: map,
                        icon: createSVGMarker(markerColor, ind + 1),
                        title: `Delivery Point ${ind+1}`
                    });
                    marker.addListener('click', () => {
                        infoWindow.setContent(
                            `<div class="info-window-content"><h2>Delivery Point ${ind+1}</h2><p>${deliver_address}</p>${delived_date}${receiverName}${deliveredTo}${beforeParselImage}${parselImage}</div>`
                        );
                        infoWindow.open(map, marker);
                    });
                });

                // Add driver current location marker
                const driverMarker = new google.maps.Marker({
                    position: driverLocation,
                    map: map,
                    icon: createSVGMarker('purple', 'D'),
                    title: 'Driver Location'
                });
                driverMarker.addListener('click', () => {
                    infoWindow.setContent(
                        '<div class="info-window-content"><h2>Driver Location</h2><p>Driver Info: Current Location</p></div>'
                    );
                    infoWindow.open(map, driverMarker);
                });
            }

            document.addEventListener("DOMContentLoaded", initMap);
        </script>
    @endif
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&callback=initMap"></script>
@endsection
