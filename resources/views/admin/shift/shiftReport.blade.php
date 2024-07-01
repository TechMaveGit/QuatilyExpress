@extends('admin.layout')
@section('content')
    <?php
    $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()), true);
    $arr = [];
    foreach ($D as $v) {
        $arr[] = $v['permission_id'];
    }
    $driverRole = Auth::guard('adminLogin')->user()->role_id;
    ?>
    <style>
        .relative {
            /* display: none; */
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #515151;
            border-bottom: 1px solid #5d5c5c;
        }
        .light-mode .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #f4f4f4;
            border-bottom: 1px solid #e3e1e1;
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
            background-color: #282618;
            /* Replace with your desired color code */
            /* You can also add other styles as needed */
        }
        .top {
            display: none;
        }
        #custom_table_wrapper .bottom {
            display: none;
        }
        .brdcls .select2-selection__rendered {
            border-color: red;
            height: 40px;
            line-height: 20px;
            border: 1px solid #ccc;
            padding: 0px 5px;
            ''
            border-radius: 4px;
        }
        .status-ToBeApr {
            color: #2ecc71;
            background-color: #2ecc7114;
            padding: 3px 10px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 12px;
        }
        .dt-buttons {
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
        .text-parcel{
            color: #05c3fb !important;
        }
    </style>
    <style>
        .table td {
            padding: 4px 8px;
        }
        .flex-wrap {
            margin-left: -127px;
            margin-top: 20px;
        }
        /* data table customoization */
        .tabltoparea #export-button-container button {
            margin-right: 5px;
        }
        div.dataTables_wrapper {
            overflow-x: scroll;
        }
        .entries_pagination {
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
                    <p class="text-muted m-4 mb-0" style="font-size: 13px;">Editable fields: Status, Fuel Levy Payable, Fuel Levy Chargeable, Fuel Levy Chargeable250, Fuel Levy Chargeable400, Extra Payable, Extra Chargeable</p>
                </div>
                {{-- </div> --}}
                <div class="import">
                    <div class="">
                        <form action="{{ route('admin.shift.import') }}" method="post" enctype="multipart/form-data"> @csrf
                            <div class="flex_div">
                                <input class="form-control" type="file" name="shift_file" accept=".csv" required>
                                <input class="btn btn-green import-button" type="submit" value="Import Excel" />
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
                                    <hr>
                                    <textarea id="add_reason" class="form-control" placeholder="Enter reason here ..." rows="2" name="reason"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <input type="hidden" name="" value="" id="AppendshiftId" />
                        <button type="button" class="btn w-sm btn-light" onclick="approved()">Approved</button>
                        <button type="sumit" class="btn w-sm btn-light" onclick="rejected()"
                            id="delete-record">Rejected</button>
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
            <form action="{{ route('admin.shift.shiftapprove') }}" method="post" >@csrf
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="approve_cnt">
                                <img src="{{ asset('assets/images/newimages/question-mark.png') }}" alt="">
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
                                @if (empty($statefilter))
                                    @php
                                        $statefilter[] = '';
                                    @endphp
                                @endif
                                <form method="GET">
                                    <div class="row align-items-center">
                                        {{-- <div class="col-lg-3">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Search</label>
                                        <div class="form-group">
                                            <input  type="text" name="search" value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                                            class="form-control" aria-describedby="emailHelp" placeholder="shift Id" fdprocessedid="enssm">
                                       </div>
                                    </div>
                                </div> --}}
                                        <div class="col-lg-3">
                                            <div class="check_box">
                                                <label class="form-label">State</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select"
                                                        onchange="getdata(this)" id="stateId" name="state[]"
                                                        data-placeholder="Choose one" multiple="multiple">
                                                        @forelse ($state as $allstate)
                                                            <option value="{{ $allstate->id }}"
                                                                {{ in_array($allstate->id, request('state', [])) ? 'selected="selected"' : '' }}>
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
                                                <label class="form-label"> Client</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select" name="client[]"
                                                        id="appendClient" onchange="getCostCenter(this)"
                                                        data-placeholder="Choose one" multiple="multiple">
                                                        @forelse ($client as $allclient)
                                                            <option value="{{ $allclient->id }}">
                                                                {{ $allclient->name }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="check_box">
                                                <label class="form-label"> Status</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select" name="status[]"
                                                        multiple="multiple">
                                                        {{-- <option value="0" {{ in_array("0", $statusData) ? 'selected="selected"' : '' }}>Created</option> --}}
                                                        <option value="1"
                                                            {{ in_array('1', $statusData) ? 'selected="selected"' : '' }}>
                                                            In Progress</option>
                                                        <option value="2"
                                                            {{ in_array('2', $statusData) ? 'selected="selected"' : '' }}>
                                                            To Be Approved</option>
                                                        <option value="3"
                                                            {{ in_array('3', $statusData) ? 'selected="selected"' : '' }}>
                                                            Approved</option>
                                                        <option value="4"
                                                            {{ in_array('4', $statusData) ? 'selected="selected"' : '' }}>
                                                            Rejected</option>
                                                        <option value="5"
                                                            {{ in_array('5', $statusData) ? 'selected="selected"' : '' }}>
                                                            Paid</option>
                                                        <option value="6"
                                                            {{ in_array('6', $statusData) ? 'selected="selected"' : '' }}>
                                                            Already Paid</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="check_box">
                                                <label class="form-label">Cost Center</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select" name="costCenter[]"
                                                        id="appendCostCenter" data-placeholder="Choose one"
                                                        multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="check_box">
                                                <label class="form-label">Base</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select" id="appendBase"
                                                        name="base[]" multiple="multiple">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-4">
                                                <label class="form-label">Start Date</label>
                                                <input type="text" name="start" min="1000-01-01" max="9999-12-31"
                                                    class="form-control onlydatenew" aria-describedby="emailHelp"
                                                    placeholder="" value="{{ request('start') }}" />
                                                {{-- <input type="date" name="start" class="form-control" min="1000-01-01" max="9999-12-31" value="{{ $start }}" aria-describedby="emailHelp" placeholder=""> --}}
                                                <p class="first" id="firstcls11" style="display: none">Please Add Start
                                                    Date</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-4">
                                                <label class="form-label" for="exampleInputEmail1">End Date</label>
                                                <input type="text" name="finish" min="1000-01-01" max="9999-12-31"
                                                    class="form-control onlydatenew" aria-describedby="emailHelp"
                                                    placeholder="" value="{{ request('finish') }}" />
                                                {{-- <input type="date" name="finish" class="form-control" min="1000-01-01" max="9999-12-31" value="{{ $finish }}" aria-describedby="emailHelp" placeholder=""> --}}
                                                <p class="first" id="firstcls11" style="display: none">Please Add End
                                                    Date</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="filter_flex">
                                                <div class="search_btn btnsflexflt_group">
                                                    <button type="submit" class="btn btn-primary "><i
                                                            class="fe fe-search"></i> Search</button>
                                                    <a href="{{ route('admin.shift.report') }}" class="btn btn-info "><i
                                                            class="fe fe-refresh-ccw"></i> Clear
                                                        Filter</a>
                                                    @if (in_array('54', $arr))
                                                        <a onclick="showImportForm()" class="btn btn-green "><i
                                                                class="fa fa-file-excel-o"></i> Import Csv</a>
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
                                <div class="flexMobile">
                                <div class="top_section_title">
                                    <h5>All Driver Shift Report</h5>
                                </div>
                                <div class="ActionBtn scrollBtn">
                                <div class="search_btn m-0">
                                    @if (in_array('48', $arr))
                                        <a href="{{ route('admin.shift.add') }}" class="btn btn-primary srch_btn">+ Add
                                            New Shift</a>
                                    @endif
                                </div>
                                <div class="search_btn m-2">
                                    @if (in_array('49', $arr))
                                        <a href="{{ route('admin.shift.missed.shift') }}"
                                            class="btn btn-primary srch_btn">+ Add New Missed Shift</a>
                                    @endif
                                </div>
                                <button class="btn btn-green" style="color: white; margin: 4px;"
                                    onclick="window.location='{{ route('export.shifts', request()->input()) }}'">
                                    <i class="fa fa-file-excel-o"></i> Download Data
                                </button>
                                </div>
                                </div>
                                
                               
                            </div>
                            <div class="card-body">
                                <div class="top_tb_dt">
                                    <div class="dropdown testingcls">
                                        <button class="btn btn-primary dropdown-toggle visibilityBtnhui" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            Column Visiblity
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="id" id="Checkme1" checked />
                                                        <label class="form-check-label" for="Checkme1">Shift Id</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="client" id="Checkme2" checked />
                                                        <label class="form-check-label" for="Checkme2">Client</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="cost" id="Checkme3" checked />
                                                        <label class="form-check-label" for="Checkme3">Cost</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="driver" id="Checkme4" checked />
                                                        <label class="form-check-label" for="Checkme4">Driver</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="rego" id="Checkme5" checked />
                                                        <label class="form-check-label" for="Checkme5">Rego</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="vehicleType" id="Checkme6" checked />
                                                        <label class="form-check-label" for="Checkme6">Vehicle
                                                            Type</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="state" id="Checkme7" checked />
                                                        <label class="form-check-label" for="Checkme7">State</label>
                                                    </div>
                                                </a>
                                            </li>
                                            @if ($driverRole != 33)
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="mobile_data_start" id="Checkme8"  />
                                                        <label class="form-check-label" for="Checkme8">Mobile Date Start</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="mobile_data_finish" id="Checkme9"  />
                                                        <label class="form-check-label" for="Checkme9">Mobile Date Finish</label>
                                                    </div>
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="start_Date" id="Checkme10" checked />
                                                        <label class="form-check-label" for="Checkme10">Date Start</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="date_finish" id="Checkme11" checked />
                                                        <label class="form-check-label" for="Checkme11">Date Finish</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="status" id="Checkme3" checked />
                                                        <label class="form-check-label" for="Checkme3">Status</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="totalPayable" id="Checkme3" checked />
                                                        <label class="form-check-label" for="Checkme3">Total
                                                            Payable</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="traveledKm" id="Checkme3" checked />
                                                        <label class="form-check-label" for="Checkme3">Traveled Km</label>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <div class="form-check">
                                                        <input class="form-check-input column-toggle" type="checkbox"
                                                            value="action" id="Checkme3" checked />
                                                        <label class="form-check-label" for="Checkme3">Action</label>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="data_count_">
                                            <select name="itemsPerPage" onchange="getShiftData(this)"
                                                class="form-control">
                                                <option value="10" {{ request('countData') == 10 ? 'selected' : '' }}>
                                                    10</option>
                                                <option value="50" {{ request('countData') == 50 ? 'selected' : '' }}>
                                                    50</option>
                                                <option value="100"
                                                    {{ request('countData') == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="search_box">
                                        <!-- <label class="form-label" for="exampleInputEmail1">Search</label> -->
                                        <div class="form-group group100">
                                            <form id="searchForm" method="GET">
                                                <input type="text" name="search"
                                                    value="{{ isset($_GET['search']) ? $_GET['search'] : '' }}"
                                                    class="form-control" aria-describedby="emailHelp"
                                                    placeholder="Search Here">
                                            </form>
                                        </div>
                                        {{-- <div class="src-btn">
                                    <button class="btn btn_search"><i class="ti-search"></i></button>
                                </div> --}}
                                    </div>
                                </div>
                                <script>
                                    function getShiftData(select) {
                                        if (!pagrLoaded) {
                                            var countData = select.value;
                                            // Get the current URL
                                            var currentUrl = window.location.href;
                                            // Check if the URL already contains a query string
                                            if (currentUrl.indexOf('?') !== -1) {
                                                // Append the countData parameter to the existing query string
                                                var updatedUrl = currentUrl + '&countData=' + encodeURIComponent(countData);
                                            } else {
                                                // If there is no existing query string, add the countData parameter
                                                var updatedUrl = currentUrl + '?countData=' + encodeURIComponent(countData);
                                            }
                                            // Redirect to the updated URL
                                            window.location.href = updatedUrl;
                                        }
                                    }
                                </script>
                                <style>
                                    .testingcls {
                                        display: flex;
                                        align-items: center;
                                        gap: 5px;
                                        flex-direction: row-reverse;
                                    }
                                </style>
                                <br>
                                <div class="table-responsive" id="">
                                    <table id="shiftTable" class="table  table-hover nowrap mb-0"
                                        style="margin: 0px !important;width: 100%;">
                                        {{-- <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;"> --}}
                                        <thead class="border-top">
                                            <tr>
                                                <th hidden>S.No</th>
                                                <th hidden class="bg-transparent border-bottom-0">Client Id</th>
                                                <th class="bg-transparent border-bottom-0 column-id">Shift Id</th>
                                                <th class="bg-transparent border-bottom-0 column-client">Client</th>
                                                <th class="bg-transparent border-bottom-0 column-cost">Cost</th>
                                                <th class="bg-transparent border-bottom-0 column-driver">Driver</th>
                                                <th hidden class="bg-transparent border-bottom-0">Parcels Taken</th>
                                                <th hidden class="bg-transparent border-bottom-0">Parcels Delivered</th>
                                                <th class="bg-transparent border-bottom-0 column-rego">REGO</th>
                                                <th class="bg-transparent border-bottom-0 column-vehicleType">Vehicle Type
                                                </th>
                                                <th class="bg-transparent border-bottom-0 column-state">State</th>
                                                    @if ($driverRole != 33)
                                                        <th style="display: none;" class="bg-transparent border-bottom-0 column-mobile_data_start">Mobile Date Start</th>
                                                        <th style="display: none;" class="bg-transparent border-bottom-0 column-mobile_data_finish">Mobile Date Finish</th>
                                                    @endif
                                                <th class="bg-transparent border-bottom-0 column-start_Date">Date Start
                                                </th>
                                                <th hidden class="bg-transparent border-bottom-0">Time Start</th>
                                                <th class="bg-transparent border-bottom-0 column-date_finish">Date Finish
                                                </th>
                                                <th hidden class="bg-transparent border-bottom-0">Time Finish</th>
                                                {{-- <th class="bg-transparent border-bottom-0">Base</th> --}}
                                                <th class="bg-transparent border-bottom-0 column-status">Status</th>
                                                <th hidden class="bg-transparent border-bottom-0">Total Hours</th>
                                                @if ($driverRole = Auth::guard('adminLogin')->user()->role_id)
                                                    @if ($driverRole == 33)
                                                        <th class="bg-transparent border-bottom-0">Total Hours Day Shift
                                                        </th>
                                                        <th class="bg-transparent border-bottom-0">Total Hours Night Shift
                                                        </th>
                                                        <th class="bg-transparent border-bottom-0">Total Hours Weekend
                                                            Shift</th>
                                                    @endif
                                                @endif
                                                <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Day
                                                    Shift</th>
                                                <th hidden class="bg-transparent border-bottom-0">Amount Payable Day Shift
                                                </th>
                                                <th hidden class="bg-transparent border-bottom-0">Amount Payable Night
                                                    Shift</th>
                                                <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Night
                                                    Shift</th>
                                                <th hidden class="bg-transparent border-bottom-0">Amount Payable Weekend
                                                    Shift</th>
                                                <th hidden class="bg-transparent border-bottom-0">Amount Chargeable Weekend
                                                    Shift</th>
                                                <th hidden class="bg-transparent border-bottom-0">Fuel Levy Payable</th>
                                                <th hidden class="bg-transparent border-bottom-0">Fuel Levy Chargeable
                                                    Fixed</th>
                                                <th hidden class="bg-transparent border-bottom-0">Fuel Levy Chargeable 250+
                                                </th>
                                                <th hidden class="bg-transparent border-bottom-0">Fuel Levy Chargeable 400+
                                                </th>
                                                <th hidden class="bg-transparent border-bottom-0">Extra Payable</th>
                                                <th hidden class="bg-transparent border-bottom-0">Extra Chargeable</th>
                                                <th hidden class="bg-transparent border-bottom-0">Total Chargeable</th>
                                                <th hidden class="bg-transparent border-bottom-0">Odometer Start</th>
                                                <th hidden class="bg-transparent border-bottom-0">Odometer End</th>
                                                <th class="bg-transparent border-bottom-0 column-totalPayable">Total Payable</th>
                                                <th class="bg-transparent border-bottom-0 column-traveledKm">Traveled KM
                                                </th>
                                                <th hidden class="bg-transparent border-bottom-0">Comment</th>
                                                @if (in_array('50', $arr) || in_array('51', $arr) || in_array('52', $arr) || in_array('53', $arr))
                                                    <th class="bg-transparent border-bottom-0 column-action"
                                                        style="width: 5%;">Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shift as $key => $allshift)
                                                <tr class="border-bottom">
                                                    <td hidden>{{ $key + 1 }}</td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getClientName->id ?? 0 }}
                                                    </td>
                                                    <td class="td sorting_1 column-id">QE{{ $allshift->shiftRandId }}</td>
                                                    <td class="td column-client">
                                                        {{ $allshift->getClientName->name ?? 'N/A' }}</td>
                                                    @php
                                                        $clientcenters =
                                                            DB::table('clientcenters')
                                                                ->where('id', $allshift->costCenter)
                                                                ->first() ?? 'N/A';
                                                        $clientbase = DB::table('clientbases')
                                                            ->where('id', $allshift->base)
                                                            ->first();
                                                        $rego = DB::table('vehicals')
                                                            ->where('id', $allshift->rego)
                                                            ->first();

                                                        $clientRates = DB::table('clientrates')->where(['clientId'=>$allshift->client,'type'=>$allshift->vehicleType])->first();
                                                    @endphp
                                                    <td class="td column-cost">{{ $clientcenters->name ?? 'N/A' }}</td>
                                                    <td class="td column-driver">
                                                        {{ $allshift->getDriverName->userName ?? 'N/A' }} {{ $allshift->getDriverName->surname ?? 'N/A' }}</td>
                                                    <td hidden class="td">{{ $allshift->parcelsToken ?? 'N/A' }}</td>
                                                    <td hidden class="td">
                                                        {{ $allshift->getFinishShift->parcelsDelivered ?? 'N/A' }}</td>
                                                    <td class="td column-rego">{{ $rego->rego ?? 'N/A' }}</td>
                                                    <td class="td column-vehicleType">
                                                        {{ $allshift->getVehicleType->name ?? 'N/A' }}</td>
                                                    <td class="td column-state">
                                                        {{ $allshift->getStateName->name ?? 'N/A' }}
                                                    </td>
                                                    @php
                                                        $finishshifts = DB::table('finishshifts')
                                                                ->where('shiftId', $allshift->id)
                                                                ->first() ?? '0';
                                                    @endphp
                                                    @if ($driverRole = Auth::guard('adminLogin')->user()->role_id)
                                                        @if ($driverRole != 33)
                                                            <td style="display: none;" class="td column-mobile_data_start">
                                                                {{ date('Y/m/d H:i', strtotime($allshift->createdDate)) }}
                                                            </td>
                                                            <td style="display: none;" class="td column-mobile_data_finish">
                                                            @if ($finishshifts && $finishshifts->submitted_at)
                                                                {{ date('Y/m/d H:i', strtotime($finishshifts->submitted_at)) }}
                                                            @else
                                                            N/A
                                                            @endif

                                                        </td>
                                                        @endif
                                                    @endif
                                                    
                                                    @if ($allshift['shiftStartDate'])
                                                        <td class="td column-start_Date">
                                                            {{ date('Y/m/d H:i', strtotime($allshift['shiftStartDate'])) }}
                                                        </td>
                                                    @else
                                                        <td class="td column-start_Date">N/A</td>
                                                    @endif
                                                    <td hidden class="td">
                                                        {{ $allshift->getFinishShift->startTime ?? 'N/A' }}</td>
                                                    @if ($finishshifts)
                                                        <td class="td column-date_finish">
                                                            {{ date('Y/m/d H:i', strtotime($finishshifts->endDate . ' ' . $finishshifts->endTime)) }}
                                                        </td>
                                                    @else
                                                        <td class="td column-date_finish">N/A</td>
                                                    @endif
                                                    <td hidden class="td">
                                                        {{ $allshift->getFinishShift->endTime ?? 'N/A' }}</td>
                                                    <td class="column-status">
                                                        <?php
                                                        $driverRole =  Auth::guard('adminLogin')->user();
                                                        $driverRole = $driverRole->role_id;
                                                        if ($allshift->finishStatus=='0') { 
                                                            ?>
                                                        <span class="light status-Created">Created</span>
                                                        <?php } elseif($allshift->finishStatus=='1'){ ?>
                                                        <span class="danger status-InProgress">In Progress</span>
                                                        <?php  } elseif($allshift->finishStatus=='2') { ?>
                                                        <span class="light status-ToBeApproved" <?php if($driverRole!==33){ ?>
                                                            onclick="approveAndReject(`{{ $allshift->id }}`)"
                                                            <?php } ?>>To Be Approved</span>
                                                        <?php } elseif ($allshift->finishStatus=='3') { ?>
                                                        <span class="light status-ToBeApr" <?php if($driverRole!==33){ ?>
                                                            onclick="shiftPaid(`{{ $allshift->id }}`)"
                                                            <?php } ?>>Approved</span>
                                                        <?php  } elseif ($allshift->finishStatus=='4') { ?>
                                                        <span class="light status-ToBeApr">Rejected</span>
                                                        <?php } elseif ($allshift->finishStatus=='5')  { ?>
                                                        <span class="light status-Paid">Paid</span>
                                                        <?php }elseif ($allshift->finishStatus=='6')  { ?>
                                                            <span class="light status-Paid">Already Paid</span>
                                                            <?php } else { ?>
                                                        <?php } ?>
                                                    </td>
                                                    @php
                                                        $daySum = 0;
                                                        $nightHours = 0;
                                                        $weekendHours = 0;
                                                    @endphp
                                                    @if ($finishshifts)
                                                        @php
                                                            $daySum =  floatval($finishshifts->dayHours) ?? 0;
                                                            $nightHours =  floatval($finishshifts->nightHours) ?? 0;
                                                            $weekendHours = floatval($finishshifts->weekendHours) ?? 0;
                                                        @endphp
                                                    @endif
                                                    @php
                                                        $chargeDayShift = ($clientRates->hourlyRateChargeableDays ?? 0) * ($finishshifts->dayHours ?? 0);
                                                        $chargeNight = ($clientRates->ourlyRateChargeableNight ?? 0) * ($finishshifts->nightHours ?? 0);
                                                    @endphp
                                                    <td hidden class="td sorting_1">
                                                        {{ $daySum + $nightHours + $weekendHours }}</td>
                                                    @if ($driverRole = Auth::guard('adminLogin')->user()->role_id)
                                                        @if ($driverRole == 33)
                                                            <td class="td sorting_1">
                                                                {{ optional($allshift->getFinishShift)->dayHours ?? 0 }}
                                                            </td>
                                                            <td class="td sorting_1">
                                                                {{ optional($allshift->getFinishShift)->nightHours ?? 0 }}
                                                            </td>
                                                            <td class="td sorting_1">
                                                                {{ optional($allshift->getFinishShift)->weekendHours ?? 0 }}
                                                            </td>
                                                            {{-- For Driver --}}
                                                        @endif
                                                    @endif
                                                    <td hidden class="td sorting_1">{{ $chargeDayShift }}</td>
                                                    @if ($allshift->priceOverRideStatus == '1')
                                                        @php
                                                            $priceCompare = DB::table('personrates')
                                                                ->where('type', $allshift->vehicleType)
                                                                ->where('personId', $allshift->driverId)
                                                                ->first();
                                                            $day = $priceCompare
                                                                ? ($priceCompare->hourlyRatePayableDays ?? 0) *
                                                                        optional($finishshifts)
                                                                            ->dayHours ??
                                                                    0
                                                                : 0;
                                                        @endphp
                                                        <td hidden class="td sorting_1">{{ $day }}</td>
                                                    @else
                                                        @php
                                                            $clientCharge = $clientRates;
                                                            $day = $clientCharge
                                                                ? $clientCharge->hourlyRatePayableDay *
                                                                        optional($finishshifts)
                                                                            ->dayHours ??
                                                                    0
                                                                : 0;
                                                        @endphp
                                                        <td hidden class="td sorting_1">{{ $day }}</td>
                                                    @endif
                                                    @if ($allshift->priceOverRideStatus == '1')
                                                        @php
                                                            $priceCompare = DB::table('personrates')
                                                                ->where('type', $allshift->vehicleType)
                                                                ->where('personId', $allshift->driverId)
                                                                ->first();
                                                            $night =
                                                                ($priceCompare
                                                                    ? $priceCompare->hourlyRatePayableNight
                                                                    : 0) *
                                                                ($finishshifts
                                                                    ? $finishshifts->nightHours ?? 0
                                                                    : 0);
                                                        @endphp
                                                        <td hidden class="td sorting_1">{{ $night }}</td>
                                                    @else
                                                        @if ($finishshifts && $finishshifts->nightHours ?? 0 != '0')
                                                            @php
                                                                $night =
                                                                    $clientRates
                                                                        ->hourlyRatePayableNight ??
                                                                    (0 * $finishshifts->nightHours ?? 0);
                                                            @endphp
                                                        @else
                                                            @php
                                                                $night = 0;
                                                            @endphp
                                                        @endif
                                                        <td hidden class="td sorting_1">{{ $night }}</td>
                                                    @endif
                                                    <td hidden
                                                        class="td sorting_1 {{ $clientRates->ourlyRateChargeableNight ?? 0 }}">
                                                        {{ $chargeNight }}</td>
                                                    @if ($allshift->priceOverRideStatus == '1')
                                                        @php
                                                            $priceCompare = DB::table('personrates')
                                                                ->where('type', $allshift->vehicleType)
                                                                ->where('personId', $allshift->driverId)
                                                                ->first();
                                                            $saturday = $priceCompare
                                                                ? ($priceCompare->hourlyRatePayableSaturday ?? 0) *
                                                                    ($finishshifts
                                                                        ? $finishshifts->saturdayHours
                                                                        : 0)
                                                                : 0;
                                                            $sunday = $priceCompare
                                                                ? ($priceCompare->hourlyRatepayableSunday ?? 0) *
                                                                    ($finishshifts
                                                                        ? $finishshifts->sundayHours
                                                                        : 0)
                                                                : 0;
                                                        @endphp
                                                        <td hidden class="td sorting_1">{{ $saturday + $sunday }}</td>
                                                    @else
                                                        @php
                                                            $saturday = 0;
                                                            $sunday = 0;
                                                            if (
                                                                $finishshifts &&
                                                                $finishshifts->saturdayHours != '0'
                                                            ) {
                                                                $saturday =
                                                                    $clientRates
                                                                        ->hourlyRatePayableSaturday ??
                                                                    (0 * $finishshifts->saturdayHours ??
                                                                        0);
                                                            }
                                                            if (
                                                                $finishshifts &&
                                                                $finishshifts->sundayHours !== null &&
                                                                $finishshifts->sundayHours != '0'
                                                            ) {
                                                                $sunday =
                                                                    floatval(
                                                                        $clientRates
                                                                            ->hourlyRatePayableSunday,
                                                                    ) *
                                                                    floatval($finishshifts->sundayHours);
                                                            }
                                                        @endphp
                                                        <td hidden class="td sorting_1">{{ $saturday + $sunday }}</td>
                                                    @endif
                                                    @if (!empty($finishshifts->saturdayHours))
                                                        @php
                                                            $saturday =
                                                                $clientRates
                                                                    ->hourlyRateChargeableSaturday ??
                                                                (0 * $finishshifts->saturdayHours ?? 0);
                                                        @endphp
                                                    @else
                                                        @php
                                                            $saturday = 0;
                                                        @endphp
                                                    @endif
                                                    @if (!empty($finishshifts->sundayHours))
                                                        @php
                                                            $sunday =
                                                                ($clientRates->hourlyRateChargeableSunday??0) *
                                                                $finishshifts->sundayHours;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $sunday = 0;
                                                        @endphp
                                                    @endif
                                                    <td hidden class="td sorting_1 saturday">{{ $saturday + $sunday }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->fuelLevyPayable ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable250 ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->fuelLevyChargeable400 ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->extraPayable ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->extraChargeable ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getShiftMonetizeInformation->totalChargeable ?? '0' }}
                                                    </td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getFinishShift->odometerStartReading ?? '0' }}</td>
                                                    <td hidden class="td sorting_1">
                                                        {{ $allshift->getFinishShift->odometerEndReading ?? '0' }}</td>
                                                        
                                                            @php
                                                                $extra_rate_per_hour = $allshift->getDriverName->extra_rate_per_hour ??'0';
                                                            @endphp
                                                        
                                                            @php
                                                                $dayammmm='0';
                                                            @endphp
                                                            @if($allshift->getFinishShift->dayHours ?? 0 !='0')
                                                                @php
                                                                    $dayammmm = (($clientRates->hourlyRatePayableDay??0) + $extra_rate_per_hour ?? 0) * ($finishshifts->dayHours ?? 0);
                                                                @endphp
                                                            @endif
                                                            @if($allshift->getFinishShift->nightHours ?? 0 !='0')
                                                                @php
                                                                    $nightamm = (($clientRates->hourlyRatePayableNight??0) + $extra_rate_per_hour ?? 0) * ($finishshifts->nightHours ?? 0);
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $nightamm = 0
                                                                @endphp
                                                           @endif
                                                           @php
                                                            $saturday = 0;
                                                            $sunday = 0;
                                                                if ($allshift->getFinishShift && $allshift->getFinishShift->saturdayHours != '0') {
                                                                    $saturday = (($clientRates->hourlyRatePayableSaturday??0) + $extra_rate_per_hour ?? 0) * ($finishshifts->saturdayHours ?? 0);
                                                                }
                                                                if ($allshift->getFinishShift && $allshift->getFinishShift->sundayHours != '0') {
                                                                    $sunday = (($clientRates->hourlyRatePayableSunday??0) + $extra_rate_per_hour ?? 0) * ($finishshifts->sundayHours ?? 0);
                                                                }
                                                            $finalAmount=$saturday +  $sunday;
                                                            @endphp
                                                    @php
                                                        $payAmount = round($dayammmm,2) + round($nightamm,2) + round($finalAmount,2) ;
                                                        $updatedAmnt =  round($allshift->payAmount?? 0 , 2);
                                                        $shiftMonetizeInformation = DB::table('shiftMonetizeInformation')->where('shiftId',$allshift->id)->first();
                                                        $finalpayAmount = $payAmount + ($shiftMonetizeInformation->fuelLevyPayable??0)+($shiftMonetizeInformation->extraPayable??0);
                                                    @endphp
                                                    @if($finalpayAmount)
                                                    @php
                                                         $finalpayamnnt = $finalpayAmount;
                                                    @endphp
                                                    @elseif ($payAmount < $updatedAmnt)
                                                        @php
                                                            $finalpayamnnt = $updatedAmnt;
                                                        @endphp
                                                    @else
                                                        @php
                                                            $finalpayamnnt = $payAmount;
                                                        @endphp
                                                    @endif
                                                    {{-- @if ($allshift->finishStatus == '5' || $allshift->finishStatus == '2' || $allshift->finishStatus == '3') --}}
                                                        {{-- <td class="td">{{ $allshift->getShiftMonetizeInformation->totalPayable??'0' + $payAmount??'0'}} </td> --}}
                                                        <td class="td column-totalPayable">{{ $finalpayamnnt ? round($finalpayamnnt, 2) : 0 }}
                                                        </td>
                                                    {{-- @else
                                                        <td class="td column-totalPayable">0</td>
                                                    @endif --}}
                                                    {{-- // Add pay --}}
                                                    @php
                                                        $km = ($allshift->getFinishShift?->odometerEndReading ?? 0) - ($allshift->getFinishShift?->odometerStartReading ?? 0);
                                                    @endphp
                                                    <td class="td column-traveledKm"><span id="span_status_31240">{{ $km ??'0' }}</span>
                                                    </td>
                                                    <td hidden><span
                                                            id="span_status_31240">{{ $allshift->getFinishShift->comments ?? 'N/A' }}</span>
                                                    </td>
                                                    @if (in_array('50', $arr) || in_array('51', $arr) || in_array('52', $arr) || in_array('53', $arr))
                                                        <td class="column-action">
                                                            <div class="dropdown">
                                                                <a class="nav-link float-end text-muted pe-0 pt-0" href="javascript:void(0)" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    @if (in_array('50', $arr))
                                                                        @if ($allshift->finishStatus == '2')
                                                                            <a onclick="approveAndReject(`{{ $allshift->id }}`)"
                                                                                class="dropdown-item text-green"
                                                                                data-bs-toggle="modal"><i class="ti-check-box fs-14"></i>Approve Shift</a>
                                                                        @else
                                                                            <a class="dropdown-item text-green"
                                                                                style="color:grey !important"
                                                                                data-bs-toggle="modal"><i class="ti-check-box fs-14"></i>Approve Shift</a>
                                                                        @endif
                                                                    @endif
                                                                    @if (in_array('51', $arr))
                                                                        <a class="dropdown-item text-info"
                                                                            href="{{ route('admin.shift.report.view', ['id' => $allshift->id]) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="View"><i class="fe fe-eye fs-14"></i>View
                                                                        </a>
                                                                    @endif
                                                                    @if ($driverRole != 33)
                                                                    @if (in_array('52', $arr))
                                                                        <a class="dropdown-item text-warning"
                                                                            href="{{ route('admin.shift.report.edit', ['id' => $allshift->id]) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Edit"><i class="fe fe-edit fs-14"></i> Edit
                                                                        </a>
                                                                    @endif
                                                                    @endif

                                                                    @if (in_array('53', $arr))
                                                                        <a class="dropdown-item text-parcel"
                                                                            href="{{ route('admin.shift.parcels', ['id' => $allshift->id]) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-original-title="Parcel"><i class="fe fe-box"></i> Parcel
                                                                        </a>
                                                                        {{-- <a href="{{ route('admin.shift.parcels'  , ['id' => $allshift->id] )}}" class="btn btn-parcel" ><i class="fe fe-box"></i></a> --}}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Custom div for lengthMenu, search bar, and buttons -->
                                </div>
                                @if ($itemsPerPage != 'all')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <ul class="pagination pagination-rounded bottom_pagination mt-3 mb-4 pb-1">
                                                {!! $shift->withQueryString()->links() !!}
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                @endif
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.column-toggle').change(function() {
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
                    $('#example').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'colvis'
                        ]
                    });
                });
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
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ], // Customize entries dropdown options
                "pageLength": 10 // Set default page length
            });
        });
    </script>
    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            exportToExcel('custom_table_table1');
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
        function approveAndReject(shiftId) {
            var shiftId = shiftId;
            $("#AppendshiftId").val(shiftId);
            $("#approveAndRejected").modal('show');
        }
        function approved() {
            $("#approveAndRejected").modal('hide');
            var shiftId = $("#AppendshiftId").val();
            var reason = $("#add_reason").val();
            var label = "Shift";
            $.ajax({
                type: "POST",
                url: "{{ route('admin.shift.shiftapprove') }}",
                data: {
                    "shiftId": shiftId,
                    "_token": "{{ csrf_token() }}",
                    "reason":reason
                },
                dataType: 'json',
                success: function(result) {
                    swal({
                        type: 'success',
                        title: 'Shift!',
                        text: 'Shift Approved Successfully',
                        timer: 1000
                    });
                    window.setTimeout(function() {}, 1000);
                    location.reload();
                    if (that) {
                        //delete specific row
                        $(that).parent().parent().remove();
                    }
                },
                error: function(data) {}
            });
        }
        function rejected() {
            $("#approveAndRejected").modal('hide');
            var shiftId = $("#AppendshiftId").val();
            var label = "Shift";
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
                            url: "{{ route('admin.shift.shiftRejected') }}",
                            data: {
                                "shiftId": shiftId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                    type: 'success',
                                    title: 'Shift!',
                                    text: 'Shift Rejected Successfully',
                                    timer: 1000
                                });
                                window.setTimeout(function() {}, 1000);
                                location.reload();
                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }
                            },
                            error: function(data) {}
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
        function shiftPaid(shiftId) {
            var label = "Address";
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
                            url: "{{ route('admin.shift.shiftPaid') }}",
                            data: {
                                "shiftId": shiftId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                    type: 'success',
                                    title: 'Paid!',
                                    text: 'Shift Paid Successfully',
                                    timer: 1000
                                });
                                window.setTimeout(function() {}, 1000);
                                location.reload();
                                if (that) {
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
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
    </script>
    <script>
        function getdata(select)
        {
            var clientId = {!! json_encode($clients) !!};
            // console.log(clientId);
            var stateId = $("#stateId :selected").map((_, e) => e.value).get();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.getClient') }}",
                data: {
                    stateId: stateId
                },
                success: function(data) {
                    if (data.success == 200) {
                        $('#appendClient').find('option:not(:first)').remove();
                        $('#appendClient')[0].options.length = 0;
                        var html2 = '';
                        var selectedClients = {!! json_encode($clients) !!};
                        selectedClients = Array.isArray(selectedClients) ? selectedClients : [selectedClients];
                        $.each(data.items, function(index, items) {
                            var isSelected = selectedClients.includes((items.id).toString());
                            // console.log(isSelected,selectedClients,items.id);
                            html2 += '<option value="' + items.id + '" ' + (isSelected ? 'selected' :
                                '') + '>' + items.name + '</option>';
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
        function getCostCenter(select) {
            const urlSearchParams = new URLSearchParams(window.location.search);
            //
            var costCenter = {!! json_encode($costCenter) !!};
            //  console.log(costCenter);
            var clientId = $("#appendClient :selected").map((_, e) => e.value).get();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.getCostCenter') }}",
                data: {
                    clientId: clientId
                },
                success: function(data) {
                    if (data.success == 200) {
                        $('#appendCostCenter').find('option:not(:first)').remove();
                        $('#appendCostCenter')[0].options.length = 0;
                        $('#appendVehicleType').find('option:not(:first)').remove();
                        var html2 = '';
                        var costCenter = {!! json_encode($costCenter) !!};
                        costCenter = Array.isArray(costCenter) ? costCenter : [costCenter];
                        $.each(data.items, function(index, items) {
                            var isSelected = costCenter.includes((items.id).toString());
                            console.log(isSelected, costCenter, items.id);
                            html2 += '<option value="' + items.id + '" ' + (isSelected ? 'selected' :
                                '') + '>' + items.name + '</option>';
                        });
                        $('#appendCostCenter').append(html2);
                        var html3 = '';
                        $.each(data.getType, function(index, items) {
                            html3 += '<option value="">Choose one</option><option value="' + items
                                .get_client_type.id + '">' + items.get_client_type.name + '</option>';
                        });
                        $('#appendVehicleType').append(html3);
                        var html4 = '';
                        $.each(data.clientBase, function(index, items) {
                            html4 += '<option value="">Choose one</option><option value="' + items.id +
                                '">' + items.base + '</option>';
                        });
                        $('#appendBase').append(html4);
                    }
                    if (data.success == 400) {
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
        function showImportForm() {
            $("#showImportForm").modal('show');
        }
    </script>
    <script>
        $(document).ready(function() {
            // Set data-page-size to a large number to show all rows
            $('#custom_table').data("page-size", 1000);
            // Disable pagination
            $('#custom_table').bootstrapTable('destroy').bootstrapTable({
                pagination: false,
            });
        });

    </script>
    
@endsection
