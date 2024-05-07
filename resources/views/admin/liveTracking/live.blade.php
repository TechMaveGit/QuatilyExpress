@extends('admin.layout')
@section('content')

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&libraries=places" defer></script>
<style>
    #map {
        height: 400px;
        width: 100%;
    }
    #customMap{
        height: 600px;
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
    <h1 class="page-title">Delivery Tracking</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
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
                                <form action="{{ route('live-tracking') }}" method="post"/> @csrf
                                <div class="colcls" style="display: flex;}">

                                <div class="col-lg-6">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Active Driver</label>
                                        <div class="form-group">

                                           <select class="form-control select2" name="driverName"  onchange="getShift(this)"  data-placeholder="Choose one" required>
                                            <option value="">Select Any One</option>
                                                @foreach ($driver as $alldriver)
                                                    @if($alldriver->status=='1')
                                                    <option value="{{ $alldriver->id }}" {{ $alldriver->id == $driverName ? 'selected="selected"' : '' }}>{{ $alldriver->fullName}}</option>
                                                     @endif
                                                @endforeach
                                           </select>
                                       </div>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <input type="hidden" name="shift" value="{{ $shiftName??'' }}" id="shiftData" />
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Shift</label>
                                          <div class="form-group">

                                              <select class="form-control select2 form-select" name="shiftName" id="shiftId" data-placeholder="Choose one">

                                              </select>
                                         </div>
                                    </div>
                                </div>
                                </div>
                                <div class="col-lg-4">
                                 <div class="search_btn">
                                 <button type="submit" class="btn btn-primary srch_btn">Search</button>
                                 <a href="{{ route('live-tracking') }}" class="btn btn-primary srch_btn">Reset</a>

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

              @if($driverName)
                <div class="row">
                     <div class="col-lg-12" style="display:flex;">

                          <div class="col-lg-12">
                              <div class="card">
                                @if($locations || $parcelLocation || $doMarkLocation )
                                <div id="map" style="height: 734px;"></div>
                                @else
                                 <p> Not found </p>
                                @endif
                                 {{-- <div id="map" style="height: 734px;"></div> --}}
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
                @else

                <div class="row">
                    <div class="col-lg-12" style="display:flex;">

                         <div class="col-lg-12">
                             <div class="card">

                                <div id="customMap">

                                </div>



<script>
    function initMapCustom() {
      // Check if the browser supports Geolocation
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            var mapOptions = {
              center: { lat: position.coords.latitude, lng: position.coords.longitude },
              zoom: 15
            };

            var map = new google.maps.Map(document.getElementById('customMap'), mapOptions);

            var marker = new google.maps.Marker({
              position: { lat: position.coords.latitude, lng: position.coords.longitude },
              map: map,
              title: 'Your Location'
            });
          },
          function(error) {
            console.error('Error getting current location:', error);
          }
        );
      } else {
        console.error('Geolocation is not supported by this browser.');
      }
    }

    // Explicitly load the Google Maps API with your API key
    function loadGoogleMapsScript() {
      var script = document.createElement('script');
      script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&callback=initMapCustom';
      script.onerror = function() {
        console.error('Error loading Google Maps API.');
      };
      document.head.appendChild(script);
    }

    // Check if the Google Maps API has been loaded
    if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
      loadGoogleMapsScript();
    }
  </script>

                             </div>
                         </div>



                   </div>
               </div>

                @endif
             </div>
         </div>
     </div>
</div>
</div>

<input type="hidden" name="driverName" id="driverName" value="{{ $deliver_address }}" />


<script>

    function getShift(select)
    {
        var typeId=select.value;

        var shiftData = $('#shiftData').val();

        if (shiftData) {
            selectedOption = 'selected';
        }
        else{
            selectedOption ='';
        }

        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
          $.ajax({
                type:'POST',
                url:"{{ route('get.shift') }}",
                data:{typeId:typeId},
                success:function(data){
                    if (data.success==200)
                    {
                        $('#shiftId').empty();
                            var html4='<option value="" >Choose one</option>';
                            $.each(data.vehicleData,function(index,items)
                            {
                                if (shiftData == items.id) {
                                    html4 += '<option value="' + items.id + '" selected>' + 'QE' + items.id + '</option>';
                                } else {
                                    html4 += '<option value="' + items.id + '">' + 'QE' + items.id + '</option>';
                                }                            });
                          $('#shiftId').append(html4);


                    }
                }
           });
    }
</script>


<style>
    .parcelTtl{
        color: #0c0b0b;
        font-weight: bold;
    }
    .black{
        color: #0c0b0b;
        font-weight: bold;
    }
</style>


