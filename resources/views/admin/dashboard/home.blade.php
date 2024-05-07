@extends('admin.layout')
@section('content')


<script src="https://code.iconify.design/iconify-icon/2.0.0/iconify-icon.min.js"></script>

<style>
    .removeGraph{
        display: none;
    }
    iconify-icon{
        font-size: 15px;
     }
</style>


<style>
    .dt-buttons{
        margin-left: -158px;
    }
    .dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fff;
}

<style>
    .dt-button.dropdown-item.buttons-columnVisibility.active {
  background-color: #282618; /* Replace with your desired color code */
  /* You can also add other styles as needed */
}

.brdcls .select2-selection__rendered{
    border-color: red;
    height: 40px;
    line-height: 20px;
    border: 1px solid #ccc;
    padding: 0px 5px;
    border-radius: 4px;
}


    .status-ToBeApr{
    color: #2ecc71;
    background-color: #2ecc7114;
    padding: 3px 10px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 12px;
}
    .dt-buttons{
        margin-left: -158px;
    }
    .btncls {
	padding-left: 4px !important;
	padding-right: 4px !important;
	margin: 0px !important;
	min-width: 0px !important;
	margin-right: 4px !important;
}
.flex_div {
    display: flex;
    width: 100%;
}
.filter_flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.flex_div .btn-green {
    padding-right: 35px;
    margin-left: 10px;
}

    </style>

<style>
    .table td {
    padding: 4px 8px;
}
    .flex-wrap{
         margin-left: -127px;
         margin-top: 20px;
    }
    /* data table customoization */

  .tabltoparea #export-button-container button{
    margin-right: 5px;
  }
  div.dataTables_wrapper {
    overflow-x: scroll;
  }
  .entries_pagination{
    display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  }
  .tabltoparea {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
</style>




   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="startShift" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-lg-12">
                          <div class="approve_cnt">
                             <h3>Do you want to start shift</h3>
                             <input type="hidden" name="shiftId" id="shiftId" />
                             {{-- <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Architecto, delectus?</p> --}}
                          </div>
                       </div>
                    </div>
                 </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <input type="hidden" name="startShift" value="" id="AppendshiftId" />
                    <button type="button" class="btn w-sm btn-light"  onclick="yesstartShift()">Yes</button>
                    <button type="sumit" class="btn w-sm btn-light"   id="delete-record">No</button>
                </div>
            </div>
           </form>
        </div>
    </div>
</div>
<!--end modal -->

<script>
function yesstartShift()
{
   var shiftId= $("#AppendshiftId").val();
   var label="Shift";
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.start')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Shift!',
                                    text: 'Shift Start Successfully',
                                    timer: 1000
                                });

                                 window.setTimeout(function(){ } ,1000);
                                location.reload();

                                if(that){
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }

                        },
                            error: function(data) {
                        }
                    });
    }
</script>




   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="finishShift" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <div class="card-body">

                    <div id="wizard1s">

                        <section>

                            <form action="{{ route('admin.finish.Shift') }}" method="post" enctype="multipart/form-data">@csrf
                                    <div class="row">

                                        <div class="col-lg-12">

                                            <div class="title_head">
                                                <h4>Finish Shift</h4>
                                              </div>

                                            <label class="form-label" for="exampleInputEmail1">Odometer Start Reading  <span class="red">*</span></label>

                                            <input type="number" name="odometerStartReading" id="odometer_start_reading" min="0" class="form-control" aria-describedby="emailHelp" placeholder="" fdprocessedid="enssm" required="">
                                            <input type="hidden" name="shiftId" value="" id="appendFinishShiftiId" />

                                    </div>
                                    <div class="col-lg-12">
                                            <label class="form-label" for="exampleInputEmail1">Odometer End Reading  <span class="red">*</span></label>


                                            <input type="text" min="0" class="form-control" name="odometerEndReading" value="" id="odometer_finish_reading" aria-describedby="emailHelp" placeholder="" onkeypress="checkOdometerReading(event)" required="" fdprocessedid="kgw02c">

                                            <div id="message"></div>


                                    </div>



                                    <script>
                                        function checkOdometerReading(event) {

                                            var startReading = parseFloat(document.getElementById('odometer_start_reading').value) || 0;
                                            var finishReading = parseFloat(document.getElementById('odometer_finish_reading').value + event.key) || 0;
                                            var addButton = document.querySelector('.btn.btn-primary');

                                            const key = event.key;
                                            if (/^[a-zA-Z]$/.test(key))
                                            {
                                            event.preventDefault();
                                            }

                                            var messageElement = document.getElementById('message');
                                            if (finishReading <= startReading) {
                                                messageElement.textContent = 'End Odometer End Reading must be greater than Start Reading.';
                                                messageElement.style.color = 'red';
                                                addButton.style.display = 'none';

                                            } else {
                                                messageElement.textContent = '';
                                                addButton.style.display = '';

                                            }
                                        }


                                    </script>


                                        <div class="col-lg-6">
                                            <label class="form-label" for="exampleInputEmail1">Start Date <span class="red">*</span></label>
                                            <input type="text" name="startDate" class="form-control"  id="start-date" aria-describedby="emailHelp" data-input=""  fdprocessedid="q627ek" disabled>
                                        </div>


                                        <div class="col-lg-6">
                                            <label class="form-label" for="exampleInputEmail1">End date <span class="red">*</span></label>


                                            <input type="datetime-local" id="endTm" name="endDate" min="1000-01-01" max="9999-12-31" class="form-control flatpickr-input" required="">



                                        </div>

                            <div class="col-lg-6">

                                <div class="mb-3">

                                    <label class="form-label" for="exampleInputEmail1">Parcels Taken  <span class="red">*</span></label>

                                    <input type="text" class="form-control" name="parcelsToken"  id="ParcelsTaken" min="0" aria-describedby="emailHelp" placeholder=""  fdprocessedid="63uoa3" readonly>

                                </div>

                            </div>



                            <div class="col-lg-6">

                                <div class="mb-3">

                                    <label class="form-label" for="exampleInputEmail1">Parcels Delivered <span class="red">*</span></label>

                                    <input type="text" class="form-control" value="" name="parcel_delivered" onkeypress="parcelDelivered(event)" id="parcel_delivered" min="0"  placeholder="" required="">
                                    <div id="message_"></div>
                                </div>

                            </div>

                            <script>
                                function parcelDelivered(event)
                                       {
                                           var ParcelsTaken = parseFloat(document.getElementById('ParcelsTaken').value) || 0;
                                           var parcelDelivered = parseFloat(document.getElementById('parcel_delivered').value + event.key) || 0;
                                           var addButton = document.querySelector('.btn.btn-primary');

                                           const key = event.key;
                                           if (/^[a-zA-Z]$/.test(key))
                                           {
                                           event.preventDefault();
                                           }

                                           var messageElement = document.getElementById('message_');
                                           if (parcelDelivered > ParcelsTaken) {
                                               messageElement.textContent = 'The parcel delivered must be less than or equal to parcels taken ';
                                               messageElement.style.color = 'red';
                                               addButton.style.display = 'none';

                                           } else {
                                               messageElement.textContent = '';
                                               addButton.style.display = '';

                                           }
                                       }
                                </script>


                            <div class="col-lg-12">

                                <div class="mb-6">

                                    <label class="form-label" for="exampleInputEmail1">Image <span class="red">*</span></label>

                                    <input type="file" class="form-control" name="addPhoto" aria-describedby="emailHelp" required>

                                </div>

                            </div>
                                    </div>


                            <div class="bottom_footer_dt">

                                <div class="row">

                                    <div class="col-lg-12">

                                        <div class="action_btns text-end">

                                            <button type="submit" value="Submit" class="btn btn-primary" fdprocessedid="cxhrte"><i class="bi bi-save"></i> Finish Shift</button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </form>



                        </section>









                    </div>

                </div>










            </div>
           </form>
        </div>
    </div>
