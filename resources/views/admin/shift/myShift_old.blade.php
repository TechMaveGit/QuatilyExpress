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
    .relative{
        /* display: none; */
    }
    .colum_visibility_ak{
        display: none!important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #515151;
        border-bottom: 1px solid #5d5c5c;
    }
    .light-mode .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #f4f4f4;
        border-bottom: 1px solid #e3e1e1;
    }
    .testingcls{
                display: flex;
                align-items: center;
                gap: 5px;
                flex-direction: row-reverse;
            }
    .light-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary-bg-color);
        color: #70748c;
    }
     .bottom_pagination nav {
        display: flex;
        /* align-items: center; */
        justify-content: space-between;
        width: 100%;
        margin-top: 20px;
    }
    .bottom_pagination .hidden {
        display: flex;
        flex-direction: column-reverse;
        gap: 15px;
    }
    .bottom_pagination .hidden div p {
     text-align: end;
    }
        .dt-button.dropdown-item.buttons-columnVisibility.active {
      background-color: #282618; /* Replace with your desired color code */
      /* You can also add other styles as needed */
    }
    .top{
        display: none;
    }
    #custom_table_wrapper .bottom
    {
        display: none;
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

    #shiftTable_Container{
        overflow-x: unset !important;
    }

    #shiftTable_Container .row:nth-child(2) .col-sm-12 {
        overflow-x: scroll !important;
    }
    .dataTables_length label {
        display: flex;
        margin-block-end: 0.5rem;
        align-items: center;
    }
    .select2-container .select2-selection--single .select2-selection__rendered {
        display: block;
        padding: 0px 21px 5px 14px;
        overflow: hidden;
        margin: 0px 5px;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .select2-container {
        margin: 0px 5px;
    }
    .top_tb_dt {
        display: flex;
        justify-content: space-between;
        position: absolute;
        left: 14%;
        top: 20px;
        z-index: 1000;
    }
    .body_custom{
        padding-top: 0px;
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
                                            <input class="form-control" type="file" name="excel_file" accept=".csv" required>
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
                             <h3>Do you want to approve ?</h3>
                             <input type="hidden" name="shiftId" id="shiftId" />
                             <textarea id="add_reason" class="form-control" rows="4" name="reason"></textarea>
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


                            <form action="{{route('admin.shift.myshift')}}"  id="filterFormShiftData"  method="post"> @csrf
                            <div class="row align-items-center">
                               <div class="col-lg-3">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">State</label>
                                        <div class="form-group">
                                        <select  class="form-control select2 form-select" onchange="getdata(this)" id="stateId" name="state[]" data-placeholder="Choose one" multiple="multiple">

                                          @forelse ($state as $allstate)
                                            <option value="{{ $allstate->id }}" {{ in_array($allstate->id, request('state', [])) ? 'selected="selected"' : '' }}>
                                                {{ $allstate->name }}
                                            </option>
                                            @empty
                                            @endforelse
                                          </select>
                                       </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1"> Client</label>
                                        <div class="form-group">
                                            <select class="form-control select2 form-select" name="client[]" id="appendClient" onchange="getCostCenter(this)" data-placeholder="Choose one" multiple="multiple">

                                                {{-- @forelse ($client as $allclient)
                                                <option value="{{ $allclient->id }}">
                                                    <option value="{{ $allclient->id }}" {{ in_array($allstate->id, request('state', [])) ? 'selected="selected"' : '' }}>
                                                    </option>
                                                </option>
                                                @empty
                                                @endforelse --}}

                                            </select>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
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

                                <div class="col-lg-3">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Cost Center</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="costCenter[]" id="appendCostCenter" onchange="getCenterBase(this)" data-placeholder="Choose one" multiple="multiple">



                                             </select>
                                       </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Base</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" id="appendBase" name="base[]" data-placeholder="Choose one" multiple="multiple">

                                               </select>
                                       </div>
                                    </div>
                                </div>

                                <script>
                                    function getCenterBase(select)
                                    {
                                        var clientId = select.value;
                                        $.ajaxSetup({
                                                headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                                });
                                      $.ajax({
                                                type:'POST',
                                                url:"{{ route('admin.getClientBase') }}",
                                                data:{costCenterId:clientId},
                                                success:function(data){
                                                    if (data.success==200) {
                                                        $('#appendBase').empty();

                                                        $('#appendBase').find('option:not(:first)').remove();
                                                       $('#appendBase')[0].options.length = 0;

                                                            var html4='';
                                                                $.each(data.clientBase,function(index,items){
                                                                    html4 +='<option value="">Choose one</option><option value="'+items.id+'">'+items.base+'</option>';
                                                                    });
                                                                    $('#appendBase').append(html4);
                                                }
                                            }
                                            });
                                    }
                                   </script>

                                <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label class="form-label" for="exampleInputEmail1">Start Date</label>

                                        <input type="text" name="start" min="1000-01-01T00:00" max="9999-12-31T23:59" class="form-control datetime_picker" aria-describedby="emailHelp" placeholder=""/>

                                        {{-- <input type="date" name="start" class="form-control" min="1000-01-01" max="9999-12-31" value="{{ $start }}" aria-describedby="emailHelp" placeholder=""> --}}

                                        <p class="first" id="firstcls11" style="display: none">Please Add Start Date</p>
                                    </div>
                                  </div>

                                  <div class="col-lg-3">
                                    <div class="mb-4">
                                        <label class="form-label" for="exampleInputEmail1">End Date</label>

                                        <input type="text" name="finish" min="1000-01-01T00:00" max="9999-12-31T23:59" class="form-control datetime_picker" aria-describedby="emailHelp" placeholder=""/>

                                        {{-- <input type="date" name="finish" class="form-control" min="1000-01-01" max="9999-12-31" value="{{ $finish }}" aria-describedby="emailHelp" placeholder=""> --}}

                                        <p class="first" id="firstcls11" style="display: none">Please Add End Date</p>
                                    </div>
                                  </div>


                                <div class="col-lg-12">
                                    <div class="filter_flex">
                                           <div class="search_btn btnsflexflt_group">
                                                <button type="submit" class="btn btn-primary "><i class="fe fe-search"></i> Search</button>
                                                <a href="{{ route('admin.shift.report',['id'=>'10']) }}" class="btn btn-info "><i class="fe fe-refresh-ccw"></i> Clear Filter</a>
                                                <a class="btn btn-green" style="color: white;" id="customDownloadButton"> <i class="fa fa-file-excel-o"></i> Download Excel</a>

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

                    <div class="card-body body_custom">
                        <div class="top_tb_dt">
                            <div class="dropdown testingcls">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Column Visiblity
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="id" id="Checkme1" checked />
                                                <label class="form-check-label" for="Checkme1">Shift Id</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="client" id="Checkme2" checked />
                                                <label class="form-check-label" for="Checkme2">Client</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="cost" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Cost</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="driver" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Driver</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="rego" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Rego</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="vehicleType" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Vehicle Type</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="state" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">State</label>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="created_at" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Created at</label>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="start_Date" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Start Date</label>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="date_finish" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Date Finish</label>
                                            </div>
                                        </a>
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="status" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Status</label>
                                            </div>
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="totalPayable" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Total Payable</label>
                                            </div>
                                        </a>
                                    </li>


                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="traveledKm" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Traveled Km</label>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="form-check">
                                                <input class="form-check-input column-toggle" type="checkbox" value="action" id="Checkme3" checked />
                                                <label class="form-check-label" for="Checkme3">Action</label>
                                            </div>
                                        </a>
                                    </li>
                                </ul>

                                {{-- <div class="data_count_">
                                    <select name="itemsPerPage" onchange="getShiftData(this)" class="form-control">
                                        <option value="10" {{ request('countData') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="50" {{ request('countData') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('countData') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </div> --}}

                            </div>

                            {{-- <div class="search_box">
                                <!-- <label class="form-label" for="exampleInputEmail1">Search</label> -->
                                <div class="form-group">
                                    <form id="searchForm"  method="GET">
                                      <input type="text" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}" class="form-control" aria-describedby="emailHelp" placeholder="Search Here">
                                    </form>
                                </div>

                            </div> --}}

                        </div>


                        <br>


                        <div class="table_box " id="shiftTable_Container">

                          <table id="custom_table_table1" class="table  table-hover nowrap mb-0" style="margin: 0px !important;width: 100%;">
                            {{-- <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;"> --}}
                            <thead class="border-top">
                                <tr>
                                    <th class="bg-transparent border-bottom-0 column-id">Shift Id</th>
                                    <th class="bg-transparent border-bottom-0 column-client">Client</th>
                                    <th class="bg-transparent border-bottom-0 column-cost">Cost</th>
                                    <th class="bg-transparent border-bottom-0 column-driver">Driver</th>

                                    <th class="bg-transparent border-bottom-0">Parcels Taken</th>
                                    <th class="bg-transparent border-bottom-0">Parcels Delivered</th>
                                    <th class="bg-transparent border-bottom-0 column-rego">REGO</th>
                                    <th class="bg-transparent border-bottom-0 column-vehicleType">Vehicle Type</th>
                                    <th class="bg-transparent border-bottom-0 column-state">State</th>

                                    @if($driverRole =  Auth::guard('adminLogin')->user()->role_id)
                                        @if($driverRole!=33)
                                        <th  class="bg-transparent border-bottom-0 column-created_at">Created Date</th>
                                      @endif
                                    @endif




                                    <th class="bg-transparent border-bottom-0 column-start_Date">Date Start</th>
                                    <th  class="bg-transparent border-bottom-0">Time Start</th>
                                    <th class="bg-transparent border-bottom-0 column-date_finish">Date Finish</th>
                                    <th  class="bg-transparent border-bottom-0">Time Finish</th>
                                     {{-- <th class="bg-transparent border-bottom-0">Base</th> --}}
                                    <th class="bg-transparent border-bottom-0 column-status">Status</th>
                                    <th  class="bg-transparent border-bottom-0">Total Hours</th>

                                    @if($driverRole =  Auth::guard('adminLogin')->user()->role_id)
                                      @if($driverRole==33)
                                          <th  class="bg-transparent border-bottom-0">Total Hours Day Shift</th>
                                          <th  class="bg-transparent border-bottom-0">Total Hours Night Shift</th>
                                         <th  class="bg-transparent border-bottom-0">Total Hours Weekend Shift</th>
                                        @endif
                                    @endif



                                    <th  class="bg-transparent border-bottom-0">Amount Chargeable Day Shift</th>
                                    <th  class="bg-transparent border-bottom-0">Amount Payable Day Shift</th>
                                    <th  class="bg-transparent border-bottom-0">Amount Payable Night Shift</th>
                                    <th  class="bg-transparent border-bottom-0">Amount Chargeable Night Shift</th>
                                    <th  class="bg-transparent border-bottom-0">Amount Payable Weekend Shift</th>
                                    <th  class="bg-transparent border-bottom-0">Amount Chargeable Weekend Shift</th>
                                    <th  class="bg-transparent border-bottom-0">Fuel Levy Payable</th>
                                    <th  class="bg-transparent border-bottom-0">Fuel Levy Chargeable Fixed</th>
                                    <th  class="bg-transparent border-bottom-0">Fuel Levy Chargeable 250+</th>
                                    <th  class="bg-transparent border-bottom-0">Fuel Levy Chargeable 400+</th>
                                    <th  class="bg-transparent border-bottom-0">Extra Payable</th>
                                    <th  class="bg-transparent border-bottom-0">Extra Chargeable</th>

                                    <th  class="bg-transparent border-bottom-0">Total Chargeable</th>
                                    <th  class="bg-transparent border-bottom-0">Odometer Start</th>
                                    <th  class="bg-transparent border-bottom-0">Odometer End</th>

                                    <th class="bg-transparent border-bottom-0 column-totalPayable">Total Payable</th>
                                    <th class="bg-transparent border-bottom-0 column-traveledKm">Traveled KM</th>
                                     <th  class="bg-transparent border-bottom-0">Comment</th>

                                     @if(in_array("50", $arr) || in_array("51", $arr) || in_array("52", $arr) || in_array("53", $arr))

                                    <th class="bg-transparent border-bottom-0 column-action" style="width: 5%;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

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




<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<!-- Include DataTables Buttons CSS and JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>




<script>
    var table ;
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });

        var formData = new FormData($('#filterFormShiftData')[0]);
         table = $('#custom_table_table1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('admin.myAjaxshift') }}",
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                                    d.form = {};
                                    for (var pair of formData.entries()) {
                                           d.form[pair[0]] = pair[1];
                                    }
                                    }
        },


        "columns": [
                        // { "data": "S.No" },
                        // { "data": "Client Id" },
                        { "data": "Shift Id"},
                        { "data": "Client"},
                        { "data": "Cost"},
                        { "data": "Driver"},
                        { "data": "Parcels Taken"},
                        { "data": "Parcels Delivered"},
                        { "data": "REGO"},
                        { "data": "Vehicle Type"},
                        { "data": "State"},
                        { "data": "Created Date"},
                        { "data": "Date Start"},
                        { "data": "Time Start"},
                        { "data": "Date Finish"},
                        { "data": "Time Finish"},
                        { "data": "Status"},
                        { "data": "Total Hours"},
                        <?php if($driverRole == '33'): ?>
                            { "data": "Total Hours Day Shift" },
                            { "data": "Total Hours Night Shift" },
                            { "data": "Total Hours Weekend Shift" },
                        <?php endif; ?>
                        { "data": "Amount Chargeable Day Shift" },
                        { "data": "Amount Payable Day Shift" },
                        { "data": "Amount Payable Night Shift" },
                        { "data": "Amount Chargeable Night Shift" },
                        { "data": "Amount Payable Weekend Shift" },
                        { "data": "Amount Chargeable Weekend Shift" },
                        { "data": "Fuel Levy Payable" },
                        { "data": "Fuel Levy Chargeable Fixed" },
                        { "data": "Fuel Levy Chargeable 250+" },
                        { "data": "Fuel Levy Chargeable 400+" },
                        { "data": "Extra Payable" },
                        { "data": "Extra Chargeable" },
                        { "data": "Total Chargeable" },
                        { "data": "Odometer Start" },
                        { "data": "Odometer End" },
                        { "data": "Total Payable" },
                        { "data": "Traveled KM" },
                        { "data": "Comment" },
                        { "data": "Action" },
                    ],
                    columnDefs: [
                                {
                                    targets: 4, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 5, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                 {
                                    targets: 11, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                 {
                                    targets: 13, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },

                                {
                                    targets: 15, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 16, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 17, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 18, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 19, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 20, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 21, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                 {
                                    targets: 22, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 23, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 24, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 25, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 26, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },

                                {
                                    targets: 27, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 28, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 29, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 29, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 30, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                                {
                                    targets: 33, // Assuming S.No is the first column (index 0)
                                    visible: false
                                },
                            ],
                            "buttons": [
                                            {
                                                extend: 'excelHtml5',
                                                text: 'Download Excel',
                                                action: function (e, dt, button, config) {
                                                // Custom code to download Excel with only visible columns
                                                var visibleColumns = dt.columns(':visible').indexes().toArray();
                                                var hiddenColumns = dt.columns(':hidden').indexes().toArray();

                                                // Set the hidden columns to be visible temporarily for export
                                                dt.columns(hiddenColumns).visible(true);

                                                // Trigger the default Excel export
                                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);

                                                // Reset the visibility of hidden columns
                                                dt.columns(hiddenColumns).visible(false);
                                                }
                                            }
                                        ]

        });

        $('#customDownloadButton').on('click', function() {
        table.button(0).trigger();
      });

     });

     // Custom function to handle Excel export
    function customExcelExport(dataTable) {
        var exportData = [];
        var columns = dataTable.settings().init().columns;

        // Iterate over each row in the DataTable
        dataTable.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var rowData = this.data();

            // Extract only the visible columns
            var visibleData = [];
            for (var i = 0; i < columns.length; i++) {
                if (!columns[i].visible()) continue;

                visibleData.push(rowData[i]);
            }

            exportData.push(visibleData);
        });
    }

</script>






<style>

.sweet-alert button.cancel {
    background-color: #c0a611 !important;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>



    $(document).ready(function () {
        $('.column-toggle').change(function () {
            var column = $(this).val();
            var isChecked = $(this).prop('checked');
            var $columnCells = $('.column-' + column);

            if (isChecked) {
                $columnCells.show();
            } else {
                $columnCells.hide();
            }

            // Disable or enable the corresponding td elements
            $columnCells.prop('disabled', !isChecked);
        });
    });
</script>

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
                            // console.log("error");
                            // console.log(result);
                        }
                    });
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }
</script>



