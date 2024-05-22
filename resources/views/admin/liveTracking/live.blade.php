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
                                        <label class="form-label" for="exampleInputEmail1">Active Driver</label>
                                        <div class="form-group">

                                           <select class="form-control select2" name="driverName"  onchange="getShift(this)"  data-placeholder="Choose one" required>
                                            <option value="">Select Any One</option>
                                                @foreach ($driver as $alldriver)
                                                    @if($alldriver->status=='1')
                                                    <option value="{{ $alldriver->id }}" {{ $alldriver->id == $driverName ? 'selected="selected"' : '' }}>{{ $alldriver->userName}} {{ $alldriver->surname}} ({{ $alldriver->email}})</option>
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
                            <span class="text-danger" id="error_msg"></span>
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
                                    html4 += '<option value="' + items.id + '" selected>' + 'QE' + items.shiftRandId + '  (' + items.shiftStartDate + ')</option>';
                                } else {
                                    html4 += '<option value="' + items.id + '">' + 'QE' + items.shiftRandId + '  (' + items.shiftStartDate + ')</option>';
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

function initMap() {
    var locations = @json($locations);

    // Initialize the map with default center and zoom
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 0, lng: 0 }, // Default center, can be changed to a more suitable default location
        zoom: 2 // Default zoom level
    });

    // Check if locations exist and set map accordingly
    if (locations && locations.length > 0) {
        var deliver_ltn = $('#driverName').val();
        var lastLocation = locations[locations.length - 1];

        map.setCenter({
            lat: parseFloat(lastLocation.lat),
            lng: parseFloat(lastLocation.lng)
        });
        map.setZoom(13);

        var redlocations = @json($parcelLocation);
        var infoWindow = new google.maps.InfoWindow();

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
                    url: 'https://www.techmavedesigns.com/development/express/public/assets/flag/placeholder.png',
                    scaledSize: new google.maps.Size(25, 35)
                }
            });

            marker1.addListener('click', function() {
                infoWindow.setContent('<div><p class="black">' + this.title + '</p><br><p class="black">' + this.location + '</p></div>');
                infoWindow.open(map, this);
                map.setZoom(16);
                map.setCenter(this.getPosition());
            });
        }

        var markers = [];
        for (var i = 0; i < locations.length; i++) {
            markers.push(new google.maps.LatLng(parseFloat(locations[i].lat), parseFloat(locations[i].lng)));
        }

        var line = new google.maps.Polyline({
            path: markers,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 4
        });
        line.setMap(map);

        var lastMarker = new google.maps.Marker({
            position: markers[markers.length - 1],
            map: map,
            title: 'Driver Last Location',
            location: deliver_ltn,
            icon: {
                url: 'https://www.techmavedesigns.com/development/express/public/Blue.png',
                scaledSize: new google.maps.Size(25, 35)
            }
        });

        google.maps.event.addListener(lastMarker, 'click', function() {
            infoWindow.setContent('<div><p class="black">' + lastMarker.title + '</p><br><p class="black">' + lastMarker.location + '</p></div>');
            infoWindow.open(map, lastMarker);
            map.setCenter(lastMarker.getPosition());
            map.setZoom(16);
        });

        var doMarkLocation = @json($doMarkLocation);
        for (var i = 0; i < doMarkLocation.length; i++) {
            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(doMarkLocation[i].lat),
                    lng: parseFloat(doMarkLocation[i].lng)
                },
                map: map,
                title: 'Parcel Out - ' + doMarkLocation[i].deliveredTo,
                icon: {
                    url: 'https://www.techmavedesigns.com/development/express/public/Green.png',
                    scaledSize: new google.maps.Size(25, 35)
                }
            });

            var infoWindow2 = new google.maps.InfoWindow({
                content: '<span class="parcelTtl">Parcel Out - ' + doMarkLocation[i].deliveredTo + '</span><br><span class="parcelTtl">Location - ' + doMarkLocation[i].deliver_address + '</span><br>'
            });

            google.maps.event.addListener(marker, 'click', (function(marker, infoWindow2) {
                return function() {
                    infoWindow2.open(map, marker);
                    map.setCenter(marker.getPosition());
                    map.setZoom(16);
                };
            })(marker, infoWindow2));
        }
    } else {
        $("#error_msg").text("Live Route Not Found");
    }
}



  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&callback=initMap"></script>
  

@endsection