</div>
<!--end modal -->


<script>
    // Get the current date and time
    var now = new Date();

    // Format the current date and time to be compatible with the datetime-local input
    var formattedNow = now.toISOString().slice(0, 16);

    // Set the min attribute of the input to the formatted current date and time
    document.getElementById('endTm').min = formattedNow;

</script>


<script>
    var endDateInput = document.getElementById('endTm');

    // Add click event listener to the text
    endDateInput.addEventListener('click', function() {
      // Trigger a click event on the input field
      endDateInput.click();
    });

    // Prevent keypresses to disable manual input
    endDateInput.addEventListener('keydown', function(event) {
      event.preventDefault();
    });
  </script>

<script>
    var endDateInput = document.getElementById('first11');

    // Add click event listener to the text
    endDateInput.addEventListener('click', function() {
      // Trigger a click event on the input field
      endDateInput.click();
    });

    // Prevent keypresses to disable manual input
    endDateInput.addEventListener('keydown', function(event) {
      event.preventDefault();
    });
  </script>

<script>
    var endDateInput = document.getElementById('first12');

    // Add click event listener to the text
    endDateInput.addEventListener('click', function() {
      // Trigger a click event on the input field
      endDateInput.click();
    });

    // Prevent keypresses to disable manual input
    endDateInput.addEventListener('keydown', function(event) {
      event.preventDefault();
    });
  </script>






