@extends('admin.layout')
@section('content')
<style>
    #map {
        height: 600px;
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
        <h1 class="page-title">Delivery Tracking</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Delivery Tracking</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Filter</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form action="{{ route('live-tracking') }}" method="post"> @csrf
                                            <div class="colcls" style="display: flex;}">
                                                <div class="col-lg-6">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Active
                                                            Driver</label>
                                                        <div class="form-group">
                                                            <select class="form-control select2" name="driverName"
                                                                onchange="getShift(this)" data-placeholder="Choose one"
                                                                required>
                                                                <option value="">Select Any One</option>
                                                                @foreach ($driver as $alldriver)
                                                                @if ($alldriver->status == '1')
                                                                <option value="{{ $alldriver->id }}" {{ $alldriver->id
                                                                    == $driverName ? 'selected="selected"' : '' }}> {{
                                                                    $alldriver->userName }} {{ $alldriver->surname }}
                                                                    ({{ $alldriver->email }})</option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="hidden" name="shift" value="{{ $shiftId ?? '' }}"
                                                        id="shiftData" />
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Shift</label>
                                                        <div class="form-group">
                                                            <select class="form-control select2 form-select"
                                                                name="shiftName" id="shiftId"
                                                                data-placeholder="Choose one">
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="search_btn">
                                                    <button type="submit"
                                                        class="btn btn-primary srch_btn">Search</button>
                                                    <a href="{{ route('live-tracking') }}"
                                                        class="btn btn-primary srch_btn">Reset</a>
                                                    <button type="submit"
                                                        class="btn btn-info srch_btn">Refresh</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($driverName)
            <div class="row">
                <div class="col-lg-12" style="display:flex;">
                    <div class="col-lg-12">
                        <span class="text-danger" id="error_msg"></span>
                        <div class="card">
                           
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
            @else
            <div class="row">
                <div class="col-lg-12" style="display:flex;">
                    <div class="col-lg-12">
                        <div class="card">
                            <div id="map">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<input type="hidden" name="driverName" id="driverName" value="" />

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&libraries=places"></script>
<script>
    let storage_path = "{{asset(env('STORAGE_URL'))}}";
    let locations = @json($locations ?? []);
    let parcelLocation = @json($parcelLocation??[]);
    let map;
    let directionsService;
    let directionsRenderers = [];
    let deliveryPoints =  parcelLocation.length ? parcelLocation : [];
    let driverRoute = locations.length ? locations : [];
    let driverLocation = driverRoute[driverRoute.length - 1]; // Last point in driverRoute is current location
    let startPoint = @json($startpoints??[]); // Start point (red)
    let start_address = startPoint.address!=undefined ? `<p><b>Driver Address:</b> ${startPoint.address}</p>` : '';
    if(startPoint != undefined && startPoint.lat) startPoint = {lat:parseFloat(startPoint.lat),lng:parseFloat(startPoint.lng)};
    let endPoint = @json($endpoints??[]); // End point (green)
    let end_address = endPoint.address!=undefined ? `<p><b>Driver Address:</b> ${endPoint.address}</p>` : '';
    if(endPoint != undefined && endPoint.lat) endPoint = {lat:parseFloat(endPoint.lat),lng:parseFloat(endPoint.lng)};
    console.log(startPoint,endPoint);

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
            center: locations.length ? { lat: locations[0].lat, lng: locations[0].lng } : { lat: 0, lng: 0 },
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
            infoWindow.setContent(`<div class="info-window-content"><h2>Start Point</h2>${start_address}</div>`);
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
        deliveryPoints.forEach((point,ind) => {
            let delived_date = point.parcelDeliverdDate?`<p><b>Deliverd Date : ${point.parcelDeliverdDate}</b></p>`:'';
            let receiverName = point.receiverName?`<p><b>Receiver Name : ${point.receiverName}</b></p>`:'';
            let deliveredTo = point.deliveredTo?`<p><b>Received By : ${point.deliveredTo}</b></p>`:'';
            let deliver_address = point.deliver_address ?? point.location;
            let parselImage = point.parcelphoto ? `<img src="${storage_path}/${point.parcelphoto}" />`:'';
            let delivered_latitude = (point.delivered_latitude && point.delivered_latitude != "") ? point.delivered_latitude : point.lat;
            let delivered_longitude = (point.delivered_longitude && point.delivered_longitude != "") ? point.delivered_longitude : point.lng;
            let LatLong = { lat: parseFloat(delivered_latitude), lng: parseFloat(delivered_longitude) };
            const markerColor = point.status=="2" ? 'blue' : 'yellow';
            const marker = new google.maps.Marker({
                position: LatLong,
                map: map,
                icon: createSVGMarker(markerColor, ind+1),
                title: `Delivery Point ${ind+1}`
            });
            marker.addListener('click', () => {
                infoWindow.setContent(`<div class="info-window-content"><h2>Delivery Point ${ind+1}</h2><p>${deliver_address}</p>${delived_date}${receiverName}${deliveredTo}${parselImage}</div>`);
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
            infoWindow.setContent('<div class="info-window-content"><h2>Driver Location</h2><p>Driver Info: Current Location</p></div>');
            infoWindow.open(map, driverMarker);
        });
    }

    document.addEventListener("DOMContentLoaded", initMap);
</script>


<script>
    function getShift(select) {
        var typeId = select.value;
        var shiftData = $('#shiftData').val();
        if (shiftData) {
            selectedOption = 'selected';
        } else {
            selectedOption = '';
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('get.shift') }}",
            data: {
                typeId: typeId
            },
            success: function(data) {
                if (data.success == 200) {
                    $('#shiftId').empty();
                    var html4 = '<option value="" >Choose one</option>';
                    $.each(data.vehicleData, function(index, items) {
                        if (shiftData == items.id) {
                            html4 += '<option value="' + items.id + '" selected>' + 'QE' + items.shiftRandId + '  (' + items.shiftStartDate + ')</option>';
                        } else {
                            html4 += '<option value="' + items.id + '">' + 'QE' + items.shiftRandId + '  (' + items.shiftStartDate + ')</option>';
                        }
                    });
                    $('#shiftId').append(html4);
                }
            }
        });
    }
</script>
@endsection
