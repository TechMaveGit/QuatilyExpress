@extends('admin.layout')
@section('content')


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&libraries=places" defer></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&callback=initMap"></script>


<style>
    #map {
        height: 400px;
        width: 100%;
    }
    .locations_hints_options ul li {
	display: flex;
	margin-bottom: 12px;
    margin-right:10px;
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
.color_boxhint.greenhint {

    background: #ff6e6e;
}
.color_boxhint.yellowhint {
    background: #2ebeaa;
}
.color_boxhint.bluehint {
    background: #2d8ef4;
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
                     <div class="col-lg-12" style="display:flex;">

                          <div class="col-lg-12">
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
                                            <div class="color_boxhint greenhint"></div>
                                            <div class="location_status">Deliver Points</div>
                                          </li>

                                          <li>
                                            <div class="color_boxhint yellowhint"></div>
                                            <div class="location_status">Delivered Point</div>
                                          </li>

                                          <li>
                                            <div class="color_boxhint bluehint"></div>
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
        color: #000; /* Set the color to black */
        font-weight: bold;
    }
</style>


    <script>
    function initMap() {
        // Assuming you have only one map
        var locations = {!! json_encode($locations) !!};
        var lastLocation = locations[locations.length - 1];
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: parseFloat(lastLocation.lat),
                lng: parseFloat(lastLocation.lng)
            },
            zoom: 13
        });

        // Create an InfoWindow for displaying titles
        var infoWindow = new google.maps.InfoWindow();

        // Add markers for the "do mark" location (in green)
        for (var i = 0; i < locations.length; i++) {
            var marker2 = new google.maps.Marker({
                position: {
                    lat: parseFloat(locations[i].lat),
                    lng: parseFloat(locations[i].lng)
                },
                map: map,
                title: locations[i].name,
                icon: {
                    url: 'https://techmavesoftwaredev.com/express/public/assets/images/newimages/map-circle.png',
                    scaledSize: new google.maps.Size(35, 35)  // Set the width and height for resizing
                }
            });

            // Add a click event listener to each marker
            marker2.addListener('click', function ()
                    {
                        // Set the content of the InfoWindow to the marker's title with black color
                        infoWindow.setContent('<div><p class="black">Driver Name - ' + this.title + '</p>');
                        // Open the InfoWindow at the clicked marker
                        infoWindow.open(map, this);

                        // Set a specific zoom level when a marker is clicked (e.g., zoom to level 16)
                        map.setZoom(16);

                        // Optionally, you can also set the center to the clicked marker's position
                        map.setCenter(this.getPosition());
                    });
        }
    }
</script>





@endsection