<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Master Dashboard</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
                {{-- <li class="breadcrumb-item active" aria-current="page">Master Dashboard</li> --}}

            </ol>
        </div>
    </div>

    <?php
    $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
    $role_id=Auth::guard('adminLogin')->user()->role_id;
    $roleName= DB::table('roles')->where('id',$role_id)->first()->name??'';
    $arr = [];
    foreach($D as $v)
    {
      $arr[] = $v['permission_id'];
    }

    // echo "<pre>";
    // print_r($arr);

    // die;
    ?>


 @if(!in_array("70", $arr))

    <!-- PAGE-HEADER END -->
    <div class="side-app">
      <!-- CONTAINER -->
      <div class="main-container container-fluid">
        <div class="page-header">
            <h1 class="page-title">{{ $roleName }} Dashboard</h1>
            <div>
                <ol class="breadcrumb" style="margin-right: 57px">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
                    <li class="breadcrumb-item active" aria-current="page">{{ $roleName }} Dashboard</li>

                </ol>
            </div>
        </div>


        @if(in_array("76", $arr))
              <section class="top_cards_jlpk">
                 <div class="row">
                   <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard1">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ round($driverPay,2) }}</h2>
                                    <p class="text-white mb-0">Total Fleet Payable </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard2">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ round($clientPay,2) }}</h2>
                                    <p class="text-white mb-0">Total Fleet Charge </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard3">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ round($clientPay-$driverPay,2) }}</h2>
                                    <p class="text-white mb-0">Total Earning</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard4">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ round($expenseReport,2) }}</h2>
                                    <p class="text-white mb-0"> General Expenses</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard5">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ round($tollexpense,2) }}</h2>
                                    <p class="text-white mb-0">Total Fleet Toll </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard6">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ round($operactionExp,2) }}</h2>
                                    <p class="text-white mb-0">Operation Expenses</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard7">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ $totalClient }}</h2>
                                    <p class="text-white mb-0">Total Client</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard8">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ $totalVehicle }}</h2>
                                    <p class="text-white mb-0">Total Vehicle</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard9">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ $totalDriver }}</h2>
                                    <p class="text-white mb-0">Total Driver</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-2">
                    <div class="card bg-primary img-card box-primary-shadow dashcard10">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font">{{ $totalShift }}</h2>
                                    <p class="text-white mb-0">Total Shift</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @endif
                    @if(in_array("78", $arr) || in_array("77", $arr))

                                <div class="col-lg-12 text-end mb-3">
                                    <a href="#" class="btn bg_green_adfl advanced_filter_btn "><i class="bi-bar-chart"></i> Advance Filters</a>
                                </div>

                     @endif

                <div class="col-lg-12 mb-5 advanced_filters">
                        <div class="card">
                            <div class="card-header card_h">
                                    <div class="top_section_title">
                                        <h5>Filter</h5>
                                    </div>
                                </div>
                            <div class="card-body pb-0">

                                <form action="{{ route('admin.dashboard') }}" method="post"/> @csrf
                                <div class="row align-items-center">
                                        <div class="col-lg-4">
                                        <div class="check_box">
                                            <label class="form-label" for="exampleInputEmail1">Year</label>
                                            <div class="form-group">

                                            <select class="form-control select2 form-select" name="getYear">
                                                    <option value="">Select Any One</option>
                                                    <option value="2020" {{ $yearName == 2020 ? 'selected="selected"' : '' }}>2020</option>
                                                    <option value="2021" {{ $yearName == 2021 ? 'selected="selected"' : '' }}>2021</option>
                                                    <option value="2022" {{ $yearName == 2022 ? 'selected="selected"' : '' }}>2022</option>
                                                    <option value="2023" {{ $yearName == 2023 ? 'selected="selected"' : '' }}>2023</option>
                                                    <option value="2024" {{ $yearName == 2024 ? 'selected="selected"' : '' }}>2024</option>
                                                </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="check_box">
                                            <label class="form-label" for="exampleInputEmail1">Driver Responsible</label>
                                            <div class="form-group">
                                                <select class="form-control select2 form-select" name="driverResponsible">
                                                    <option value="">Select Any One</option>
                                                    @forelse ($driverFilter as $alldriverFilter)
                                                       <option value="{{ $alldriverFilter->id }}" {{ $driverResponsible == $alldriverFilter->id ? 'selected="selected"' : '' }}>{{ $alldriverFilter->userName }} - {{ $alldriverFilter->email }}</option>
                                                    @empty

                                                    @endforelse


                                                </select>
                                        </div>
                                        </div>
                                    </div>
{{-- @dd($vehicleRego) --}}
                                    <div class="col-lg-4">
                                        <div class="check_box">
                                            <label class="form-label" for="exampleInputEmail1">REGO </label>
                                            <div class="form-group">

                                            <select class="form-control select2 form-select" name="vehicleRego">
                                                    <option value="">Select Any One</option>
                                                    @forelse ($totalRego as $alltotalRego)
                                                    <option value="{{ $alltotalRego->rego }}" {{ $alltotalRego->rego == $vehicleRego ? 'selected="selected"' : '' }}>{{ $alltotalRego->rego }}</option>
                                                    @empty

                                                    @endforelse

                                                </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-4 text-end">
                                     <div class="search_btn">
                                     <button type="submit" class="btn btn-primary srch_btn">Search</button>
                                     <a href="{{ route('admin.dashboard') }}" class="btn btn-danger srch_btn">Reset</a>

                                     </div>
                                    </div>

                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
            </div>
        </section>







    <section class="big_number_data_lnkl">
        <div class="card show_portfolio_tab">
                    <div class="card-header">
                        <ul class="nav nav-tabs">
                            @if(in_array("77", $arr))
                            <li class="nav-item">
                                <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <span><i class="ti-car"></i></span>
                                    <span>All Fleet Details</span>
                                </a>
                            </li>
                            @endif

                            @if(in_array("78", $arr))
                            <li class="nav-item">
                                <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                    <span><i class="ti-bar-chart-alt"></i></span>
                                    <span> Total Cost Chart</span>
                                </a>
                            </li>
                            @endif
      <!--
                            <li class="nav-item">
                                <a href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    <span><i class="ti-clipboard"></i></span>
                                    <span>Monetize Information</span>
                                </a>
                            </li> -->


                        </ul>
                    </div>
                    <div class="card-body">


                        <div class="tab-content  text-muted">
                            @if(in_array("77", $arr))

                            <div class="tab-pane show active" id="home">

                            <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                    <div class="table_main_kjp table_design_">

                                        <table id="custom_table" class="table   table-hover mb-0" style="margin: 0px !important;width: 100%;">


                                            <thead class="border-top">
                                    <tr>

                                        <th class="bg-transparent border-bottom-0">REGO</th>
                                        <th class="bg-transparent border-bottom-0">Total Fleet Charge</th>
                                        <th class="bg-transparent border-bottom-0">Total Fleet Payable</th>
                                        <th class="bg-transparent border-bottom-0">Total Fleet Toll</th>
                                        <th class="bg-transparent border-bottom-0">General Expenses</th>
                                        <th class="bg-transparent border-bottom-0">Operation Expense</th>
                                        {{-- <th class="bg-transparent border-bottom-0">Total Rental Charge</th> --}}

                                    </tr>
                                </thead>
                                <tbody>



                                    @forelse ($allRego as $allRego)
                                    <tr class="border-bottom">
                                        <td class="td sorting_1">{{ $allRego->rego }}</td>

                                           @if(isset($allRego->getShiftRego))
                                               @if(isset($allRego->getShiftRego->getClientNm))
                                                <td class="td">{{ round($allRego->getShiftRego->getClientNm->adminCharge?? 0 ,2)  }}</td>
                                                @else
                                                <td class="td">0</td>
                                                @endif
                                            @else
                                            <td class="td">0</td>
                                            @endif

                                               @if(isset($allRego->getShiftRego))
                                                   @if(isset($allRego->getShiftRego->getClientNm))
                                                    <td class="td">{{ round($allRego->getShiftRego->getClientNm->driverPay?? 0 ,2) }}</td>
                                                    @else
                                                    <td class="td">0</td>
                                                    @endif
                                                @else
                                               <td class="td">0</td>
                                               @endif

                                            @php
                                             $trip_cost = DB::table('tollexpenses')->where('rego',$allRego->id)->sum('trip_cost')??'0';
                                             $cost = DB::table('expenses')->where('rego',$allRego->id)->sum('cost')??'0';
                                             $operaction_exps = DB::table('operaction_exps')->where('rego',$allRego->id)->sum('cost')??'0';
                                            @endphp
                                            <td class="td">{{ round($trip_cost?? 0 ,2) }}</td>

                                            {{-- <td class="td">{{ $trip_cost??'0' }}</td> --}}



                                        <td class="td">{{ round($cost ?? 0 ,2) }}</td>

                                        <td class="td">{{ round($operaction_exps ?? 0 ,2) }}</td>
                                    </tr>
                                    @empty

                                    @endforelse


                                    {{-- <tr class="border-bottom">
                                        <td class="td sorting_1">122GL8</td>
                                        <td class="td">12310.13</td>
                                        <td class="td">4318.06</td>
                                        <td class="td">620</td>
                                        <td class="td">30569.60</td>
                                    </tr> --}}


                                </tbody>
                            </table>
                        </div>
                                    </div>


                                </div>
                                <!-- main_bx_dt -->
                            </div>
                            @endif
                            @if(in_array("78", $arr))

                            <div class="tab-pane" id="profile">
                               <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                        <div class="row">
                                            <div class="fourthGraph">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Profit & Loss / by shift</h3>
                                                            <br>
                                                        <br>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="chart-container">
                                                                <canvas id="chartBar1" class="h-275"></canvas>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="fourthGraph">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Profit & Loss ( Over all expense )</h3>
                                                            <br>
                                                        <br>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="chart-container">
                                                                <canvas id="chartBar2" class="h-275"></canvas>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="firstGraph">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Expenses & Profit / Monthly Graph</h3>
                                                        <br>
                                                            <br>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="chart-container">
                                                                <canvas id="chartLine" class="h-275"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <br>

                                            <div class="fourthGraph">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Chargeable & Payable / Client Monthly Graph</h3>
                                                            <br>
                                                        <br>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="chart-container">
                                                                <canvas id="chartBar3" class="h-275"></canvas>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>






                                        </div>
                                    </div>
                                </div>
                                <!-- main_bx_dt -->


                            </div>
                            @endif

                            <!-- <div class="tab-pane email_template" id="messages">


                        </div> -->
                    </div>
                </div>
            </div>
        </section>
      </div>
    </div>

    <script>
        $(document).ready(function() {
                $('.tab-pane:first').addClass('show active');
                });
        </script>

    @else


    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
          <div class="page-header">
              <h1 class="page-title">{{ $roleName }} Dashboard</h1>
              <div>
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="https://techmavesoftwaredev.com/express/admin/dashboard">Dashboard</a></li>
                      <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
                      <li class="breadcrumb-item active" aria-current="page">Master Dashboard</li>

                  </ol>
              </div>
          </div>

                <section class="top_cards_jlpk">
                   <div class="row">
                     <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                      <div class="card bg-primary img-card box-primary-shadow">
                          <div class="card-body">
                              <div class="d-flex">
                                  <div class="text-white">
                                      <h2 class="mb-0 number-font">{{ $monthlyShift }}</h2>
                                      <p class="text-white mb-0">Monthly Shift</p>
                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                      <div class="card bg-primary img-card box-primary-shadow">
                          <div class="card-body">
                              <div class="d-flex">
                                  <div class="text-white">
                                      <h2 class="mb-0 number-font">{{ $totalReceivedAmount }}</h2>
                                      <p class="text-white mb-0">Total Received Amount</p>
                                  </div>

                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                      <div class="card bg-primary img-card box-primary-shadow">
                          <div class="card-body">
                              <div class="d-flex">
                                  <div class="text-white">
                                      <h2 class="mb-0 number-font">{{ round($allSub,2) }}</h2>
                                      <p class="text-white mb-0">Total Hour</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>


                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                      <div class="card bg-primary img-card box-primary-shadow">
                          <div class="card-body">
                              <div class="d-flex">
                                  <div class="text-white">
                                      <h2 class="mb-0 number-font">{{ $payShift }}</h2>
                                      <p class="text-white mb-0">Paid Shift</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <div class="card bg-primary img-card box-primary-shadow">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font" style="font-size: 18px;">{{ Auth::guard('adminLogin')->user()->created_at }}</h2>
                                    <p class="text-white mb-0">Onboard Date</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
      </div>


      <div class="col-lg-12">
        <div class="card brdcls">
        <div class="card-header">
        <div class="top_section_title">
           <h5>All Driver Report</h5>
           <!-- <a href="person-add.php" class="btn btn-primary">+ Add New Person</a> -->
        </div>

        <div class="search_btn m-0">
            @if(in_array("48", $arr))
               <a href="{{ route('admin.shift.add') }}" class="btn btn-primary srch_btn">+ Add New Shift</a>
            @endif
         </div>

         <div class="search_btn m-2">
            @if(in_array("49", $arr))
            <a href="{{ route('admin.shift.missed.shift') }}" class="btn btn-primary srch_btn">+ Add New Missed Shift</a>
            @endif
         </div>
    </div>




      <div class="card-body">
        <div class="table_box" is="shiftTable_Container">
          <table id="custom_table" class="table  table-hover mb-0" style="margin: 0px !important;width: 100%;">
            <thead class="border-top">
                <tr>
                    <th hidden>S.No</th>
                    <th class="bg-transparent border-bottom-0">Id</th>
                    <th class="bg-transparent border-bottom-0">Client</th>
                    <th class="bg-transparent border-bottom-0">Cost</th>
                    <th class="bg-transparent border-bottom-0">Driver</th>

                    <th hidden class="bg-transparent border-bottom-0">Parcels Taken</th>
                    <th hidden class="bg-transparent border-bottom-0">Parcels Delivered</th>
                    <th class="bg-transparent border-bottom-0">REGO</th>
                    <th class="bg-transparent border-bottom-0">Vehicle Type</th>
                    <th class="bg-transparent border-bottom-0">State</th>


                    @if($driverRole =  Auth::guard('adminLogin')->user()->role_id)
                      @if($driverRole!=33)
                       <th  class="bg-transparent border-bottom-0">Created Date</th>
                      @endif
                    @endif

                    <th class="bg-transparent border-bottom-0">Date Start</th>
                    <th hidden class="bg-transparent border-bottom-0">Time Start</th>
                    {{-- <th class="bg-transparent border-bottom-0">Date Finish</th> --}}
                     <th class="bg-transparent border-bottom-0">Base</th>

                    <th hidden class="bg-transparent border-bottom-0">Time Finish</th>

                    <th class="bg-transparent border-bottom-0">Status</th>


                    <th hidden class="bg-transparent border-bottom-0">Total Hours</th>

                    @if($driverRole =  Auth::guard('adminLogin')->user()->role_id)
                    @if($driverRole==33)
                        <th  class="bg-transparent border-bottom-0">Total Hours Day Shift</th>
                        <th  class="bg-transparent border-bottom-0">Total Hours Night Shift</th>
                       <th  class="bg-transparent border-bottom-0">Total Hours Weekend Shift</th>
                      @endif
                  @endif


                    <th hidden class="bg-transparent border-bottom-0">Amount Payable Day Shift</th>


                    <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Day Shift</th>
                    <th hidden class="bg-transparent border-bottom-0">Amount Payable Night Shift</th>
                    <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Night Shift</th>

                    <th hidden class="bg-transparent border-bottom-0">Amount Payable Weekend Shift</th>
                    <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Weekend Shift</th>


                    <th hidden class="bg-transparent border-bottom-0">Fuel Levy Payable</th>
                    <th hidden class="bg-transparent border-bottom-0">Fuel Levy Chargeable Fixed</th>
                    <th hidden class="bg-transparent border-bottom-0">Fuel Levy Chargeable 250+</th>
                    <th hidden class="bg-transparent border-bottom-0">Fuel Levy Chargeable 400+</th>
                    <th hidden class="bg-transparent border-bottom-0">Extra Payable</th>
                    <th hidden class="bg-transparent border-bottom-0">Extra Chargeable</th>

                    <th hidden class="bg-transparent border-bottom-0">Total Chargeable</th>
                    <th hidden class="bg-transparent border-bottom-0">Odometer Start</th>
                    <th hidden class="bg-transparent border-bottom-0">Odometer End</th>

                    <th class="bg-transparent border-bottom-0">Total Payable</th>
                    <th class="bg-transparent border-bottom-0">Traveled KM</th>
                     <th hidden class="bg-transparent border-bottom-0">Comment</th>


                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                </tr>
            </thead>
            <tbody>


               @foreach ($shift as $key=>$allshift)

               <tr class="border-bottom">

                <td hidden>{{ $key+1 }}</td>

                <td class="td sorting_1">QE{{ $allshift->shiftRandId  }}</td>

                <td class="td">{{ $allshift->getClientName->name??'N/A' }}</td>
                @php
                   $clientcenters=  DB::table('clientcenters')->where('id',$allshift->costCenter)->first()??'N/A';
                   $clientbase=  DB::table('clientbases')->where('id',$allshift->base)->first();
                   $rego=  DB::table('vehicals')->where('id',$allshift->rego)->first();
                @endphp
                <td class="td">{{ $clientcenters->name??'N/A'}}</td>

                <td class="td">{{ $allshift->getDriverName->userName??'N/A' }}</td>


                <td hidden class="td">{{ $allshift->parcelsToken??'N/A' }}</td>

                <td hidden class="td">{{ $allshift->getFinishShift->parcelsDelivered??'N/A' }}</td>


                <td class="td">{{ $rego->rego??'N/A' }}</td>

                <td class="td">{{ $allshift->getVehicleType->name??'N/A' }}</td>

                <td class="td">{{ $allshift->getStateName->name??'N/A' }}</td>

                @if($driverRole =  Auth::guard('adminLogin')->user()->role_id)
                @if($driverRole!=33)
                <td class="td">{{ date("Y/m/d H:i:s", strtotime($allshift['created_at'])) }} </td>
                @endif
              @endif



                @php
                $finishshifts=DB::table('finishshifts')->where('shiftId',$allshift->id)->first()??'0';
                @endphp
               @if($allshift['shiftStartDate'])
                <td class="td">{{ date("Y/m/d H:i:s", strtotime($allshift['shiftStartDate'])) }}</td>
                @else
                <td class="td">N/A</td>
                @endif


                  <td hidden class="td">{{ $allshift->getFinishShift->startTime??'N/A' }}</td>


                   <td hidden class="td">{{ $allshift->getFinishShift->endTime??'N/A' }}</td>

                  <td class="td">{{ $clientbase->base??'N/A' }}</td>


                <td>

