@extends('admin.layout')
@section('content')

<?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }
   ?>

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
    padding: 0px 5px;''
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

<div class="modal fade zoomIn" id="showImportForm" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content" style="padding: 20px;">

            {{-- <div class="modal-header"> --}}



<div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">


 <h2 style="margin-left: 9px; font-weight: bold; }">Select file</h2>
                        {{-- <p class="text-muted mx-4 mb-0" style="font-size: 19px;">Editable fields: Status, Fuel Levy Payable, Fuel Levy Chargeable, Fuel Levy Chargeable250, Fuel Levy Chargeable400, Extra Payable, Extra Chargeable</p> --}}

                    </div>


            {{-- </div> --}}


             <div class="import">


                <div class="">
                        <form action="{{ route('admin.shift.import') }}" method="post" enctype="multipart/form-data"> @csrf
                              <div class="flex_div">
                                            <input class="form-control" type="file" name="excel_file" accept=".xls, .xlsx" required>
                                            <input class="btn btn-green import-button" type="submit" value="Import Excel"/>
                              </div>
                        </form>
                 </div>
             </div>
        </div>

    </div>

</div>

<!--end modal -->


   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="approveAndRejected" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-body">
                    <div class="row">
                       <div class="col-lg-12">
                          <div class="approve_cnt">
                             {{-- <img src="{{ asset('assets/images/newimages/question-mark.png')}}" alt=""> --}}
                             <h3>Do you want to approve ?</h3>
                             <input type="hidden" name="shiftId" id="shiftId" />
                             {{-- <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Architecto, delectus?</p> --}}
                          </div>
                       </div>
                    </div>
                 </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <input type="hidden" name="" value="" id="AppendshiftId" />
                    <button type="button" class="btn w-sm btn-light"  onclick="approved()" >Approved</button>
                    <button type="sumit" class="btn w-sm btn-light" onclick="rejected()"  id="delete-record">Rejected</button>
                </div>
            </div>
           </form>
        </div>
    </div>
</div>
<!--end modal -->


