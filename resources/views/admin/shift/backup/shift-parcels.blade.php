@extends('admin.layout')
@section('content')

<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Parcels</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Shift</li>
                <li class="breadcrumb-item active" aria-current="page">Parcel Detail</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <style>
.tableCls {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

</style>
        </style>

    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>All Parcels</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 mt-2">

                                    <table id="" class="table table-bordered text-nowrap mb-0">
                                        <thead class="border-top">

                                            <tr>
                                                <th class="th_highlight" style="width: 50%;" >Shift Start Point </th>
                                                <th class="th_highlight" style="width: 50%;" >Shift End Point</th>
                                            </tr>

                                        </thead>
                                          <tbody>
                                            <tr>
                                                <td>{{ $shiftLocation['startaddress'] }}</td>
                                                <td>{{ $shiftLocation['endaddress'] }}</td>
                                            </tr>
                                          </tbody>

                                    </table>



                                    <div class="table_box">
                                        <table id="custom_table" class="table table-bordered text-nowrap mb-0">
                                            <thead class="border-top">

                                                <tr>
                                                    <th class="th_highlight" colspan="4">Parcel In</th>
                                                    <th class="th_highlight" colspan="5">Parcel Out / Delivered</th>
                                                </tr>

                                                <tr>
                                                    <th>S. NO.</th>
                                                    <th>Receiver Name</th>
                                                    <th>Parcel Image</th>
                                                    <th>Date</th>

                                                    <th class="drop_location_lkj">Drop Location</th>
                                                    <th>Receiver Name</th>
                                                    <th>longitude/latitude</th>
                                                    <th>Delivered Image</th>
                                                    <th>Date</th>

                                                </tr>
                                            </thead>


                                            <tbody>
                                                @forelse ($parcelsDetail as $allparcelsDetail)
                                                <tr>
                                                   <td>{{ $loop->index+1}}</td>
                                                   <td>{{ $allparcelsDetail->receiverName}}</td>

                                                   <td>
                                                    <div class="magnific-img">
                                                        @if(!empty($allparcelsDetail['ParcelImage']->parcelImage))
                                                            <a target="_blank" class="image-popup-vertical-fit" href="{{ url('/assets/driver/parcel/'.$allparcelsDetail['ParcelImage']->parcelImage) }}">
                                                                <img src="{{ url('/assets/driver/parcel/'.$allparcelsDetail['ParcelImage']->parcelImage) }}" alt="" />
                                                            </a>
                                                        @endif
                                                    </div>
                                                  </td>


                                                   <td class="date">
                                                    {{ $allparcelsDetail->created_at }}
                                                   </td>
                                                   <td>

                                                    <p class="adress_ppmn">{{ $allparcelsDetail->location }}</p>

                                                   </td>
                                                   <td>
                                                    {{ $allparcelsDetail->deliveredTo }}
                                                   </td>
                                                   <td >
                                                    <p class="delivery_address"> {{ $allparcelsDetail->deliver_address }}</p>

                                                   </td>

                                                   <td>
                                                   <div class="magnific-img">
                                                    @if(!empty($allparcelsDetail->parcelphoto))
                                                    <a target="_blank" class="image-popup-vertical-fit" href="{{ url('/assets/driver/parcel/'.$allparcelsDetail->parcelphoto.'')}}">
                                                        <img src="{{ url('/assets/driver/parcel/'.$allparcelsDetail->parcelphoto.'')}}" style="margin-left: 39px;
                                                    }" alt="9.jpg" />
                                                        <!-- <i class="fa fa-search-plus" aria-hidden="true"></i> -->
                                                    </a>
                                                    @else





                                                    @endif

                                                    </div>
                                                   </td>
                                                   <td class="date">
                                                   {{ $allparcelsDetail->parcelDeliverdDate }}
                                                   </td>
                                                </tr>
                                                @empty

                                                <p style="font-size: 18px;
                                                color: red;
                                                font-weight: bold;">Please login on the app, to add parcels.</p>

                                                @endforelse
                                              </tbody>
                                              <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
 function parcelDeliver(id,shiftId)
        {
            var id = id;
            $('#id').val(id);
            $('#shiftId').val(shiftId);
            $("#parcel_deliver").modal('show');
        }
    </script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script>
   $(document).ready(function(){
$('.image-popup-vertical-fit').magnificPopup({
	type: 'image',
  mainClass: 'mfp-with-zoom',
  gallery:{
			enabled:true
		},

  zoom: {
    enabled: true,

    duration: 300, // duration of the effect, in milliseconds
    easing: 'ease-in-out', // CSS transition easing function

    opener: function(openerElement) {

      return openerElement.is('img') ? openerElement : openerElement.find('img');
  }
}

});

});
        </script>


@endsection