<!--                                 <div class="dropdown">-->
<!--  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--    Dropdown button-->
<!--  </button>-->
<!--  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
<!--    <a class="dropdown-item" href="#">Action</a>-->
<!--    <a class="dropdown-item" href="#">Another action</a>-->
<!--    <a class="dropdown-item" href="#">Something else here</a>-->
<!--  </div>-->
<!--</div>-->

                    <?php
                    $driverRole =  Auth::guard('adminLogin')->user();
                    $driverRole = $driverRole->role_id;
                    if ($allshift->finishStatus=='0') { ?>
                    <span class="light status-Created">Created</span>
                    <?php } elseif($allshift->finishStatus=='1'){ ?>
                    <span class="danger status-InProgress">In Progress</span>
                    <?php  } elseif($allshift->finishStatus=='2') { ?>
                    <span class="light status-ToBeApproved" <?php if($driverRole!==33){ ?> onclick="approveAndReject(`{{ $allshift->id }}`)" <?php } ?>>To Be Approved</span>
                    <?php } elseif ($allshift->finishStatus=='3') { ?>
                        <span class="light status-ToBeApr" <?php if($driverRole!==33){ ?> onclick="shiftPaid(`{{ $allshift->id }}`)" <?php } ?>>Approved</span>
                    <?php  } elseif ($allshift->finishStatus=='4') { ?>
                        <span class="light status-ToBeApr">Rejected</span>
                    <?php } elseif ($allshift->finishStatus=='5' || $allshift->finishStatus=='6')  { ?>
                        <span class="light status-Paid" >Paid</span>
                    <?php } else { ?>
                        <?php } ?>

                </td>


                 @php
                    $daySum=0;
                    $nightHours=0;
                  @endphp

                @if($allshift->getFinishShift)
                   @php
                      $daySum=$allshift->getFinishShift->dayHours;
                      $nightHours=$allshift->getFinishShift->nightHours;
                    @endphp
                @endif


                <td hidden class="td sorting_1">{{ $daySum??'0' + $nightHours??'0' }}</td>

                @if($driverRole =  Auth::guard('adminLogin')->user()->role_id)
                    @if($driverRole==33)
                    <td  class="td sorting_1">{{ optional($allshift->getFinishShift)->dayHours ?? 0 }}</td>
                    <td  class="td sorting_1">{{ optional($allshift->getFinishShift)->nightHours ?? 0 }}</td>
                    <td  class="td sorting_1">{{ optional($allshift->getFinishShift)->weekendHours ?? 0 }}</td>
                    {{-- For Driver --}}
                    @endif
                @endif

                <td hidden class="td sorting_1">{{ $allshift->payAmount??'0' }}</td>

                <td hidden class="td sorting_1">{{ $allshift->getClientRate->hourlyRateChargeableDays??'0' }}</td>
                <td hidden class="td sorting_1">{{ $allshift->getClientRate->hourlyRatePayableDay??'0' }}</td>
                {{-- <td hidden class="td sorting_1">{{ $allshift->getClientRate->hourlyRateChargeableNight??'0' }}</td> --}}


            @php
                $hourlyRatePayableSaturday=0;
                $hourlyRatePayableSunday=0;
                $hourlyRateChargeableSaturday=0;
                $hourlyRateChargeableSunday=0;
              @endphp

            @if($allshift->getClientRate)
               @php
                  $hourlyRatePayableSaturday = $allshift->getClientRate->hourlyRatePayableSaturday;
                  $hourlyRatePayableSunday = $allshift->getClientRate->hourlyRatePayableSunday;
                  $hourlyRateChargeableSaturday = $allshift->getClientRate->hourlyRateChargeableSaturday;
                  $hourlyRateChargeableSunday = $allshift->getClientRate->hourlyRateChargeableSunday;
                @endphp
            @endif

                <td hidden class="td sorting_1">{{ $hourlyRatePayableSaturday??'0' + $hourlyRatePayableSunday??'0' }}</td>
                <td hidden class="td sorting_1">{{ $hourlyRateChargeableSaturday??'0' + $hourlyRateChargeableSunday??'0' }}</td>

                <td hidden class="td sorting_1">{{ $allshift->chageAmount??'0' }}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyPayable??'0'	 }}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable250??'0'}}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable250??'0'}}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable40??'0'}}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->extraPayable??'0'}}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->extraChargeabl??'0'}}</td>
                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->totalChargeable??'0'}}</td>
                <td hidden class="td sorting_1">{{ $allshift->getFinishShift->odometerStartReading??'0'	 }}</td>
                <td hidden class="td sorting_1">{{ $allshift->getFinishShift->odometerEndReading??'0'	 }}</td>


                @php
                    $payAmount=$allshift->payAmount;
                @endphp
               @if($allshift->finishStatus=='5' || $allshift->finishStatus=='2')

                {{-- <td class="td">{{ $allshift->getShiftMonetizeInformation->totalPayable??'0' + $payAmount??'0'}} </td> --}}
                <td class="td">{{ round($payAmount, 2)}} </td>

                @else
                <td class="td">0</td>

                @endif
                {{-- // Add pay --}}

                   @php
                      $km = ($allshift->getFinishShift->odometerEndReading  ?? 0) - ($allshift->getFinishShift->odometerStartReading ?? 0);
                    @endphp

                <td class="td"><span id="span_status_31240">{{ $km }}</span>
                </td>

                 <td hidden class="td"><span id="span_status_31240">{{ $allshift->getFinishShift->comments??'N/A' }}</span>
                </td>

                @php
                    $carbonDateTime = \Carbon\Carbon::parse($allshift->shiftStartDate);
                    $formattedDate = $carbonDateTime->format('d/m/Y');
                    $formattedTime = $carbonDateTime->format('h:i A');
               @endphp


                 @if(in_array("53", $arr) || in_array("52", $arr) || in_array("54", $arr) || in_array("70", $arr))
                    <td>
                        <div class="d-flex">

                            @if($allshift->finishStatus=='1')
                            <a  onclick="finishShift(`{{ $allshift->id }}`,`{{ $allshift->odometer }}`,`{{ $allshift->parcelsToken }}`,`{{ $formattedDate }} {{ $formattedTime }}`)" class="btn text-primary btn-sm btncls"
                                data-bs-toggle="tooltip"
                                data-bs-original-title="Finish Shift"><iconify-icon class="finishshift_icon" icon="mdi:stopwatch-start-outline"></iconify-icon>
                            </a>
                            @endif


                                @if($allshift->finishStatus=='0')
                                <a onclick="startShift(`{{ $allshift->id }}`)" class="btn text-primary btn-sm btncls"
                                    data-bs-toggle="tooltip"
                                    data-bs-original-title="Start Shift"><iconify-icon icon="icon-park-outline:check-one"></iconify-icon>
                                </a>
                                @endif






                                   @if(in_array("52", $arr))
                                        <a class="btn text-info btn-sm btncls" href="{{ route('admin.shift.report.view', ['id' => $allshift->id]) }}"
                                                    data-bs-toggle="tooltip" data-bs-original-title="View"><span class="fe fe-eye fs-14"></span>
                                        </a>
                                            @endif


                                        @if(in_array("53", $arr))
                                            <a class="btn text-primary btn-sm btncls" href="{{ route('admin.shift.report.edit', ['id' => $allshift->id]) }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit"><span
                                                    class="fe fe-edit fs-14"></span>
                                            </a>
                                        @endif

                                        @if(in_array("51", $arr))

                                        <a class="btn text-primary btn-sm btncls" href="{{ route('admin.shift.parcels'  , ['id' => $allshift->id] )}}"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Parcel"><span
                                                class="fe fe-box"></span>
                                        </a>


                                        {{-- <a href="{{ route('admin.shift.parcels'  , ['id' => $allshift->id] )}}" class="btn btn-parcel" ><i class="fe fe-box"></i></a> --}}
                                        @endif
                            </div>
                </td>
                @endif
     </tr>

                @endforeach



            </tbody>
        </table>
         <!-- Custom div for lengthMenu, search bar, and buttons -->

    </div>
        </div>

    @endif
    </div>





<?php
if($yearName || $driverResponsible || $vehicleRego)
{    ?>
    <script>
       $('.advanced_filters').show();
     </script>

<?php } else { ?>
    <script>
          console.log("else");
        $(document).ready(function(){
             $('.advanced_filters').hide();
            $('.advanced_filter_btn').click(function(){
            $('.advanced_filters').toggle();
            });
        })
     </script>

    <?php } ?>




<script>
var ctx = document.getElementById("chartBar1");
var data=$('#driverList').val();

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: "Client Charagable",
            data: [{{$firstGraphClientCharge[0]}}, {{$firstGraphClientCharge[1]}}, {{$firstGraphClientCharge[2]}}, {{$firstGraphClientCharge[3]}}, {{$firstGraphClientCharge[4]}}, {{$firstGraphClientCharge[5]}}, {{$firstGraphClientCharge[6]}} , {{$firstGraphClientCharge[7]}}, {{$firstGraphClientCharge[8]}}, {{$firstGraphClientCharge[9]}}, {{$firstGraphClientCharge[10]}}, {{$firstGraphClientCharge[11]}}],
            borderColor: "#6c5ffc",
            borderWidth: "0",
            backgroundColor: "#f4c32b"
        }, {
            label: "Payable Driver",
            data: [{{$firstGraphdriverPay3[0]}}, {{$firstGraphdriverPay3[1]}}, {{$firstGraphdriverPay3[2]}}, {{$firstGraphdriverPay3[3]}}, {{$firstGraphdriverPay3[4]}}, {{$firstGraphdriverPay3[5]}}, {{$firstGraphdriverPay3[6]}} , {{$firstGraphdriverPay3[7]}}, {{$firstGraphdriverPay3[8]}}, {{$firstGraphdriverPay3[9]}}, {{$firstGraphdriverPay3[10]}}, {{$firstGraphdriverPay3[11]}}],
            borderColor: "#05c3fb",
            borderWidth: "0",
            backgroundColor: "#05c3fb"
        },{
            label: "Profit",
            data: [{{$firstGraphClientCharge[0]-$firstGraphdriverPay3[0]}}, {{$firstGraphClientCharge[1]-$firstGraphdriverPay3[1]}}, {{$firstGraphClientCharge[2]-$firstGraphdriverPay3[2]}}, {{$firstGraphClientCharge[3]-$firstGraphdriverPay3[3]}}, {{$firstGraphClientCharge[4]-$firstGraphdriverPay3[4]}}, {{$firstGraphClientCharge[5]-$firstGraphdriverPay3[5]}}, {{$firstGraphClientCharge[6]-$firstGraphdriverPay3[6]}} , {{$firstGraphClientCharge[7]-$firstGraphdriverPay3[7]}}, {{$firstGraphClientCharge[8]-$firstGraphdriverPay3[8]}}, {{$firstGraphClientCharge[9]-$firstGraphdriverPay3[9]}}, {{$firstGraphClientCharge[10]-$firstGraphdriverPay3[10]}}, {{$firstGraphClientCharge[11]-$firstGraphdriverPay3[11]}}],
            borderColor: "#44c644",
            borderWidth: "0",
            backgroundColor: "#44c644"
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                barPercentage: 0.4,
                barValueSpacing: 0,
                barDatasetSpacing: 0,
                barRadius: 0,
                ticks: {
                    color: "#79818b",
                },
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                }
            },
            y: {
                ticks: {
                    beginAtZero: true,
                    color: "#79818b",
                },
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                },
            }
        },
        legend: {
            labels: {
                color: "#79818b"
            },
        },
    }
});











