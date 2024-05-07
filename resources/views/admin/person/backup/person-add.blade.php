@extends('admin.layout')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


 <!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Add Person</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
            <li class="breadcrumb-item active" aria-current="page">Person</li>

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
                        <li class="nav-item">
                            <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span><i class="ti-light-bulb"></i></span>
                                <span> Basic Information</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="clickMenu()" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                <span><i class="ti-agenda"></i></span>
                                <span> Address</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="clickMenu()" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span><i class="ti-calendar"></i></span>
                                <span>Reminders </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="clickMenu()"  data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span><i class="fe fe-dollar-sign"></i></span>
                                <span>Rate </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a onclick="clickMenu()"  data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span><i class="ti-id-badge"></i></span>
                                <span>Document</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content  text-muted">
                        <div class="tab-pane show active" id="home">

                       <form action="{{ route('person.add') }}" autocomplete="nope"  method="post"> @csrf
                           <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">

                                                <label class="form-label" for="exampleInputEmail1">Name <span class="red">*</span></label>
                                                <input type="text" class="form-control" name="name"  autocomplete="off" value="{{ old('name') }}" placeholder=""  required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Surname</label>
                                                <input type="text" class="form-control" name="surname" autocomplete="off" value="{{ old('surname') }}"   placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Email <span class="red">*</span></label>
                                                <input type="text" class="form-control" name="email" autocomplete="off" value="{{ old('email') }}"   placeholder="" required>

                                                       @if($errors->has('email'))
                                                             <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
                                                        @endif


                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Date Of Birth</label>

                                                <input type="text" name="dob" min="1000-01-01T00:00" max="9999-12-31T23:59" class="form-control persononlydate"  placeholder=""/>


                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Phone Principal <span class="red">*</span></label>

                                                <input  class="form-control" name="phoneprinciple"  min="0"   autocomplete="off" value="{{ old('phoneprinciple') }}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                type = "number" maxlength="12" placeholder=""  required>

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Phone Aux</label>
                                                <input  class="form-control" name="phoneaux" min="0"   autocomplete="off" value="{{ old('phoneaux') }}"   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                type = "number"
                                                maxlength = "12" placeholder="" >


                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">TFN</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="tfn" autocomplete="off" autocomplete="off" value="{{ old('tfn') }}" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">ABN</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" name="abn" autocomplete="off" value="{{ old('abn') }}" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>


                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Password <span class="red">*</span></label>
                                                <input type="password" class="form-control" id="exampleInputEmail1" autocomplete="off" name="password" aria-describedby="emailHelp" placeholder="" required>
                                            </div>
                                        </div>

                                         <div class="col-lg-4">
                                            <div class="check_box">
                                                <label class="form-label">Select Role <span class="red">*</span></label>
                                                <div class="form-group">
                                                   <select class="form-control select2 form-select" name="roles" data-placeholder="Choose one" required>
                                                     <option value="">Select any one</option>
                                                    @foreach ($roles as $allrole)
                                                    <option autocomplete="off" value="{{$allrole->id}}" {{ old('roles') == $allrole->id ? "selected" : "" }}>{{$allrole->name}}</option>
                                                    @endforeach

                                                       </select>
                                               </div>
                                            </div>
                                        </div>



                                        {{-- <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Is this Person a Internal Staff or Person?</label>
                                                <div class="checkbox_flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Staff" name="selectPersion" id="autoSizingCheck1a" {{ old('Staff') == "Staff" ? "checked" : "" }}>
                                                    <label class="form-check-label" for="autoSizingCheck1a">
                                                    Staff
                                                        </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Person" name="selectPersion" id="autoSizingCheck1b" {{ old('Staff') == "Person" ? "checked" : "" }}>
                                                    <label class="form-check-label" for="autoSizingCheck1b">
                                                    Person
                                                        </label>
                                                </div>
                                                </div>

                                            </div>
                                        </div> --}}

                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <button type="submit" value="Submit" class="btn btn-primary"><i class="bi bi-save"></i> Save And Next</button>
                                               <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                            <!-- main_bx_dt -->
                        </div>
                        <div class="tab-pane " id="profile">
                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                            <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Zip Code</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Unit</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Address Number</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Street Address</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Suburb</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">City</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">State</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="add_address text-end">
                                                <a href="#" class="theme_btn btn btn-primary " id="add_address_btn">+ Add Address</a>
                                                <!-- <a href="#" class="theme_btn btn btn-primary"><i class="bi-arrow-repeat"></i> Reset</a> -->
                                            </div>
                                        </div>
                                    <div class="col-lg-12 mt-4">
                                    <div class="table-responsive">
                                            <table  class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>

                                                        <th class="bg-transparent border-bottom-0">Zip Code</th>
                                                        <th class="bg-transparent border-bottom-0">Unit</th>
                                                        <th class="bg-transparent border-bottom-0">Address Number</th>
                                                        <th class="bg-transparent border-bottom-0">Street Address</th>
                                                        <th class="bg-transparent border-bottom-0">Suburb</th>
                                                        <th class="bg-transparent border-bottom-0">City</th>
                                                        <th class="bg-transparent border-bottom-0">State</th>


                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">

                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                        <td>
                                                            <div class="g-2">
                                                                <a class="btn text-primary btn-sm"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Edit"><span
                                                                        class="fe fe-edit fs-14"></span></a>
                                                                <a class="btn text-danger btn-sm"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Delete"><span
                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
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
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row align-items-center">
                                                <div class="col-lg-4">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Email Reminder Type</label>
                                                        <div class="form-group">

                                                        <select class="form-control select2 form-select" data-placeholder="Choose one">
                                                                <option value="1">Email Rego Due</option>
                                                                <option value="2">Email Service Due</option>
                                                                <option value="2">Email Inspection Due</option>

                                                            </select>
                                                    </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="search_btn">
                                                    <a href="#" class="btn btn-primary srch_btn">+ Add Type</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                    <div class="table-responsive">
                                            <table  class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>

                                                        <th class="bg-transparent border-bottom-0">Email Reminder Type</th>
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">

                                                       <td></td>
                                                        <td>
                                                            <div class="g-2">

                                                                <a class="btn text-danger btn-sm"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Delete"><span
                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- main_bx_dt -->
                        </div>


                        <div class="tab-pane email_template" id="document">
                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row align-items-center">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Name</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>
                                        <div class="col-lg-6">
                                        <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Status</label>

                                            <select class="form-control select2 form-select" data-placeholder="Choose one">
                                                    <option value="1">Active</option>
                                                    <option value="2">Inactive</option>

                                                </select>
                                        </div>
                                        </div>
                                                <div class="col-lg-12">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Email Reminder Type</label>
                                                        <div class="form-group">
                                                          <input name="file1" type="file" class="dropify" data-height="100" />
                                                        </div>
                                                    </div>

                                                    </div>
                                                    <div class="col-lg-12 mb-5">
                                                    <div class="search_btn text-end">
                                                    <a href="#" class="btn btn-primary srch_btn">+ Add Document</a>

                                                    </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                    <div class="table-responsive">
                                            <table id="basic-datatable" class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>

                                                        <th class="bg-transparent border-bottom-0">Person</th>
                                                        <th class="bg-transparent border-bottom-0">Doc</th>
                                                        <th class="bg-transparent border-bottom-0">Expire</th>
                                                        <th class="bg-transparent border-bottom-0">Situation</th>
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">
                                                    <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                        <td>
                                                            <div class="g-2">

                                                                <a class="btn text-danger btn-sm"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Delete"><span
                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane email_template" id="vehicle">
                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row align-items-center">
                                            <div class="col-lg-12">
                                            <div class="title_head">
                                                <h4>Monetize Info</h4>
                                            </div>
                                        </div>
                                                <div class="col-lg-3">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Type</label>
                                                        <div class="form-group">

                                                        <select class="form-control select2 form-select" data-placeholder="Choose one">
                                                                <option value="1">HOSPITAL</option>
                                                                <option value="2">MOTOR BIKE</option>
                                                                <option value="3">OWN CAR</option>
                                                                <option value="2">OWN CAR NIGHT SHIFT</option>
                                                                <option value="2">OWN UTE</option>
                                                                <option value="2">PUSH BIKE</option>
                                                                <option value="2">T1 REFRIGERATED VAN</option>
                                                                <option value="2">T1 VAN</option>
                                                                <option value="2">T1 VAN STAFF</option>
                                                                <option value="2">T2 VAN</option>
                                                                <option value="2">T3 VAN</option>
                                                                <option value="2">T4 TRUCK</option>
                                                                <option value="2">TRAINING DAY</option>
                                                                <option value="2">UTE</option>
                                                                <option value="2">WAREHOUSE</option>
                                                            </select>
                                                    </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Day</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Night</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Saturday</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Sunday</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Extra Hourly Rate</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="search_btn text-end">
                                                    <a href="#" class="btn btn-primary srch_btn">+ Add Rate</a>
                                                    <a href="#" class="btn btn-info srch_btn"><i class="fe fe-rotate-ccw"></i> Reset</a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-lg-12 mt-5">
                                    <div class="table-responsive">
                                            <table  class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>

                                                        <th class="bg-transparent border-bottom-0">Vehicle Type</th>
                                                        <!-- <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Day</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Night</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Saturday</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Sunday</th> -->
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Day</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Night</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Saturday</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Sunday
</th>

                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border-bottom">

                                                       <td></td>
                                                       <!-- <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td> -->
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                       <td></td>
                                                        <td>
                                                            <div class="g-2">

                                                                <a class="btn text-danger btn-sm"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Delete"><span
                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- main_bx_dt -->
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



<script>
  function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    let month = today.getMonth() + 1;
    let day = today.getDate();

    // Add leading zeros to month and day if needed
    month = month < 10 ? `0${month}` : month;
    day = day < 10 ? `0${day}` : day;

    return `${year}-${month}-${day}`;
  }
  document.getElementById("datePicker").setAttribute("max", getCurrentDate());

    function clickMenu()
    {

        // $('.tab-pane:first').addClass('show active');

        Swal.fire({
            title: 'Error',
            text: 'Please Save Basic Information',
            icon: 'error',
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                // Replace 'YOUR_CUSTOM_URL' with your actual URL
                window.location.href = '{{ route('person.add') }}';
            }
        });
    }

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<script>
    $(".datetime_picker").flatpickr({
         enableTime: true,
         altFormat: "Y-m-d H:i",
         dateFormat: "Y-m-d H:i",
         time_24hr: true
      });

      $(".onlydate").flatpickr({
         enableTime: true,
         altFormat: "Y-m-d",
         dateFormat: "Y-m-d",
      });

   </script>

@endsection