<!-- Modal -->
 <div class="modal fade" id="shift_approve" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

    <form action="{{ route('admin.shift.shiftapprove') }}" method="post"/>@csrf
       <div class="modal-content">
          <div class="modal-body">
             <div class="row">
                <div class="col-lg-12">
                   <div class="approve_cnt">
                      <img src="{{ asset('assets/images/newimages/question-mark.png')}}" alt="">
                      <h3>Do you want to approve ?</h3>
                      <input type="hidden" name="shiftId" id="shiftId" />
                      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Architecto, delectus?</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="modal-footer">
             <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
             <button type="button" class="btn btn-info" data-bs-dismiss="modal">No</button>
          </div>
       </div>
    </form>
    </div>
 </div>

 <!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Shift Report</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.shift.add') }}">Shift</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shift Report</li>

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

                                @if(empty($statefilter))
                                @php
                                    $statefilter[]='';
                                @endphp

                                @endif


                            <form action="{{ route('admin.shift.report') }}" method="post"/> @csrf
                            <div class="row align-items-center">
                               <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">State</label>
                                        <div class="form-group">
                                        <select class="form-control select2 form-select" onchange="getdata(this)" id="stateId" name="state[]" data-placeholder="Choose one" multiple="multiple">

                                          @forelse ($state as $allstate)
                                            <option value="{{ $allstate->id }}" {{ in_array($allstate->id, $statefilter??'') ? 'selected="selected"' : '' }}>
                                                {{ $allstate->name }}
                                            </option>
                                            @empty
                                            @endforelse

                                          </select>
                                       </div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1"> Client </label>

                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="client[]" id="appendClient" onchange="getCostCenter(this)" data-placeholder="Choose one" multiple="multiple">

                                            @forelse ($client as $allclient)
                                            <option value="{{ $allclient->id }}">
                                                {{ $allclient->name }}
                                            </option>
                                            @empty
                                            @endforelse


                                            {{-- <option value="">Select</option>
                                                 @forelse ($client as $allclient)
                                                 <option value="{{ $allclient->id }}" {{ $clients == $allclient->id ? "selected" : '' }}>{{ $allclient->name }}</option>

                                            @empty

                                            @endforelse --}}

                                               </select>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1"> Status</label>
                                         <div class="form-group">
                                              <select class="form-control select2 form-select" name="status[]" data-placeholder="Choose one" multiple="multiple">
                                                    <option value="0" {{ in_array("0", $statusData) ? 'selected="selected"' : '' }}>Created</option>
                                                    <option value="1" {{ in_array("1", $statusData) ? 'selected="selected"' : '' }}>In Progress</option>
                                                    <option value="2" {{ in_array("2", $statusData) ? 'selected="selected"' : '' }}>To Be Approved</option>
                                                    <option value="3" {{ in_array("3", $statusData) ? 'selected="selected"' : '' }}>Approved</option>
                                                    <option value="4" {{ in_array("4", $statusData) ? 'selected="selected"' : '' }}>Rejected</option>
                                                    <option value="5" {{ in_array("5", $statusData) ? 'selected="selected"' : '' }}>Paid</option>
                                                </select>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Cost Center</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="costCenter[]" id="appendCostCenter" data-placeholder="Choose one" multiple="multiple">



                                             </select>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Base</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" id="appendBase" name="base[]" data-placeholder="Choose one" multiple="multiple">

                                               </select>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="exampleInputEmail1">Start Date</label>
                                        <input type="date" name="start" class="form-control" id="end-date" value="{{ $start }}" aria-describedby="emailHelp" placeholder="">
                                        <p class="first" id="firstcls11" style="display: none">Please Add Start Date</p>
                                    </div>
                                  </div>

                                  <div class="col-lg-4">
                                    <div class="mb-4">
                                        <label class="form-label" for="exampleInputEmail1">End Date</label>
                                        <input type="date" name="finish" class="form-control" id="end-date1" value="{{ $finish }}" aria-describedby="emailHelp" placeholder="">
                                        <p class="first" id="firstcls11" style="display: none">Please Add End Date</p>
                                    </div>
                                  </div>


                                <div class="col-lg-12">
                                    <div class="filter_flex">
                                           <div class="search_btn btnsflexflt_group">
                                 <button type="submit" class="btn btn-primary "><i class="fe fe-search"></i> Search</button>
                                  <a href="{{ route('admin.shift.report',['id'=>'10']) }}" class="btn btn-info "><i class="fe fe-refresh-ccw"></i> Clear Filter</a>
                                   <a class="btn btn-green" style="color: white;" id="exportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a>

                                   @if(in_array("54", $arr))
                                   <a  onclick="showImportForm()" class="btn btn-green "><i class="fa fa-file-excel-o"></i> Import Excel</a>
                                   @endif


                                 </div>

                                    </div>

                                </div>
                            </div>
                          </form>


                          <br>

                         <!--  <div class="row align-items-center">-->
                         <!--      <div class="col-lg-4">-->

                         <!-- </div>-->
                         <!--</div>-->


                        </div>

                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card brdcls">
                    <div class="card-header">
                    <div class="top_section_title">
                       <h5>All Driver Shift Report</h5>
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
                            <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">
                            <thead class="border-top">
                                <tr>
                                    <th hidden></th>
                                    <th hidden class="bg-transparent border-bottom-0">Client Id</th>
                                    <th class="bg-transparent border-bottom-0">Shift Id</th>
                                    <th class="bg-transparent border-bottom-0">Client</th>
                                    <th class="bg-transparent border-bottom-0">Cost</th>
                                    <th class="bg-transparent border-bottom-0">Driver</th>

                                    <th hidden class="bg-transparent border-bottom-0">Parcels Taken</th>
                                    <th hidden class="bg-transparent border-bottom-0">Parcels Delivered</th>
                                    <th class="bg-transparent border-bottom-0">REGO</th>
                                    <th class="bg-transparent border-bottom-0">Vehicle Type</th>
                                    <th class="bg-transparent border-bottom-0">State</th>
                                    <th  class="bg-transparent border-bottom-0">Created Date</th>
                                    <th class="bg-transparent border-bottom-0">Date Start</th>
                                    <th hidden class="bg-transparent border-bottom-0">Time Start</th>
                                    <th class="bg-transparent border-bottom-0">Date Finish</th>
                                    <th hidden class="bg-transparent border-bottom-0">Time Finish</th>
                                     {{-- <th class="bg-transparent border-bottom-0">Base</th> --}}
                                    <th class="bg-transparent border-bottom-0">Status</th>
                                    <th hidden class="bg-transparent border-bottom-0">Total Hours</th>
                                    <th hidden class="bg-transparent border-bottom-0">Hours Morning Shift</th>
                                    <th hidden class="bg-transparent border-bottom-0">Hours Night Shift</th>
                                    <th hidden class="bg-transparent border-bottom-0">Hours Weekend Shift</th>

                                    <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Day Shift</th>

                                    <th hidden class="bg-transparent border-bottom-0">Amount Payable Day Shift</th>


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


                               @foreach ($shift as $allshift)




                               <tr class="border-bottom">
                                <td hidden></td>
                                <td hidden class="td sorting_1">{{ $allshift->getClientName->id?? 0  }}</td>

                                <td class="td sorting_1">QE{{ $allshift->shiftRandId  }}</td>

                                <td class="td">{{ $allshift->getClientName->name??'N/A' }}</td>
                                @php
                                   $clientcenters=  DB::table('clientcenters')->where('id',$allshift->costCenter)->first()??'N/A';
                                   $clientbase=  DB::table('clientbases')->where('id',$allshift->base)->first();
                                   $rego=  DB::table('vehicals')->where('id',$allshift->rego)->first();
                                @endphp
                                <td class="td">{{ $clientcenters->name??'N/A'}}</td>

                                <td class="td">{{ $allshift->getDriverName->userName??'N/A' }} {{ $allshift->getDriverName->surname??'N/A' }}</td>


                                <td hidden class="td">{{ $allshift->parcelsToken??'N/A' }}</td>

                                <td hidden class="td">{{ $allshift->getFinishShift->parcelsDelivered??'N/A' }}</td>


                                <td class="td">{{ $rego->rego??'N/A' }}</td>

                                <td class="td">{{ $allshift->getVehicleType->name??'N/A' }}</td>

                                <td class="td">{{ $allshift->getStateName->name??'N/A' }}</td>








                                <td class="td">{{ date("Y/m/d H:i:s", strtotime($allshift->created_at)) }}</td>

                                @php
                                $finishshifts=DB::table('finishshifts')->where('shiftId',$allshift->id)->first()??'0';
                                @endphp
                                   @if ($allshift['shiftStartDate'])
                                   <td class="td">{{ date("Y/m/d H:i:s", strtotime($allshift['shiftStartDate'])) }}</td>
                                   @else
                                   <td class="td">N/A</td>
                                   @endif



                                   ............................................


                                <td hidden class="td">{{ $allshift->getFinishShift->startTime??'N/A' }}</td>

                                @if($finishshifts)
                                <td class="td">{{ date("Y/m/d H:i:s", strtotime($finishshifts->endDate)) }}</td>
                                @else
                                <td class="td">N/A</td>
                                @endif
                                <td hidden class="td">{{ $allshift->getFinishShift->endTime??'N/A' }}</td>
                                <td>
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
                                        $daySum = 0;
                                        $nightHours = 0;
                                        $weekendHours = 0;
                                    @endphp

                                    @if($allshift->getFinishShift)
                                        @php
                                            $daySum = floatval($allshift->getFinishShift->dayHours) ?? 0;
                                            $nightHours = floatval($allshift->getFinishShift->nightHours) ?? 0;
                                            $weekendHours = floatval($allshift->getFinishShift->weekendHours) ?? 0;
                                        @endphp
                                    @endif

                                    @php
                                            $chargeDayShift = ($allshift->getClientReportCharge->hourlyRateChargeableDays ?? 0) * ($allshift->getFinishShifts->dayHours ?? 0);
                                            $chargeNight = ($allshift->getClientReportCharge->ourlyRateChargeableNight ?? 0) * ($allshift->getFinishShifts->nightHours ?? 0);
                                        @endphp

                                <td hidden class="td sorting_1">{{ $daySum + $nightHours + $weekendHours }}</td>
                                <td hidden class="td sorting_1">{{ optional($allshift->getFinishShift)->dayHours ?? 0 }}</td>
                                <td hidden class="td sorting_1">{{ optional($allshift->getFinishShift)->nightHours ?? 0 }}</td>
                                <td hidden class="td sorting_1">{{ optional($allshift->getFinishShift)->weekendHours ?? 0 }}</td>
                                <td hidden class="td sorting_1">{{ $chargeDayShift }}</td>


                            @if ($allshift->priceOverRideStatus == '1')
                                @php
                                    $priceCompare = DB::table('personrates')->where('type', $allshift->vehicleType)->where('personId', $allshift->driverId)->first();
                                    $day = $priceCompare ? ($priceCompare->hourlyRatePayableDays ?? 0) * optional($allshift->getFinishShifts)->dayHours ?? 0 : 0;
                                @endphp
                                <td hidden class="td sorting_1">{{ $day }}</td>
                            @else
                                @php
                                    $clientCharge = $allshift->getClientCharge;
                                    $day = $clientCharge ? $clientCharge->hourlyRatePayableDay * optional($allshift->getFinishShifts)->dayHours ?? 0 : 0;
                                @endphp
                                <td hidden class="td sorting_1">{{ $day }}</td>
                            @endif

                                @if ($allshift->priceOverRideStatus == '1')
                                @php
                                    $priceCompare = DB::table('personrates')->where('type', $allshift->vehicleType)->where('personId', $allshift->driverId)->first();
                                    $night = ($priceCompare ? $priceCompare->hourlyRatePayableNight : 0) * ($allshift->getFinishShifts ? $allshift->getFinishShifts->nightHours ?? 0 : 0);
                                @endphp
                                <td hidden class="td sorting_1">{{ $night }}</td>
                            @else
                                @if($allshift->getFinishShifts && $allshift->getFinishShifts->nightHours ?? 0 != '0')
                                    @php
                                        $night = $allshift->getClientReportCharge->hourlyRatePayableNight * $allshift->getFinishShifts->nightHours;
                                    @endphp
                                @else
                                    @php
                                        $night = 0;
                                    @endphp
                                @endif
                                <td hidden class="td sorting_1">{{ $night }}</td>
                            @endif


                                <td hidden class="td sorting_1 {{ $allshift->getClientReportCharge->ourlyRateChargeableNight ?? 0 }}">{{ $chargeNight }}</td>


                                @if ($allshift->priceOverRideStatus == '1')
                                @php
                                    $priceCompare = DB::table('personrates')
                                        ->where('type', $allshift->vehicleType)
                                        ->where('personId', $allshift->driverId)
                                        ->first();

                                    $saturday = ($priceCompare ? ($priceCompare->hourlyRatePayableSaturday ?? 0) * ($allshift->getFinishShifts ? $allshift->getFinishShifts->saturdayHours : 0) : 0);
                                    $sunday = ($priceCompare ? ($priceCompare->hourlyRatepayableSunday ?? 0) * ($allshift->getFinishShifts ? $allshift->getFinishShifts->sundayHours : 0) : 0);
                                @endphp
                                 <td hidden class="td sorting_1">{{ $saturday + $sunday }}</td>
                            @else



                                @php
                                    $saturday = 0;
                                    $sunday = 0;

                                    if ($allshift->getFinishShifts && $allshift->getFinishShifts->saturdayHours != '0')
                                    {
                                        $saturday = $allshift->getClientReportCharge->hourlyRatePayableSaturday  * $allshift->getFinishShifts->saturdayHours ;
                                    }
                                    if ($allshift->getFinishShifts && $allshift->getFinishShifts->sundayHours !== null && $allshift->getFinishShifts->sundayHours != '0')
                                      {
                                        $sunday = floatval($allshift->getClientReportCharge->hourlyRatePayableSunday) * floatval($allshift->getFinishShifts->sundayHours);
                                      }

                                @endphp
                                 <td hidden class="td sorting_1">{{ $saturday + $sunday }}</td>






                                 @endif
                                 @if(!empty($allshift->getFinishShifts->saturdayHours))
                                 @php
                                     $saturday = $allshift->getClientReportCharge->hourlyRateChargeableSaturday  * $allshift->getFinishShifts->saturdayHours ;
                                 @endphp
                                 @else
                                 @php
                                     $saturday=0;
                                     @endphp
                                 @endif

                                 @if(!empty($allshift->getFinishShifts->sundayHours))
                                 @php
                                 $sunday = $allshift->getClientReportCharge->hourlyRateChargeableSunday * $allshift->getFinishShifts->sundayHours;
                                 @endphp
                                 @else
                                 @php
                                 $sunday=0;
                                 @endphp
                                 @endif


                                 <td hidden class="td sorting_1 saturday">{{ $saturday + $sunday }}</td>


                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyPayable??'0'	 }}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable??'0'}}</td>

                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable250??'0'}}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable400??'0'}}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->extraPayable??'0'}}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->extraChargeable??'0'}}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getShiftMonetizeInformation->totalChargeable??'0'}}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getFinishShift->odometerStartReading??'0'	 }}</td>
                                <td hidden class="td sorting_1">{{ $allshift->getFinishShift->odometerEndReading??'0'	 }}</td>
                                @php
                                    $payAmount=$allshift->payAmount;
                                @endphp
                               @if($allshift->finishStatus=='5' || $allshift->finishStatus=='2' || $allshift->finishStatus=='3')

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




                                 @if(in_array("53", $arr) || in_array("52", $arr) || in_array("54", $arr) || in_array("70", $arr))
                                    <td>
                                        <div class="d-flex">
                                            @if(in_array("50", $arr))
                                                <?php
                                                  if ($allshift->finishStatus=='2') { ?>
                                                   <a onclick="approveAndReject(`{{ $allshift->id }}`)" class="btn text-green btn-sm btncls" data-bs-toggle="modal"><span class="ti-check-box fs-14"></span></a>
                                                    <?php }  else { ?>
                                                     <a class="btn text-green btn-sm btncls"  data-bs-toggle="modal"><span class="ti-check-box fs-14"></span></a>
                                                    <?php } ?>

                                                    @endif

                                                @if(in_array("51", $arr))
                                                        <a class="btn text-info btn-sm btncls" href="{{ route('admin.shift.report.view', ['id' => $allshift->id]) }}"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="View"><span class="fe fe-eye fs-14"></span>
                                                        </a>
                                                            @endif


                                                        @if(in_array("52", $arr))
                                                            <a class="btn text-primary btn-sm btncls" href="{{ route('admin.shift.report.edit', ['id' => $allshift->id]) }}"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="Edit"><span
                                                                    class="fe fe-edit fs-14"></span>
                                                            </a>
                                                        @endif

                                                        @if(in_array("53", $arr))

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

                    </div>
                </div>
        </div>
     </div>