var ctx = document.getElementById("chartBar2");
var data=$('#driverList').val();

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: "[Overall + Expense + Driver Payable",
            data: [{{ $secondGraphOverAllExpense[0] }}, {{ $secondGraphOverAllExpense[1] }}, {{ $secondGraphOverAllExpense[2] }}, {{ $secondGraphOverAllExpense[3] }}, {{ $secondGraphOverAllExpense[4] }}, {{ $secondGraphOverAllExpense[5] }}, {{ $secondGraphOverAllExpense[6] }},{{ $secondGraphOverAllExpense[7] }},{{ $secondGraphOverAllExpense[8] }},{{ $secondGraphOverAllExpense[9] }},{{ $secondGraphOverAllExpense[10] }},{{ $secondGraphOverAllExpense[11] }}],
            borderColor: "#6c5ffc",
            borderWidth: "0",
            backgroundColor: "#f4c32b"
        }, {
            label: "Client Charge",
            data: [{{ $clientCharge[0] }}, {{ $clientCharge[1] }}, {{ $clientCharge[2] }}, {{ $clientCharge[3] }}, {{ $clientCharge[4] }}, {{ $clientCharge[5] }}, {{ $clientCharge[6] }},{{ $clientCharge[7] }},{{ $clientCharge[8] }},{{ $clientCharge[9] }},{{ $clientCharge[10] }},{{ $clientCharge[11] }}],
            borderColor: "#05c3fb",
            borderWidth: "0",
            backgroundColor: "#05c3fb"
        },{
            label: "Profit $ Loss",
            data: [{{ $secondClientrate[0] }}, {{ $secondClientrate[1] }}, {{ $secondClientrate[2] }}, {{ $secondClientrate[3] }}, {{ $secondClientrate[4] }}, {{ $secondClientrate[5] }}, {{ $secondClientrate[6] }},{{ $secondClientrate[7] }},{{ $secondClientrate[8] }},{{ $secondClientrate[9] }},{{ $secondClientrate[10] }},{{ $secondClientrate[11] }}],
            borderColor: "#44c644",
            borderWidth: "0",
            backgroundColor: "#44c644"
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                barPercentage: 0.4,
                barValueSpacing: 0,
                barDatasetSpacing: 0,
                barRadius: 0,
                ticks: {
                    color: "#79818b",
                },
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                }
            },
            y: {
                ticks: {
                    beginAtZero: true,
                    color: "#79818b",
                },
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                },
            }
        },
        legend: {
            labels: {
                color: "#79818b"
            },
        },
    }
});






    /*LIne-Chart */
