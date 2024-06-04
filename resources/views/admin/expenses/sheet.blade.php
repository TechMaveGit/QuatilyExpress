@extends('admin.layout')
@section('content')
    <?php
    $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()), true);
    $arr = [];
    foreach ($D as $v) {
        $arr[] = $v['permission_id'];
    }
    ?>


    <style>
        .first {
            color: red;
            font-weight: bold;
            padding-top: 8px;
        }
    </style>

    <style>
        .dt-buttons {
            margin-left: -158px;
        }

        .dataTables_empty {
            display: none;
        }

        .dt-buttons {
            margin-left: -158px;
        }

        .dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }

        <style>.dt-button.dropdown-item.buttons-columnVisibility.active {
            background-color: #282618;
            /* Replace with your desired color code */
            /* You can also add other styles as needed */
        }

        .brdcls .select2-selection__rendered {
            border-color: red;
            height: 40px;
            line-height: 20px;
            border: 1px solid #ccc;
            padding: 0px 5px;
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
    </style>


    <!-- Modal -->
    <div class="modal fade" id="add_type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">


            <div class="modal-content">
                <form action="{{ route('add.vehicle') }}" method="post"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Add Type </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="vehicaleTyle" aria-describedby="emailHelp" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="add_operaction_type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('add.op.vehicle') }}" method="post"> @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Add Type </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                            name="vehicaleTyle" aria-describedby="emailHelp" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Expense Sheet</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item" aria-current="page">Expenses</li>
                    <li class="breadcrumb-item active" aria-current="page">Expense Sheet</li>

                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card show_portfolio_tab">
                            <div class="card-header">
                                <ul class="nav nav-tabs">

                                    @if (in_array('37', $arr))
                                        <li class="nav-item">
                                            <a href="#home" data-bs-toggle="tab" aria-expanded="false"
                                                class="nav-link active">
                                                <span><i class="ti-light-bulb"></i></span>
                                                <span> General Expenses</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array('41', $arr))
                                        <li class="nav-item">
                                            <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                                <span><i class="ti-agenda"></i></span>
                                                <span> Toll Expenses</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array('46', $arr))
                                        <li class="nav-item">
                                            <a href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                                <span><i class="ti-clipboard"></i></span>
                                                <span>Operation Expenses </span>
                                            </a>
                                        </li>
                                    @endif


                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="tab-content  text-muted">

                                    <div class="tab-pane show active" id="home">
                                        <div class="main_bx_dt__">

                                            <div class="top_dt_sec">

                                                <div class="row align-items-center">

                                                    <hr class="mt-2">

                                                    <form class="saveclass" id="saveExpense">

                                                        <div class="col-lg-4">
                                                            <div class="check_box">
                                                                <label class="form-label" for="exampleInputEmail1">Select Type <span class="text-danger">*</span></label>
                                                                <div class="form-group">

                                                                    <input type="hidden" name="firstSection"
                                                                        value="1" />

                                                                    <select class="form-control select2 form-select"
                                                                        name="vehical_type" id="first1" required>
                                                                        <option value="">Choose one</option>
                                                                        @forelse ($generalexpensestypes as $allgeneralexpensestypes)
                                                                            <option
                                                                                value="{{ $allgeneralexpensestypes->id }}">
                                                                                {{ $allgeneralexpensestypes->name }}
                                                                            </option>
                                                                        @empty
                                                                        @endforelse

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="search_btn">
                                                                <a href="#" class="btn btn-primary srch_btn"
                                                                    data-bs-toggle="modal" data-bs-target="#add_type">+
                                                                    Add Type</a>

                                                            </div>
                                                        </div>
                                                        <hr class="mt-2">

                                                        <div class="col-lg-12">
                                                            <div class="row">

                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Date</label>
                                                                        <input type="text" name="date"
                                                                            min="1000-01-01" max="9999-12-31"
                                                                            class="form-control onlydatenew" id=""
                                                                            aria-describedby="emailHelp" placeholder="" />

                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Driver Responsible
                                                                            <span class="red">*</span></label>
                                                                        <div class="form-group">

                                                                            <select
                                                                                class="form-control select2 form-select"
                                                                                name="person_name"
                                                                                onchange="getdata(this)" required>
                                                                                <option value=""> Select Any One
                                                                                </option>
                                                                                @forelse ($dr as $alldr)
                                                                                    <option value="{{ $alldr->id }}"
                                                                                        data-select2-id="select2-data-2-23cq">
                                                                                        {{ $alldr->userName??"" }} {{ $alldr->userName??"" }} ({{ $alldr->email??"" }})</option>

                                                                                @empty
                                                                                @endforelse

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Person Approve <span
                                                                                class="red">*</span></label>
                                                                        <div class="form-group">

                                                                            <select
                                                                                class="form-control select2 form-select"
                                                                                name="driverResponsible" required>
                                                                                <option value=""> Select Any One
                                                                                </option>
                                                                                @forelse ($dr as $alldr)
                                                                                    <option value="{{ $alldr->id }}" data-select2-id="select2-data-2-23cq">{{ $alldr->userName??'' }} {{ $alldr->surname??'' }} ({{ $alldr->email??'' }})</option>
                                                                                @empty
                                                                                @endforelse

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Cost <span class="text-danger">*</span></label>
                                                                        <input type="number" name="cost"
                                                                            min="0" step="any" required
                                                                            class="form-control fc-datepicker"
                                                                            id="first5" aria-describedby="emailHelp"
                                                                            placeholder="">
                                                                    </div>

                                                                </div>

                                                                @php
                                                                    $allRego = DB::table('vehicals')
                                                                        ->where('status', '1')
                                                                        ->get();
                                                                @endphp

                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Rego</label>
                                                                        <select class="form-control select2 form-select"
                                                                            name="rego" data-placeholder="Choose one">
                                                                            <option value="">Select Any One </option>
                                                                            @foreach ($allRego as $rego)
                                                                                <option value="{{ $rego->id }}">
                                                                                    {{ $rego->rego }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>



                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Description </label>
                                                                        <textarea class="form-control mb-4" name="description" id="first7" placeholder="Textarea" rows="4"
                                                                            required></textarea>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>




                                                        <div class="col-lg-12 mb-5">
                                                            <div class="search_btn import_btn_box text-end">
                                                                <button type="submit" class="btn btn-primary srch_btn">+
                                                                    Add Expense </button>

                                                                <a class="btn btn-green srch_btn ms-3" id="exportBtn1"
                                                                    style="color: white;"> <i
                                                                        class="fa fa-file-excel-o"></i> Download Excel</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">
                                                            {{-- <table id="example" class="table  table-hover mb-0" style="margin: 0px !important;width: 100%;"> --}}
                                                            <table id="custom_table2" class="table table-hover mb-0"
                                                                style="margin: 0px !important;width: 100%;">


                                                                <thead class="border-top">
                                                                    <tr>

                                                                        <th class="bg-transparent border-bottom-0">S.No
                                                                        </th>
                                                                        <th class="bg-transparent border-bottom-0">Type
                                                                        </th>
                                                                        <th class="bg-transparent border-bottom-0">Date
                                                                        </th>
                                                                        {{-- <th class="bg-transparent border-bottom-0">Person Name</th> --}}
                                                                        <!--<th class="bg-transparent border-bottom-0">Person Approve </th>-->
                                                                        <th class="bg-transparent border-bottom-0">Cost
                                                                        </th>
                                                                        <th class="bg-transparent border-bottom-0">
                                                                            Description</th>
                                                                        <th class="bg-transparent border-bottom-0">Rego
                                                                        </th>
                                                                        <!-- <th class="bg-transparent border-bottom-0">End Date</th> -->
                                                                        <th class="bg-transparent border-bottom-0"
                                                                            style="width: 5%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="saveExpenseData">

                                                                    @forelse ($expense as $key=>$allexpense)
                                                                        @php
                                                                            $vehical_type =
                                                                                DB::table('generalexpensestypes')
                                                                                    ->where(
                                                                                        'id',
                                                                                        $allexpense->vehical_type,
                                                                                    )
                                                                                    ->first()->name ?? 'N/A'


                                                                        @endphp
                                                                        @if ($allexpense->date != null)
                                                                        @php

                                                                        $dateTime = date('Y-m-d',strtotime($allexpense->date));

                                                                        @endphp
                                                                        @else
                                                                        @php
                                                                            $dateTime = '--';
                                                                        @endphp
                                                                        @endif

                                                                        <tr class="border-bottom">
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>{{ $vehical_type }}</td>
                                                                            <td>{{ $dateTime }}</td>
                                                                            {{-- <td>{{ $userName }}</td> --}}
                                                                            <!--<td>{{ $allexpense->person_approve }}</td>-->
                                                                            <td>{{ $allexpense->cost }}</td>
                                                                            <td>{{ $allexpense->description }}</td>
                                                                            @php
                                                                                $regoId =
                                                                                    DB::table('vehicals')
                                                                                        ->where('id', $allexpense->rego)
                                                                                        ->first()->rego ?? '';
                                                                            @endphp
                                                                            <td>{{ $regoId }}</td>


                                                                            @if (in_array('38', $arr))
                                                                                <td>
                                                                                    <div class="g-2">
                                                                                        {{-- <a class="btn text-primary btn-sm"  data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a> --}}



                                                                                        <a onclick="removeGeneralExpenses(this,'{{ $allexpense->id }}')"
                                                                                            class="btn text-danger btn-sm"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-original-title="Delete"><span
                                                                                                class="fe fe-trash-2 fs-14"></span></a>
                                                                                    </div>
                                                                                </td>
                                                                            @endif



                                                                        </tr>
                                                                    @empty
                                                                    @endforelse

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!-- main_bx_dt -->
                                    </div>
                                    <div class="tab-pane" id="profile">
                                        <div class="main_bx_dt__">
                                            <div class="top_dt_sec">
                                                <form id="saveTollExpense">
                                                    <div class="row">

                                                        <div class="col-lg-3">

                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Start Date <span class="red">*</span></label>

                                                                <input type="text" name="start_date"
                                                                    min="1000-01-01" max="9999-12-31"
                                                                    class="form-control onlydatenew"
                                                                    aria-describedby="emailHelp" placeholder="" required/>

                                                                <input type="hidden" name="firstSection"
                                                                    value="2" />
                                                                <p class="first" id="firstcls11" style="display: none">
                                                                    Please Add Start Date</p>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">End
                                                                    Date <span class="red">*</span></label>

                                                                <input type="text" name="end_date"
                                                                    min="1000-01-01" max="9999-12-31"
                                                                    class="form-control onlydatenew"
                                                                    aria-describedby="emailHelp" placeholder="" required/>



                                                                <p class="first" id="firstcls12" style="display: none">
                                                                    Please Add End Date</p>
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3">
                                                            <div class="check_box">
                                                                <label class="form-label" for="exampleInputEmail1">State
                                                                    <span class="red">*</span></label>
                                                                <div class="form-group">

                                                                    <select class="form-control select2 form-select"
                                                                        name="state" id="first13" required>
                                                                        <option value="">Choose one</option>
                                                                        @foreach ($states as $allstates)
                                                                            <option value="{{ $allstates->id }}">
                                                                                {{ $allstates->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <p class="first" id="firstcls13"
                                                                        style="display: none">Please Select Any State</p>

                                                                </div>
                                                            </div>
                                                        </div>

                                                       

                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">Details</label>
                                                                <input type="text" name="details" class="form-control"
                                                                    id="first14"aria-describedby="emailHelp"
                                                                    placeholder="">
                                                                <p class="first" id="firstcls14" style="display: none">
                                                                    Please Add Detail</p>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">LPN/Tag number</label>
                                                <input type="text" name="lpn_tag_number" class="form-control fc-datepicker"  id="" aria-describedby="emailHelp" placeholder="">
                                            </div>

                                         </div> --}}



                                                        <div class="col-lg-3">
                                                            <div class="check_box">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">Rego <span
                                                                        class="red">*</span></label>
                                                                <div class="form-group">



                                                                    <select class="form-control select2 form-select"
                                                                        name="rego" id="first13" required>
                                                                        <option value="">Select Any One </option>
                                                                        @foreach ($allRego as $rego)
                                                                            <option value="{{ $rego->id }}">
                                                                                {{ $rego->rego }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <p class="first" id="firstcls13"
                                                                        style="display: none">Please Select Any Rego</p>

                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Vehicle
                                                                    Class</label>
                                                                <input type="text" name="vehicle_class"
                                                                    class="form-control" id="first16"
                                                                    aria-describedby="emailHelp" placeholder="">
                                                                <p class="first" id="firstcls16" style="display: none">
                                                                    Please Add Vehicle Class</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Cost
                                                                    <span class="red">*</span></label>
                                                                <input type="number" name="trip_cost"
                                                                    class="form-control" id="first17" min="0" step="any"
                                                                    aria-describedby="emailHelp" placeholder="$" required>
                                                                <p class="first" id="firstcls17" style="display: none">
                                                                    Please Add Trip Cost</p>

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Fleet
                                                                    ID</label>
                                                                <input type="text" name="fleet_id"
                                                                    class="form-control" id="exampleInputEmail1"
                                                                    aria-describedby="emailHelp" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mb-5">
                                                            <div class="search_btn import_btn_box text-end">
                                                                <button type="submit" class="btn btn-primary srch_btn">+
                                                                    Add Expense </button>
                                                                <a class="btn btn-green srch_btn ms-3" id="exportBtn3"
                                                                    style="color: white;"> <i
                                                                        class="fa fa-file-excel-o"></i> Download Excel</a>
                                                            </div>
                                                        </div>
                                                </form>



                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table id="custom_table3" class="table table-hover mb-0"
                                                            style="margin: 0px !important;width: 100%;">
                                                            <thead class="border-top">
                                                                <tr>
                                                                    <th class="bg-transparent border-bottom-0">S.NO</th>
                                                                    <th class="bg-transparent border-bottom-0">Start Date
                                                                    </th>
                                                                    <th class="bg-transparent border-bottom-0">Details</th>
                                                                    {{-- <th class="bg-transparent border-bottom-0">LPN/Tag number</th> --}}
                                                                    <th class="bg-transparent border-bottom-0">Rego </th>
                                                                    <th class="bg-transparent border-bottom-0">Vehicle
                                                                        Class</th>
                                                                    <th class="bg-transparent border-bottom-0">Trip Cost
                                                                    </th>
                                                                    <th class="bg-transparent border-bottom-0">Fleet ID
                                                                    </th>
                                                                    <th class="bg-transparent border-bottom-0">End Date
                                                                    </th>
                                                                    <th class="bg-transparent border-bottom-0"
                                                                        style="width: 5%;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tollexpense">

                                                                @forelse ($tollexpense as $key=>$alltollexpense)
                                                                    @php
                                                                        $start_date = new DateTime(
                                                                            $alltollexpense->start_date,
                                                                        );
                                                                        $startDt = $start_date->format('Y/m/d H:i:s');
                                                                    @endphp


                                                                    <tr class="border-bottom">
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $startDt }}</td>
                                                                        <td>{{ $alltollexpense->details }}</td>
                                                                        {{-- <td>{{ $alltollexpense->lpn_tag_number }}</td> --}}

                                                                        @php
                                                                            $regoId =
                                                                                DB::table('vehicals')
                                                                                    ->where('id', $alltollexpense->rego)
                                                                                    ->first()->rego ?? '';
                                                                        @endphp
                                                                        <td>{{ $regoId }}</td>
                                                                        <td>{{ $alltollexpense->vehicle_class }}</td>
                                                                        <td>{{ $alltollexpense->trip_cost }}</td>
                                                                        <td>{{ $alltollexpense->fleet_id }}</td>
                                                                        <td>{{ $alltollexpense->end_date }}</td>

                                                                        @if (in_array('42', $arr))
                                                                            {{-- <div class="g-2"> --}}
                                                                            <td><a onclick="removeTotalExpenses(this,'{{ $alltollexpense->id }}')"
                                                                                    class="btn text-danger btn-sm"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete"><span
                                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                                                {{-- </div> --}}
                                                                        @endif

                                                                    </tr>
                                                                @empty
                                                                @endforelse


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- main_bx_dt -->
                                </div>


                                <div class="tab-pane email_template" id="messages">
                                    <div class="main_bx_dt__">
                                        <div class="top_dt_sec">
                                            <div class="row align-items-center">
                                                <form id="saveOperactionExpenses">
                                                    <div class="col-lg-4">
                                                        <div class="check_box">
                                                            <label class="form-label" for="exampleInputEmail1">Select Type <span class="text-danger">*</span></label>
                                                            <div class="form-group">

                                                                <input type="hidden" name="firstSection"
                                                                    value="3" />

                                                                <select class="form-control select2 form-select"
                                                                    name="vehical_type" data-placeholder="Choose one"
                                                                    required>
                                                                    <option value="">Choose one</option>

                                                                    @forelse ($operatingexpensetype as $alloperatingexpensetype)
                                                                        <option
                                                                            value="{{ $alloperatingexpensetype->id }}">
                                                                            {{ $alloperatingexpensetype->name }}</option>
                                                                    @empty
                                                                    @endforelse

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="search_btn">
                                                            <a href="#" class="btn btn-primary srch_btn"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#add_operaction_type">+ Add Type</a>

                                                        </div>
                                                    </div>
                                                    <hr class="mt-2">
                                                    <div class="col-lg-12">
                                                        <div class="row align-items-center">

                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="exampleInputEmail1">Date</label>

                                                                        <input type="text" name="date" min="1000-01-01" max="9999-12-31" class="form-control onlydatenew" aria-describedby="emailHelp" placeholder=""
                                                                        value="">
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="exampleInputEmail1">Person Approve <span
                                                                            class="red">*</span></label>
                                                                    <div class="form-group">

                                                                        <select class="form-control select2 form-select"
                                                                            name="person_approve"
                                                                            data-placeholder="Choose one">
                                                                            <option value=""
                                                                                data-select2-id="select2-data-2-23cq">
                                                                                Selected</option>

                                                                            <option value=""> Select Any One</option>
                                                                            @forelse ($dr as $alldr)
                                                                                <option value="{{ $alldr->id }}"
                                                                                    data-select2-id="select2-data-2-23cq">
                                                                                    {{ $alldr->userName??'' }} {{ $alldr->surname??'' }} ({{ $alldr->email??'' }})</option>

                                                                            @empty
                                                                            @endforelse

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="exampleInputEmail1">Cost <span class="text-danger">*</span></label>
                                                                    <input type="number" min="0" step="any" required
                                                                        class="form-control fc-datepicker"  name="cost"
                                                                        id="" aria-describedby="emailHelp"
                                                                        placeholder="">
                                                                </div>

                                                            </div>


                                                            <div class="col-lg-3">
                                                                <div class="check_box">
                                                                    <label class="form-label"
                                                                        for="exampleInputEmail1">Rego <span
                                                                        class="red">*</span></label>
                                                                    <div class="form-group">




                                                                        <select class="form-control select2 form-select"
                                                                            name="rego" id="first13"
                                                                            data-placeholder="Choose one">
                                                                            <option value="">Choose one</option>
                                                                            @foreach ($vehicals as $allvehicals)
                                                                                <option value="{{ $allvehicals->id }}">
                                                                                    {{ $allvehicals->rego }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <p class="first" id="firstcls13"
                                                                            style="display: none">Please Select Any Rego
                                                                        </p>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label"
                                                                        for="exampleInputEmail1">Description </label>
                                                                    <textarea class="form-control mb-4" name="description" placeholder="Textarea" rows="4"></textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>




                                                    <div class="col-lg-12 mb-5">
                                                        <div class="search_btn import_btn_box text-end">

                                                            <button type="submit" class="btn btn-primary srch_btn">+ Add
                                                                Expense </button>

                                                            {{-- <a href="#" class="btn btn-green srch_btn ms-3"> <i class="fa fa-file-excel-o"></i> Download Excel</a> --}}

                                                            {{-- <div class='file file--upload'>
                                                    <label for='input-file'>
                                                        <i class="fa fa-file-excel-o"></i>Import Excel
                                                    </label>
                                                    <input id='input-file' type='file' />
                                                    </div> --}}


                                                            {{-- <div class='file file--upload'>
                                                <label for='input-file'>
                                                    <i class="fa fa-file-excel-o"></i>Import Excel
                                                </label>
                                                <input id='input-file' type='file' />
                                                </div> --}}

                                                        </div>
                                                    </div>
                                                </form>




                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        {{-- <table id="basic-datatable1" class="table table-bordered text-nowrap mb-0"> --}}
                                                        <table id="custom_table" class="table table-hover mb-0"
                                                            style="margin: 0px !important;width: 100%;">
                                                            <thead class="border-top">
                                                                <tr>

                                                                    <th class="bg-transparent border-bottom-0">S.NO</th>
                                                                    <th class="bg-transparent border-bottom-0">Type</th>
                                                                    <th class="bg-transparent border-bottom-0">Date</th>
                                                                    {{-- <th class="bg-transparent border-bottom-0">Person Name</th> --}}
                                                                    <th class="bg-transparent border-bottom-0">Person
                                                                        Approve </th>
                                                                    <th class="bg-transparent border-bottom-0">Cost</th>
                                                                    <th class="bg-transparent border-bottom-0">Description
                                                                    </th>
                                                                    <th class="bg-transparent border-bottom-0">Rego</th>
                                                                    <!-- <th class="bg-transparent border-bottom-0">End Date</th> -->
                                                                    <th class="bg-transparent border-bottom-0"
                                                                        style="width: 5%;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="saveOperactionExp">
                                                                @forelse ($operactionexp as $key=>$alloperactionexp)
                                                                    @php
                                                                        $vehical_type =
                                                                            DB::table('operatingexpensetypes')
                                                                                ->where(
                                                                                    'id',
                                                                                    $alloperactionexp->vehical_type,
                                                                                )
                                                                                ->first()->name ?? 'N/A';
                                                                        $userName =
                                                                            DB::table('drivers')
                                                                                ->where(
                                                                                    'id',
                                                                                    $alloperactionexp->person_name,
                                                                                )
                                                                                ->first()->userName ?? 'N/A';
                                                                    @endphp

                                                                    <tr class="border-bottom">
                                                                        <td>{{ $key + 1 }}</td>
                                                                        <td>{{ $vehical_type }}</td>

                                                                        @php
                                                                            $alloperactionexps = new DateTime(
                                                                                $alloperactionexp->date,
                                                                            );
                                                                            $alloperactionexps = $alloperactionexps->format(
                                                                                'Y/m/d ',
                                                                            );
                                                                        @endphp


                                                                        <td>{{ $alloperactionexps }}</td>
                                                                        {{-- <td>{{ $userName }}</td> --}}
                                                                        <td>{{ $alloperactionexp->person_approve }}</td>
                                                                        <td>{{ $alloperactionexp->cost }}</td>
                                                                        <td>{{ $alloperactionexp->description }}</td>
                                                                        <!--<td>{{ $alloperactionexp->rego }}</td>-->

                                                                        @php
                                                                            $regoId =
                                                                                DB::table('vehicals')
                                                                                    ->where(
                                                                                        'id',
                                                                                        $alloperactionexp->rego,
                                                                                    )
                                                                                    ->where('status', '1')
                                                                                    ->first()->rego ?? '';
                                                                        @endphp
                                                                        <td>{{ $regoId }}</td>


                                                                        @if (in_array('47', $arr))
                                                                            <td>
                                                                                <div class="g-2">
                                                                                    <a onclick="removeOperactionExpenses(this,'{{ $alloperactionexp->id }}')"
                                                                                        class="btn text-danger btn-sm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-original-title="Delete"><span
                                                                                            class="fe fe-trash-2 fs-14"></span></a>
                                                                                </div>
                                                                            </td>
                                                                        @endif
                                                                    </tr>



                                                                @empty
                                                                @endforelse


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- main_bx_dt -->
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
        $("#timePicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "H:i:s",
        });
    </script>



    <script>
        function getdata(select) {
            var typeId = select.value;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: "{{ route('get.rego') }}",
                data: {
                    typeId: typeId
                },
                success: function(data) {
                    if (data.success == 200) {
                        $('#appendRegoField').empty();
                        var html4 = '';
                        $.each(data.vehicleData, function(index, items) {
                            html4 += '<option value="">Choose one</option><option value="' + items.id +
                                '">' + items.rego + '</option>';
                        });
                        $('#appendRegoField').append(html4);


                    }
                }
            });
        }
    </script>

    <script>
        $('#saveExpense').on('submit', function(e) {
            e.preventDefault();
            var rowCount = $("#saveExpenseData tr").length;
            var countData = rowCount + 1;

            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('expense.sheet') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == 200) {
                        $("#firstcls1").hide();
                        $("#firstcls2").hide();
                        $("#firstcls3").hide();
                        $("#firstcls4").hide();

                        swal({
                            type: 'success',
                            title: 'Added!',
                            text: 'Expense Added Successfully',
                            timer: 1000
                        });

                        var rowHtml2 = `<tr>
                                                    <td>${countData}</td>
                                                    <td>${data.data.vehical_type}</td>
                                                    <td>${data.data.date}</td>
                                                    <td>${data.data.cost}</td>
                                                    <td>${data.data.description}</td>
                                                    <td>${data.data.rego}</td>

                                                    <td>
                                                        <div class="g-2">
                                                        <a onclick="removeRate(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>                                                        </div>
                                                    </td>
                                                </tr>`;

                        $("#saveExpenseData").append(rowHtml2);
                        $("#saveExpense")[0].reset();
                        location.reload(true);

                    }

                },
            });

        })
    </script>



    <script>
        $('#saveTollExpense').on('submit', function(e) {
            e.preventDefault();
            var rowCount = $("#tollexpense tr").length;
            var countData = rowCount + 1;




            var name = $.trim($('#first14').val());
            if (name === '') {
                $("#firstcls14").show();
                return false;
            } else {
                $("#firstcls14").hide();
            }

            var first16 = $.trim($('#first16').val());
            if (first16 === '') {
                $("#firstcls16").show();
                return false;
            } else {
                $("#firstcls16").hide();
            }

            var first17 = $.trim($('#first17').val());
            if (first17 === '') {
                $("#firstcls17").show();
                return false;
            } else {
                $("#firstcls17").hide();
            }




            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('expense.sheet') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == 200) {


                        $("#firstcls14").hide();
                        $("#firstcls16").hide();
                        $("#firstcls17").hide();


                        swal({
                            type: 'success',
                            title: 'Added!',
                            text: 'Toll Expenses Added Successfully',
                            timer: 1000
                        });
                        var rowHtml2 = `<tr>
                                                    <td>${countData}</td>
                                                    <td>${data.data.start_date}</td>
                                                    <td>${data.data.details}</td>
                                                    <td>${data.data.rego}</td>
                                                    <td>${data.data.vehicle_class}</td>
                                                    <td>${data.data.trip_cost}</td>
                                                    <td>${data.data.fleet_id}</td>
                                                    <td>${data.data.end_date}</td>
                                                    <td><a onclick="removeTotalExpenses(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>

                                                </tr>`;

                        $("#tollexpense").append(rowHtml2);
                        $("#saveTollExpense")[0].reset();
                        location.reload(true);
                    }

                },
            });

        })
    </script>





    <script>
        function removeGeneralExpenses(that, clientId) {
            var label = "General Expenses";
            swal({
                    title: "Are you sure?",
                    text: "Do you want to Delete!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, Cancel It",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delet.General.Exp') }}",
                            data: {
                                "clientId": clientId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                    type: 'success',
                                    title: 'Deleted!',
                                    text: 'General Expense Deleted',
                                    timer: 1000
                                });

                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }


                                window.setTimeout(function() {}, 1000);
                                location.reload();

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
        function removeTotalExpenses(that, clientId) {
            var label = "Expense";
            swal({
                    title: "Are you sure?",
                    text: "Do you want to Delete!",
                    {{-- type: "warning", --}}
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, Cancel It",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delet.Delet.Total.Exp') }}",
                            data: {
                                "clientId": clientId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                    type: 'success',
                                    title: 'Deleted!',
                                    text: 'Expense Deleted',
                                    timer: 1000
                                });

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
        $('#saveOperactionExpenses').on('submit', function(e) {
            e.preventDefault();
            var rowCount = $("#saveOperactionExp tr").length;
            var countData = rowCount + 1;
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('expense.sheet') }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == 200) {
                        swal({
                            type: 'success',
                            title: 'Added!',
                            text: 'Operation Expenses Added Successfully',
                            timer: 1000
                        });
                        var rowHtml2 = `<tr>
                                                    <td>${countData}</td>
                                                    <td>${data.data.vehical_type}</td>
                                                    <td>${data.data.date}</td>
                                                    <td>${data.data.person_approve}</td>
                                                    <td>${data.data.cost}</td>
                                                    <td>${data.data.description}</td>
                                                    <td>${data.data.rego}</td>
                                                    <td>
                                                        <div class="g-2">
                                                        <a onclick="removeOperactionExpenses(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                      </div>
                                                        </td>

                                                </tr>`;

                        $("#saveOperactionExp").append(rowHtml2);
                        $("#saveOperactionExpenses")[0].reset();
                        location.reload(true);
                    }

                },
            });

        })
    </script>




    <script>
        function removeOperactionExpenses(that, clientId) {
            var label = "OperactionExpenses";
            swal({
                    title: "Are you sure?",
                    text: "Do you want to Delete!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, Cancel It",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('delet.Delet.opeaaction') }}",
                            data: {
                                "clientId": clientId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                    type: 'success',
                                    title: 'Deleted!',
                                    text: 'Address Deleted',
                                    timer: 1000
                                });

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
        document.getElementById('exportBtn1').addEventListener('click', function() {
            exportToExcel('custom_table');
        });

        function exportToExcel(tableId) {
            const table = document.getElementById(tableId);
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            const filename = 'general-expense.xlsx';
            XLSX.writeFile(wb, filename);
        }
    </script>


    <script>
        document.getElementById('exportBtn2').addEventListener('click', function() {
            exportToExcel('custom_table');
        });

        function exportToExcel(tableId) {
            const table = document.getElementById(tableId);
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            const filename = 'toll-expense.xlsx';
            XLSX.writeFile(wb, filename);
        }
    </script>


    <script>
        document.getElementById('exportBtn3').addEventListener('click', function() {
            exportToExcel('custom_table');
        });

        function exportToExcel(tableId) {
            const table = document.getElementById(tableId);
            const ws = XLSX.utils.table_to_sheet(table);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            const filename = 'operaction-expense.xlsx';
            XLSX.writeFile(wb, filename);
        }
    </script>


    <script>
        $(document).ready(function() {
            var table = $('#custom_table2').DataTable({
                dom: '<"top"lf><"middle"rt><"bottom"Bip>',
                buttons: [],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "paging": true,
                "searching": true,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });

            var columns = table.columns().header().toArray();

            var columnVisibilityDropdown =
                '<div class="dropdown colum_visibility_ak" style="display:inline-block;">' +
                '<button class="btn btn-warning dropdown-toggle" type="button" id="columnVisibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">Column Visibility</button>' +
                '<div class="dropdown-menu custom_dp_menu" aria-labelledby="columnVisibilityDropdown">';

            columns.forEach(function(column, index) {
                columnVisibilityDropdown +=
                    '<div class="form-check"><input class="form-check-input column-toggle" type="checkbox" value="' +
                    $(column).text() + '" id="Checkme' + index +
                    '" checked><label class="form-check-label" for="Checkme' + index + '">' + $(column)
                    .text() + '</label></div>';
            });

            columnVisibilityDropdown += '</div></div>';

            $('.dataTables_length').parent().append(columnVisibilityDropdown);

            table.buttons().container().appendTo($('.dataTables_length').parent());

            $('.column-toggle').on('change', function() {
                var columnIndex = $(this).parent().index();
                table.column(columnIndex).visible(this.checked);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#custom_table3').DataTable({
                dom: '<"top"lf><"middle"rt><"bottom"Bip>',
                buttons: [],
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "paging": true,
                "searching": true,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });

            var columns = table.columns().header().toArray();

            var columnVisibilityDropdown =
                '<div class="dropdown colum_visibility_ak" style="display:inline-block;">' +
                '<button class="btn btn-warning dropdown-toggle" type="button" id="columnVisibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">Column Visibility</button>' +
                '<div class="dropdown-menu custom_dp_menu" aria-labelledby="columnVisibilityDropdown">';

            columns.forEach(function(column, index) {
                columnVisibilityDropdown +=
                    '<div class="form-check"><input class="form-check-input column-toggle" type="checkbox" value="' +
                    $(column).text() + '" id="Checkme' + index +
                    '" checked><label class="form-check-label" for="Checkme' + index + '">' + $(column)
                    .text() + '</label></div>';
            });

            columnVisibilityDropdown += '</div></div>';

            $('.dataTables_length').parent().append(columnVisibilityDropdown);

            table.buttons().container().appendTo($('.dataTables_length').parent());

            $('.column-toggle').on('change', function() {
                var columnIndex = $(this).parent().index();
                table.column(columnIndex).visible(this.checked);
            });
        });
    </script>




    {{-- @endcan --}}
@endsection