</div>
</div>


<style>
.sweet-alert button.cancel {
    background-color: #c0a611 !important;
}
</style>



<!--
<script>
    $(document).ready(function() {
      $('#example').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'colvis'
          ]
      } );
  } );
  </script> -->



<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({

            "scrollX": true, // Enable horizontal scrolling if needed
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "fixedHeader": true, // Keep the header fixed while scrolling
            "dom": 'lBfrtip', // Include buttons, column visibility, and length menu
            "buttons": [
                'colvis', // Add the column visibility button
                 'excel'
            ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Customize entries dropdown options
            "pageLength": 10 // Set default page length
        });
    });
</script>





<script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        exportToExcel('custom_table');
    });

    function exportToExcel(tableId) {
        const table = document.getElementById(tableId);
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        const filename = 'Shift-report.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>



<script>
    function approveAndReject(shiftId)
        {
            var shiftId = shiftId;
            $("#AppendshiftId").val(shiftId);
            $("#approveAndRejected").modal('show');
        }



function approved()
{
    $("#approveAndRejected").modal('hide');
   var shiftId= $("#AppendshiftId").val();
   var label="Shift";



                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.shiftapprove')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Shift!',
                                    text: 'Shift Approved Successfully',
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



    function rejected()
    {
        $("#approveAndRejected").modal('hide');
        var shiftId= $("#AppendshiftId").val();
        var label="Shift";
        swal({
                title: "Are you sure?",
                text: "Do you want to Rejected this shift !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.shiftRejected')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Shift!',
                                    text: 'Shift Rejected Successfully',
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
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }


function shiftPaid(shiftId) {
   var label="Address";
        swal({
                title: "Are you sure?",
                text: "Do you want to Paid !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.shiftPaid')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Paid!',
                                    text: 'Shift Paid Successfully',
                                    timer: 1000
                                });

                                window.setTimeout(function(){ } ,1000);
                                location.reload();


                                if(that){
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }


                                // window.setTimeout(function(){ } ,1000);
                                // location.reload();

                        },

                            error: function(data) {
                            console.log("error");
                            console.log(result);
                        }
                    });
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }
</script>



<script>



    function getdata(select)

    {

        var stateId = $("#stateId :selected").map((_, e) => e.value).get();

     $.ajaxSetup({



                headers: {



                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



                }



                });



     $.ajax({



                type:'POST',



                url:"{{ route('admin.getClient') }}",

                data:{stateId:stateId},

                success:function(data){

                    if (data.success==200) {

                           $('#appendClient').find('option:not(:first)').remove();

                            $('#appendClient')[0].options.length = 0;

                        var html2='';

                        $.each(data.items,function(index,items){

                            html2 +='<option value="">Choose one</option><option value="'+items.id+'">'+items.name+'</option>';

                            });

                            // console.log(html2);

                          $('#appendClient').append(html2);
                    }

                    if (data.success==400) {

                            $('#appendClient').find('option:not(:first)').remove();

                            $('#appendClient')[0].options.length = 0;

                            }
                }
                });
            }
</script>


<script>

    function getCostCenter(select)
    {
        //
        var clientId = $("#appendClient :selected").map((_, e) => e.value).get();

       $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
     $.ajax({
                type:'POST',
                url:"{{ route('admin.getCostCenter') }}",
                data:{clientId:clientId},
                success:function(data){
                    if (data.success==200) {

                        $('#appendCostCenter').find('option:not(:first)').remove();

                        $('#appendCostCenter')[0].options.length = 0;



                        $('#appendVehicleType').find('option:not(:first)').remove();

                        var html2='';

                        $.each(data.items,function(index,items){

                            html2 +='<option value="'+items.id+'">'+items.name+'</option>';

                            });



                          $('#appendCostCenter').append(html2);





                        var html3='';

                        $.each(data.getType,function(index,items){

                            html3 +='<option value="">Choose one</option><option value="'+items.get_client_type.id+'">'+items.get_client_type.name+'</option>';

                            });

                            $('#appendVehicleType').append(html3);



                               var html4='';

                                $.each(data.clientBase,function(index,items){

                                    html4 +='<option value="">Choose one</option><option value="'+items.id+'">'+items.base+'</option>';

                                    });

                                    $('#appendBase').append(html4);
                    }



                    if (data.success==400) {



                        $('#appendCostCenter').find('option:not(:first)').remove();

                        $('#appendCostCenter')[0].options.length = 0;



                        $('#appendVehicleType').find('option:not(:first)').remove();

                        $('#appendVehicleType')[0].options.length = 0;



                    }



                }

                });

            }

</script>
<script>
    function showImportForm()
    {
           $("#showImportForm").modal('show');
    }
</script>


@endsection