var ctx = document.getElementById("chartLine").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

        datasets: [{
            label: 'Admin Charage Amount',
            data: [{{$Clientrate[0]}}, {{$Clientrate[1]}}, {{$Clientrate[2]}}, {{$Clientrate[3]}}, {{$Clientrate[4]}}, {{$Clientrate[5]}}, {{$Clientrate[6]}} , {{$Clientrate[7]}}, {{$Clientrate[8]}}, {{$Clientrate[9]}}, {{$Clientrate[10]}}, {{$Clientrate[11]}}],
            borderWidth: 2,
            backgroundColor: 'transparent',
            borderColor: '#f4c32b',
            borderWidth: 3,
            lineTension:0.3,
            pointBackgroundColor: '#ffffff',
            pointRadius: 2
        }, {
            label: 'Overall Expenses',
            data: [{{ $totalsum[0] }}, {{ $totalsum[1] }}, {{ $totalsum[2] }}, {{ $totalsum[3] }}, {{ $totalsum[4] }}, {{ $totalsum[5] }}, {{ $totalsum[6] }},{{ $totalsum[7] }},{{ $totalsum[8] }},{{ $totalsum[9] }},{{ $totalsum[10] }},{{ $totalsum[11] }}],
            borderWidth: 2,
            backgroundColor: 'transparent',
            borderColor: '#05c3fb',
            borderWidth: 3,
            lineTension:0.3,
            pointBackgroundColor: '#ffffff',
            pointRadius: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
            x: {
                ticks: {
                    color: "#79818b",
                },
                display: true,
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                }
            },
            y: {
                ticks: {
                    color: "#79818b",
                },
                display: true,
                grid: {
                    color: 'rgba(119, 119, 142, 0.2)'
                },
                scaleLabel: {
                    display: false,
                    labelString: 'Thousands',
                    fontColor: 'rgba(119, 119, 142, 0.2)'
                }
            }
        },
        legend: {
            labels: {
                fontColor: "#79818b"
            },
        },
    }
});