<script>


    function getdata(select) {
    var stateId = $("#stateId :selected").map((_, e) => e.value).get();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: "{{ route('admin.getClient') }}",
        data: { stateId: stateId },
        success: function (data) {
            if (data.success == 200) {
                $('#appendClient').find('option:not(:first)').remove();
                $('#appendClient')[0].options.length = 0;

                var html2 = '';
                var selectedClients = {!! json_encode(request('client', [])) !!};
                selectedClients = Array.isArray(selectedClients) ? selectedClients : [selectedClients];

                $.each(data.items, function (index, items) {
                    var isSelected = selectedClients.includes(items.id.toString());
                    html2 += '<option value="' + items.id + '" ' + (isSelected ? 'selected' : '') + '>' + items.name + '</option>';
                });

                $('#appendClient').append(html2);
            }

            if (data.success == 400) {
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
                        var html2 = '';
                        var costCenter =  {!! json_encode(request('costCenter', [])) !!};
                        costCenter = Array.isArray(costCenter) ? costCenter : [costCenter];
                        $.each(data.items, function (index, items) {
                            var isSelected = costCenter.includes(items.id.toString());
                            html2 += '<option value="' + items.id + '" ' + (isSelected ? 'selected' : '') + '>' + items.name + '</option>';
                        });
                        $('#appendCostCenter').append(html2);
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

<script>
    $(document).ready(function () {
        // Set data-page-size to a large number to show all rows
        $('#custom_table').data("page-size", 1000);

        // Disable pagination
        $('#custom_table').bootstrapTable('destroy').bootstrapTable({
            pagination: false,
        });
    });
</script>

@endsection