<script>
    function initMap()
{

        var locations = <?php echo json_encode($locations); ?>;
        var deliver_ltn = $('#driverName').val();
        var lastLocation = locations[locations.length - 1];
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: parseFloat(lastLocation.lat),
                lng: parseFloat(lastLocation.lng)
            },
            zoom: 13
        });



       var redlocations = <?php echo json_encode($parcelLocation); ?>;
        var lastLocationred = locations[redlocations.length - 1];
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: parseFloat(lastLocationred.lat),
                lng: parseFloat(lastLocationred.lng)
            },
            zoom: 13
        });

        // Create an InfoWindow for displaying titles
        var infoWindow = new google.maps.InfoWindow();

        // Add markers for the "do mark" location (in green)
        for (var i = 0; i < redlocations.length; i++) {
            var marker1 = new google.maps.Marker({
                position: {
                    lat: parseFloat(redlocations[i].lat),
                    lng: parseFloat(redlocations[i].lng)
                },
                map: map,
                title: 'Parcel In - ' + redlocations[i].receiverName,
                location: 'Location - ' + redlocations[i].location,
                icon: {
                    url: 'https://techmavesoftwaredev.com/express/public/assets/flag/placeholder.png',
                    scaledSize: new google.maps.Size(25, 35)  // Set the width and height for resizing
                }
            });

        // Add a click event listener to each marker
        marker1.addListener('click', function ()
          {
            // Set the content of the InfoWindow to the marker's title with black color
            infoWindow.setContent('<div><p class="black">' + this.title + '</p><br><p class="black">' + this.location + '</p></div>');
            // Open the InfoWindow at the clicked marker
            infoWindow.open(map, this);

            // Set a specific zoom level when a marker is clicked (e.g., zoom to level 16)
            map.setZoom(16);

            // Optionally, you can also set the center to the clicked marker's position
            map.setCenter(this.getPosition());
          });

        }
/*  End */



var markers = [];
for (var i = 0; i < locations.length; i++) {
    markers.push(new google.maps.LatLng(parseFloat(locations[i].lat), parseFloat(locations[i].lng)));
}

var line = new google.maps.Polyline({
    path: markers,
    geodesic: true,
    strokeColor: '#FF0000',
    strokeOpacity: 1.0,
    strokeWeight: 4  // Increase this value to make the line bolder
});
line.setMap(map);

var lastMarker = new google.maps.Marker({
    position: markers[markers.length - 1],
    map: map,
    title: 'Driver Last Location',
    location:deliver_ltn,
    icon: {
        url: 'https://techmavesoftwaredev.com/express/public/Blue.png',
        scaledSize: new google.maps.Size(25, 35)  // Set the width and height for resizing
    }
});

// Create an InfoWindow for displaying titles
var infoWindow = new google.maps.InfoWindow();

google.maps.event.addListener(lastMarker, 'click', function () {
    // Set the content of the InfoWindow to the marker's title with black color
    infoWindow.setContent('<div><p class="black">' + lastMarker.title + '</p><br><p class="black">' + lastMarker.location + '</p></div>');
    // Open the InfoWindow at the clicked marker
    infoWindow.open(map, lastMarker);

    // Zoom to the clicked marker's position
    map.setCenter(lastMarker.getPosition());
    map.setZoom(16); // Adjust the zoom level as needed
});


    var doMarkLocation = <?php echo json_encode($doMarkLocation); ?>;
    var markers = [];

    for (var i = 0; i < doMarkLocation.length; i++) {
        var marker = new google.maps.Marker({
            position: {
                lat: parseFloat(doMarkLocation[i].lat),
                lng: parseFloat(doMarkLocation[i].lng)
            },
            map: map,
            title: 'Parcel Out - ' + doMarkLocation[i].deliveredTo,
            icon: {
                url: 'https://techmavesoftwaredev.com/express/public/Green.png',
                scaledSize: new google.maps.Size(25, 35)
            }
        });

        var infoWindow2 = new google.maps.InfoWindow({
            content: '<span class="parcelTtl">Parcel Out - ' + doMarkLocation[i].deliveredTo + '</span><br><span class="parcelTtl">Location - ' + doMarkLocation[i].deliver_address + '</span><br>'
        });

        google.maps.event.addListener(marker, 'click', (function(marker, infoWindow2) {
            return function() {
                // Open the info window when clicked
                infoWindow2.open(map, marker);

                // Zoom to the clicked marker's position
                map.setCenter(marker.getPosition());
                map.setZoom(16); // Adjust the zoom level as needed
            };
        })(marker, infoWindow2));

        markers.push(marker); // Store markers in the array
    }
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&callback=initMap"></script>


@endsection