</script>








<script>
    /* Bar-Chart2*/
    var ctx = document.getElementById("chartBar3");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @php print_r(json_encode($clientName1)); @endphp,
            datasets: [{
                label: "Admin Charge",
                data: @php print_r(json_encode($adminCharge2)); @endphp,
                borderColor: "#6c5ffc",
                borderWidth: "0",
                backgroundColor: "#f4c32b"
            }, {
                label: "Driver Pay",
                data: @php print_r(json_encode($driverPay3)); @endphp,
                borderColor: "#05c3fb",
                borderWidth: "0",
                backgroundColor: "#05c3fb"
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    barPercentage: 0.4,
                    barValueSpacing: 0,
                    barDatasetSpacing: 0,
                    barRadius: 0,
                    ticks: {
                        color: "#79818b",
                    },
                    grid: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    }
                },
                y: {
                    ticks: {
                        beginAtZero: true,
                        color: "#79818b",
                    },
                    grid: {
                        color: 'rgba(119, 119, 142, 0.2)'
                    },
                }
            },
            legend: {
                labels: {
                    color: "#79818b"
                },
            },
        }
    });
</script>




<script>


        function finishShift(shiftId,obometer,parcelsToken,formattedDate,formattedTime)
        {
            $("#appendFinishShiftiId").val(shiftId);
            $("#odometer_start_reading").val(obometer);
            $("#ParcelsTaken").val(parcelsToken);
            $("#start-date").val(formattedDate);
            $("#start-time").val(formattedTime);
            $("#finishShift").modal('show');
        }

        function startShift(shiftId)
        {
            var shiftId = shiftId;
            $("#AppendshiftId").val(shiftId);
            $("#startShift").modal('show');
        }

</script>





@endsection



