@extends('admin.layout')
@section('content')

<style>
.dataTables_empty{
    display: none;
}

.light-mode .btn.text-danger {
    background: #e82646!important;
}
</style>

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Add Client</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clients') }}">Clients</a></li>
            <li class="breadcrumb-item active" aria-current="page">Client Add</li>

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
                            <a id="homeTab" href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span><i class="ti-light-bulb"></i></span>
                                <span> Basic Information</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a id="profileTab" href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                            <span><i class="ti-agenda"></i></span>
                            <span> Address</span>
                            </a>
                         </li>


                         <li class="nav-item">
                            <a id="messagesTab" href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            <span><i class="fe fe-dollar-sign"></i></span>
                            <span>Rate </span>
                            </a>
                         </li>


                         <li class="nav-item">
                            <a id="documentTab" href="#document" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            <span><i class="ti-id-badge"></i></span>
                            <span>Cost Centers</span>
                            </a>
                         </li>

                         <li class="nav-item">
                             <a id="clientBaseTab" href="#clientBase" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                             <span><i class="fe fe-dollar-sign"></i></span>
                             <span>Base</span>
                             </a>
                          </li>

                    </ul>
                </div>

                <div class="card-body">
                    <form action="{{ route('add.client') }}" id="myForm" method="post"> @csrf
                      <div class="tab-content  text-muted">
                        <div class="tab-pane show active" id="home">
                            <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Name <span class="red">*</span></label>
                                                <input type="text" class="form-control"  name="name" id="clientName"  autocomplete="off" placeholder="" required>
                                                <input type="hidden" name="hiddenValue" value="1"/>
                                                <span id="nameError" class="text-danger"></span>

                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Short Name <span class="red">*</span></label>
                                                <input type="text" class="form-control"  name="shortName"  autocomplete="off" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">ACN</label>
                                                <input type="text" class="form-control"  name="acn"  autocomplete="off" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">ABN</label>
                                                <input type="text" class="form-control"  name="abn"  autocomplete="off" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">State <span class="red">*</span></label>
                                                <div class="form-group">

                                            <select class="form-control select2 form-select" name="state"  onchange="changeStatus(this.value)" required>
                                                 @foreach ($getStates as $allgetStates)
                                                 <option value="{{ $allgetStates->id }}">{{ $allgetStates->name }}</option>
                                                 @endforeach
                                            </select>
                                            <span id="ErrorMessage" class="text-danger"></span>

                                       </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Phone Principal <span class="red">*</span></label>
                                                <input type="number" min="0" class="form-control" name="phonePrinciple" maxlength="13" autocomplete="off" aria-describedby="emailHelp" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Mobile Phone <span class="red">*</span></label>
                                                <input type="number" min="0" class="form-control" name="mobilePhone" maxlength="13" autocomplete="off" aria-describedby="emailHelp" placeholder="" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Phone Aux</label>
                                                <input type="text" class="form-control" name="phomneAux" autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Fax Phone</label>
                                                <input type="text" class="form-control" name="faxPhone" autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Website</label>
                                                <input type="text" class="form-control" name="website" autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                            <label class="form-label" for="exampleInputEmail1">Notes</label>
                                            <textarea class="form-control mb-4" name="notes"  rows="4"></textarea>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                            </div>

                           <!-- main_bx_dt -->
                        </div>

                        <script>
                            function changeStatus(statusValue)
                            {
                                if (!pagrLoaded) {
                                            var clientName=$('#clientName').val();
                                            $.ajaxSetup({
                                                    headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                    });

                                            $.ajax({
                                                    type:'POST',
                                                    url:"{{ route('admin.client.validate.state') }}",
                                                    data:{clientId:clientName,state:statusValue},
                                                    success:function(data){
                                                        if (data.status==200) {
                                                            $("#ErrorMessage").text("Client Already exist...");
                                                        }
                                                        if (data.status==400) {
                                                            $("#ErrorMessage").hide();
                                                        }
                                                    }
                                                    });
                                }
                            }
                        </script>

                        <div class="tab-pane " id="profile">
                           <div class="main_bx_dt__">

                                  <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                            <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Zip Code</label>
                                                <input type="text" class="form-control" id="zipCode" autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                                    <span id="zipCodeError" class="text-danger" hidden>This field is required.</span>
                                                    @error('zipCode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Unit</label>
                                                <input type="text" class="form-control"  id="unit" autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                                    <span id="unitError" class="text-danger" hidden>This field is required.</span>
                                                    @error('unit')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Address Number</label>
                                                <input type="text" class="form-control" id="addressNumber"  autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                                    <span id="addressNumberError" class="text-danger" hidden>This field is required.</span>
                                                    @error('addressNumber')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Street Address</label>
                                                <input type="text" class="form-control" id="streetAddress" autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                                <span id="streetAddressError" class="text-danger" hidden>This field is required.</span>
                                                @error('streetAddress')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Suburb</label>
                                                <input type="text" class="form-control"  id="suburb"  autocomplete="off" aria-describedby="emailHelp" placeholder="">
                                                <span id="suburbError" class="text-danger" hidden>This field is required.</span>
                                                @error('suburb')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">City</label>
                                                <input type="text" class="form-control"  id="city" aria-describedby="emailHelp" placeholder="">
                                                <span id="cityError" class="text-danger" hidden>This field is required.</span>
                                                @error('city')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">State</label>
                                                <input type="text" class="form-control" id="stateId" aria-describedby="emailHelp" placeholder="">
                                                <span id="stateIdError" class="text-danger" hidden>This field is required.</span>
                                                @error('statsse')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="add_address text-end">
                                                <button type="button" onclick="addNewAddress()" class="theme_btn btn btn-primary" id="add_address_btn">+ Add Address</button>
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
                                                        <th class="bg-transparent border-bottom-0">City </th>
                                                        <th class="bg-transparent border-bottom-0">State</th>
                                                        <th class="bg-transparent border-bottom-0">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody id="addNewAppendAddress">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </form>






                            </div>
                            <!-- main_bx_dt -->

                        </div>

                        <div class="tab-pane email_template" id="messages">
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
                                                            <select class="form-control select2 form-select"  id="selectTypeValue" data-placeholder="Choose one">
                                                                <option value=""></option>
                                                                @foreach ($types as $alltypes)
                                                                <option value="{{ $alltypes->name}}">{{ $alltypes->name }}</option>
                                                                @endforeach
                                                             </select>
                                                             <span id="selectTypeId" class="text-danger" hidden>This field is required.</span>
                                                             @error('hourlyRate')
                                                                 <span class="text-danger">{{ $message }}</span>
                                                             @enderror
                                                    </div>
                                                    </div>
                                                </div>


                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Day</label>
                                                       <input type="number" min="0"  class="form-control thirdcls"  id="hourlyRate"  step="any"  placeholder="">
                                                           <span id="hourlyRateError" class="text-danger" hidden>This field is required.</span>
                                                            @error('hourlyRate')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Night</label>
                                                       <input type="number" min="0"  class="form-control thirdcls " id="hourlyRateChargeable" aria-describedby="emailHelp" placeholder="">
                                                       <span id="hourlyRateChargeableError" class="text-danger" hidden>This field is required.</span>
                                                        @error('city')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror

                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Saturday</label>
                                                       <input type="number" min="0" class="form-control thirdcls" id="HourlyRateChargeableSaturday" aria-describedby="emailHelp" placeholder="">
                                                       <span id="HourlyRateChargeableSaturdayError" class="text-danger" hidden>This field is required.</span>
                                                       @error('city')
                                                           <span class="text-danger">{{ $message }}</span>
                                                       @enderror
                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Sunday</label>
                                                       <input type="number" min="0"  class="form-control thirdcls"  id="HourlyRateChargeableSunday" aria-describedby="emailHelp" placeholder="">
                                                       <span id="HourlyRateChargeableSundayError" class="text-danger" hidden>This field is required.</span>
                                                        @error('city')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Day</label>
                                                        <input type="number" min="0" class="form-control secondcls"  id="HourlyRatePayableDay" aria-describedby="emailHelp" placeholder="">
                                                        <span id="HourlyRatePayableDayError" class="text-danger" hidden>This field is required.</span>
                                                        @error('city')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Night</label>
                                                       <input type="number" min="0" class="form-control secondcls" id="HourlyRatePayableNight" aria-describedby="emailHelp" placeholder="">
                                                       <span id="HourlyRatePayableNightError" class="text-danger" hidden>This field is required.</span>
                                                        @error('city')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Saturday</label>
                                                       <input type="number" min="0" class="form-control secondcls" id="HourlyRatePayableSaturday" aria-describedby="emailHelp" placeholder="">
                                                       <span id="HourlyRatePayableSaturdayError" class="text-danger" hidden>This field is required.</span>
                                                       @error('city')
                                                           <span class="text-danger">{{ $message }}</span>
                                                       @enderror
                                                    </div>
                                                 </div>
                                                 <div class="col-lg-3">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Sunday</label>
                                                       <input type="number" min="0"  class="form-control secondcls"  id="HourlyRatePayableSunday" aria-describedby="emailHelp" placeholder="">
                                                       <span id="HourlyRatePayableSundayError" class="text-danger" hidden>This field is required.</span>
                                                        @error('city')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                     </div>
                                                 </div>

                                                <div class="col-lg-12">
                                                    <div class="search_btn text-end">
                                                        <button type="button" onclick="addNewRate()" class="theme_btn btn btn-primary" id="add_address_btn">+ Save</button>

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
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Day</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Night</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Saturday</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Sunday</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Day</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Night</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Saturday</th>
                                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Sunday
</th>

                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="addNewAppendRate">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>

                            </div>
                            <!-- main_bx_dt -->
                        </div>


                        <script>
                            const numericInput1 = document.getElementById('hourlyRate');
                            const numericInput2 = document.getElementById('hourlyRateChargeable');
                            const numericInput3 = document.getElementById('HourlyRateChargeableSaturday');
                            const numericInput4 = document.getElementById('HourlyRateChargeableSunday');
                            const numericInput5 = document.getElementById('HourlyRatePayableDay');
                            const numericInput6 = document.getElementById('hourlyRateChargeable');
                            const numericInput7 = document.getElementById('HourlyRatePayableNight');
                            const numericInput8 = document.getElementById('HourlyRatePayableSaturday');
                            const numericInput9 = document.getElementById('HourlyRatePayableSunday');

                            numericInput1.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });
                            numericInput2.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput3.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput4.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput5.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput6.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput7.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput8.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });

                            numericInput9.addEventListener('keydown', function(event) {
                                // Block 'e' key press
                                if (event.key === 'e' || event.key === 'E') {
                                    event.preventDefault();
                                }
                            });
                        </script>


                        <div class="tab-pane email_template" id="document">
                            <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row align-items-center">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Name <span class="red">*</span></label>
                                                    <input type="text" class="form-control"  id="CostCenterName" aria-describedby="emailHelp" placeholder="">
                                                    <span id="CostCenterNameError" class="text-danger" hidden>This field is required.</span>
                                                    <span id="cleintBaseEr"  class="text-danger" hidden>This Cost Center is already exist</span>

                                                    @error('CostCenterName')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>



                                                    <div class="col-lg-12 mb-5">
                                                    <div class="search_btn text-start">
                                                    <button type="button" onclick="addNewCost()" class="theme_btn btn btn-primary" id="add_address_btn">+ Add Cost</button>

                                                    </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table  class="table table-bordered text-nowrap mb-0">
                                            <thead class="border-top">
                                                    <tr>
                                                        <th class="bg-transparent border-bottom-0">Name</th>
                                                        {{-- <th class="bg-transparent border-bottom-0">Location</th> --}}
                                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="newCostAppend">


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    </div>
                                </div>

                                {{-- <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <!-- main_bx_dt -->



                            <div class="tab-pane " id="clientBase">
                                <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                       <div class="row">
                                          <div class="col-lg-12">


                                             <form id="clientBaseForm" method="post">

                                                {{-- <input type="hidden" name="clientId"  value="{{ $clientId }}"/> --}}
                                                <div class="row align-items-center">


                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                           <label class="form-label" for="exampleInputEmail1">Cost Center <span class="red">*</span></label>
                                                           <select class="form-control select2 form-select"  id="addCostCenterName" data-placeholder="Choose one">

                                                           </select>

                                                           <span id="costCenterNameIds" class="text-danger" hidden>This field is required.</span>

                                                           @error('costCenterNameError')
                                                               <span class="text-danger">{{ $message }}</span>
                                                           @enderror
                                                        </div>
                                                     </div>

                                                    <div class="col-lg-6">
                                                      <div class="mb-3">
                                                         <label class="form-label" for="exampleInputEmail1">Base <span class="red">*</span></label>
                                                         <input type="text" class="form-control"  id="clientBaseId" aria-describedby="emailHelp" placeholder="">

                                                         <span id="clientBaseId" class="text-danger" hidden>This field is required.</span>
                                                         <span id="BaseErrr"  class="text-danger" hidden>This Base is already exist</span>

                                                         @error('clientBaseErrrror')
                                                             <span class="text-danger">{{ $message }}</span>
                                                         @enderror

                                                      </div>
                                                   </div>

                                                   <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Location <span class="red">*</span></label>
                                                        <input type="text" class="form-control"  id="CostCenterLocation" aria-describedby="emailHelp" placeholder="">
                                                        <span id="CostCenterLocationError" class="text-danger" hidden>This field is required.</span>
                                                        @error('CostCenterLocationError')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                   <br>
                                                   <div class="add_address text-end">
                                                    <button type="button" onclick="addNewBase()" class="theme_btn btn btn-primary" id="add_address_btn">+ Add Base</button>
                                                 </div>
                                                 <br>

                                                 <br><br>
                                                </div>
                                             </form>
                                          </div>
                                       </div>



                                       <div class="col-lg-12">
                                          <div class="table-responsive">
                                            <table class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                   <tr>
                                                      {{-- <th class="bg-transparent border-bottom-0">#</th> --}}
                                                      <th class="bg-transparent border-bottom-0">Cost Center</th>
                                                      <th class="bg-transparent border-bottom-0">Client Base</th>
                                                      <th class="bg-transparent border-bottom-0">Location</th>
                                                      <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                                   </tr>
                                                </thead>

                                                <tbody id="clientBaseAppend">
                                                   {{-- @foreach ($clientbase as $key=>$allclientbase)
                                                   <tr class="border-bottom">
                                                      <td>
                                                         {{ $key+1 }}
                                                      </td>
                                                      <td>{{ $allclientbase->base}}</td>
                                                      <td>{{ $allclientbase->cost_center_name}}</td>

                                                      <td>
                                                          <a onclick="removeBase(this,'{{$allclientbase->id}}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                      </td>


                                                   </tr>
                                                   @endforeach --}}
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="bottom_footer_dt">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="action_btns text-end">
                                            <button type="submit" value="Submit" class="btn btn-primary"><i class="bi bi-save"></i> Save And Next</button>
                                        </div>
                                    </div>
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
</div>
</div>

<script>

function validateForm(validateForm) {
        let isValid = true;
        // Check each required input field for validation
        $('#myForm [required]').each(function () {
            if (!$(this).val() || ($(this).is('select') && ($(this).val() == "" || $(this).val() == 0))) {
                console.log($(this));
                isValid = false;
                $(this).addClass('is-invalid');
                $('#' + $(this).closest('.tab-pane').attr('id') + 'Tab').tab('show');
                $(this).focus();
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        if (isValid) {
            $(`#${validateForm}`).submit();
        }
    }

    function clickMenu()
    {
    swal({
           type:'error',
           title: 'Error!',
           text: 'Please Save Basic Information',
           timer:3000
       });
     };



function addNewAddress()
     {
    let zipCode   = $("#zipCode").val();
    let unit      = $("#unit").val();
    let addressNumber = $("#addressNumber").val();
    let streetAddress = $("#streetAddress").val();
    let suburb = $("#suburb").val();
    let city = $("#city").val();
    let stateId = $("#stateId").val();

    let isValid = 1;
     if(zipCode.trim() == ''){
        $("#zipCodeError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#zipCodeError").attr('hidden',true);
    }

     if(unit.trim() == ''){
        $("#unitError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#unitError").attr('hidden',true);
    }


     if(addressNumber.trim() == ''){
        $("#addressNumberError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#addressNumberError").attr('hidden',true);
    }


     if(streetAddress.trim() == ''){
        $("#streetAddressError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#streetAddressError").attr('hidden',true);
    }


    if(suburb.trim() == ''){
        $("#suburbError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#suburbError").attr('hidden',true);
    }

    if(city.trim() == ''){
        $("#cityError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#cityError").attr('hidden',true);
    }

    if(stateId.trim() == ''){
        $("#stateIdError").attr('hidden',false);
        isValid =0;
    }
    else{
        $("#stateIdError").attr('hidden',true);
    }

    if(isValid)
     {
        let microtime = Date.now();
        let addressHtml = `<tr id="address${microtime}">
                                    <td hidden>
                                        <input name="zipCode[]" hidden value="${zipCode}">
                                        <input name="unit[]" hidden value="${unit}">
                                        <input name="addressNumber[]" hidden value="${addressNumber}">
                                        <input name="streetAddress[]" hidden value="${streetAddress}">
                                        <input name="suburb[]" hidden value="${suburb}">
                                        <input name="city[]" hidden value="${city}">
                                        <input name="stateId[]" hidden value="${stateId}">
                                    </td>
                                    <td>
                                        ${zipCode}
                                    </td>
                                    <td>
                                        ${unit}
                                    </td>
                                    <td>
                                    ${addressNumber}
                                   </td>
                                    <td>
                                        ${streetAddress}
                                    </td>
                                    <td>
                                        ${suburb}
                                    </td>

                                    <td>
                                        ${city}
                                    </td>
                                    <td>
                                        ${stateId}
                                    </td>
                                    <td> <button class="btn text-danger btn-sm" style="border: none; background: none;" type="button" onclick="deleteTabletr('address${microtime}')"><span class="fe fe-trash-2 fs-14"></span></button></td>

                            </tr>`;
        $("#addNewAppendAddress").append(addressHtml);
        $("#zipCode").val('');
        $("#unit").val('');
        $("#addressNumber").val('');
        $("#streetAddress").val('');
        $("#suburb").val('');
        $("#city").val('');
        $("#stateId").val('');
     }
  }


    function addNewRate()
     {

    let hourlyRate   = $("#hourlyRate").val();
    let hourlyRateChargeable      = $("#hourlyRateChargeable").val();
    let HourlyRateChargeableSaturday = $("#HourlyRateChargeableSaturday").val();
    let HourlyRateChargeableSunday = $("#HourlyRateChargeableSunday").val();
    let HourlyRatePayableDay = $("#HourlyRatePayableDay").val();
    let HourlyRatePayableNight = $("#HourlyRatePayableNight").val();
    let HourlyRatePayableSaturday = $("#HourlyRatePayableSaturday").val();
    let HourlyRatePayableSunday = $("#HourlyRatePayableSunday").val();

    var selectType= document.getElementById('selectTypeValue').value;
    if(selectType == ''){
            $("#selectTypeId").attr('hidden',false);
            return false;
        }
        else{
            $("#selectTypeId").attr('hidden',true);
        }




     if(hourlyRate.trim() == ''){
        $("#hourlyRateError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#hourlyRateError").attr('hidden',true);
    }

     if(hourlyRateChargeable.trim() == ''){
        $("#hourlyRateChargeableError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#hourlyRateChargeableError").attr('hidden',true);
    }


     if(HourlyRateChargeableSaturday.trim() == ''){
        $("#HourlyRateChargeableSaturdayError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#HourlyRateChargeableSaturdayError").attr('hidden',true);
    }

     if(HourlyRateChargeableSunday.trim() == ''){
        $("#HourlyRateChargeableSundayError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#HourlyRateChargeableSundayError").attr('hidden',true);
    }

    if(HourlyRatePayableDay.trim() == ''){
        $("#HourlyRatePayableDayError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#HourlyRatePayableDayError").attr('hidden',true);
    }

    if(HourlyRatePayableNight.trim() == ''){
        $("#HourlyRatePayableNightError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#HourlyRatePayableNightError").attr('hidden',true);
    }

    if(HourlyRatePayableSaturday.trim() == ''){
        $("#HourlyRatePayableSaturdayError").attr('hidden',false);
        isValid =0;
        return false;
    }
    else{
        $("#HourlyRatePayableSaturdayError").attr('hidden',true);
    }

    if(HourlyRatePayableSunday.trim() == ''){
        $("#HourlyRatePayableSundayError").attr('hidden',false);
        isValid =0;
        return false;
    }else{
        $("#HourlyRatePayableSundayError").attr('hidden',true);
    }
        let microtime = Date.now();
        let addressHtml = `<tr id="address${microtime}">
                                    <td hidden>
                                        <input name="selectType[]" hidden value="${selectType}">
                                        <input name="hourlyRate[]" hidden value="${hourlyRate}">
                                        <input name="hourlyRateChargeable[]" hidden value="${hourlyRateChargeable}">
                                        <input name="HourlyRateChargeableSaturday[]" hidden value="${HourlyRateChargeableSaturday}">
                                        <input name="HourlyRateChargeableSunday[]" hidden value="${HourlyRateChargeableSunday}">
                                        <input name="HourlyRatePayableDay[]" hidden value="${HourlyRatePayableDay}">
                                        <input name="HourlyRatePayableNight[]" hidden value="${HourlyRatePayableNight}">
                                        <input name="HourlyRatePayableSaturday[]" hidden value="${HourlyRatePayableSaturday}">
                                        <input name="HourlyRatePayableSunday[]" hidden value="${HourlyRatePayableSunday}">
                                    </td>
                                    <td>
                                        ${selectType}
                                    </td>
                                    <td>
                                        ${hourlyRate}
                                    </td>
                                    <td>
                                        ${hourlyRateChargeable}
                                    </td>
                                    <td>
                                    ${HourlyRateChargeableSaturday}
                                   </td>
                                    <td>
                                        ${HourlyRateChargeableSunday}
                                    </td>
                                    <td>
                                        ${HourlyRatePayableDay}
                                    </td>
                                    <td>
                                        ${HourlyRatePayableNight}
                                    </td>
                                    <td>
                                        ${HourlyRatePayableSaturday}
                                    </td>
                                    <td>
                                        ${HourlyRatePayableSunday}
                                    </td>
                                    <td> <button class="btn text-danger btn-sm" style="border: none; background: none;" type="button" onclick="deleteTabletr('address${microtime}')"><span class="fe fe-trash-2 fs-14"></span></button></td>

                            </tr>`;
        $("#addNewAppendRate").append(addressHtml);
        $('#selectTypeValue').val('').trigger('change');

        resetAddress();
  }


  function addNewCost()
     {
            let CostCenterName   = $("#CostCenterName").val();
          //  let CostCenterLocation      = $("#CostCenterLocation").val();

            if(CostCenterName.trim() == ''){
                $("#CostCenterNameError").attr('hidden',false);
                isValid =0;
            }
                let microtime = Date.now();

        if (isValueExists(CostCenterName)) {
            // Show the error message
            document.getElementById("cleintBaseEr").removeAttribute("hidden");
        } else {
            // Hide the error message
            document.getElementById("cleintBaseEr").setAttribute("hidden", "true");

            // Add a new row to the table
            let microtime = Date.now();
            let addressHtml = `
                <tr id="address${microtime}">
                    <td hidden>
                        <input name="CostCenterName1[]" hidden value="${CostCenterName}">
                    </td>
                    <td>
                        ${CostCenterName}
                    </td>
                    <td>
                        <button class="btn text-danger btn-sm" style="border: none; background: none;" type="button" data-bs-toggle="tooltip" onclick="deleteTabletr('address${microtime}')">
                            <span class="fe fe-trash-2 fs-14"></span>
                        </button>
                    </td>
                </tr>`;

                $("#newCostAppend").append(addressHtml);

                var html2='';
                html2 +=`<option value="${CostCenterName}">${CostCenterName}</option>`;
                $("#addCostCenterName").append(html2);


                $("#CostCenterName").val('');
            }
  }

  function isValueExists(value) {
        let existingValues = document.querySelectorAll('input[name="CostCenterName1[]"]');
        for (let i = 0; i < existingValues.length; i++) {
            if (existingValues[i].value === value) {
                return true;
            }
        }
        return false;
    }

    function isClientBaseExists(clientBase) {
    // Check if the value already exists in the table
    let existingValues = document.querySelectorAll('input[name="clientBase[]"]');
    for (let i = 0; i < existingValues.length; i++) {
        if (existingValues[i].value === clientBase) {
            return true;
        }
    }
    return false;
}



  function addNewBase()
     {
    let CostCenterName   = $("#addCostCenterName").val();
    let clientBase      = $("#clientBaseId").val();
    let CostCenterLocation      = $("#CostCenterLocation").val();

     if(CostCenterName.trim() == ''){
        $("#costCenterNameError").attr('hidden',false);
        isValid =0;
    }
     if(clientBase.trim() == ''){
        $("#clientBaseError").attr('hidden',false);
        isValid =0;
    }

        // Check if the value already exists in the table
    if (isClientBaseExists(clientBase)) {
        // Show the error message
        document.getElementById("BaseErrr").removeAttribute("hidden");
    } else {
        // Hide the error message
        document.getElementById("BaseErrr").setAttribute("hidden", "true");


        let microtime = Date.now();
        let addressHtml = `<tr id="address${microtime}">
                                    <td hidden>
                                        <input name="CostCenterName[]" hidden value="${CostCenterName}">
                                        <input name="clientBase[]" hidden value="${clientBase}">
                                        <input name="CostCenterLocation[]" hidden value="${CostCenterLocation}">
                                    </td>
                                    <td>
                                        ${CostCenterName}
                                    </td>
                                    <td>
                                        ${clientBase}
                                    </td>
                                    <td>
                                        ${CostCenterLocation}
                                    </td>

                                    <td> <button class="btn text-danger btn-sm" style="border: none; background: none;" type="button" onclick="deleteTabletr('address${microtime}')"><span class="fe fe-trash-2 fs-14"></span></button></td>

                            </tr>`;




        $("#clientBaseAppend").append(addressHtml);

        $("#CostCenterLocation").val('');

        $('#addCostCenterName').val('').trigger('change');

        var html2='';
        html2 +=`<option value="${CostCenterName}">${CostCenterName}</option>`;
        $("#costCenterName").append(html2);

           resetAddNewBase();
    }
  }

  function resetAddNewBase(){
        $("#clientBaseId").val('');
      //  $("#addCostCenterName").val('');
    }




  function resetCostCenter(){
        $("#CostCenterName").val('');
        $("#CostCenterLocation").val('');
    }


  function resetAddress(){
        $("#hourlyRate").val('');
        $("#hourlyRateChargeable").val('');
        $("#HourlyRateChargeableSaturday").val('');
        $("#HourlyRateChargeableSunday").val('');
        $("#HourlyRatePayableDay").val('0').val('');
        $("#HourlyRatePayableNight").val('0').val('');
        $("#HourlyRatePayableSaturday").val('');
        $("#HourlyRatePayableSunday").val('');
    }

  function deleteTabletr(tabletr,filenumber='none'){
        $(`#${tabletr}`).remove();
        if(filenumber != 'none'){
            $(`#documentFilesDocsDiv${filenumber}`).remove();
        }
    }


    $('#saveClient').on('submit',function(e) {
            e.preventDefault();
            var addressValue = $('#addressValue2').val();
            var zipCode  = $("input[name=zipCode]").val();
            var unit     = $("input[name=unit]").val();
            var address  = $("input[name=address]").val();
            var street   = $("input[name=street]").val();
            var suburd   = $("input[name=suburd]").val();
            var city     = $("input[name=city]").val();
            var state    = $("input[name=state]").val();
            var clientId = $("input[name=clientId]").val();
            var rowCount = $("#clientData tr").length;
            var countData=rowCount+1;

                $.ajax({
                            type:'POST',
                            url:'{{ route('client.edit', ['id' => 2]) }}',
                            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                            data:{clientId:clientId,addressValue:addressValue,zipCode:zipCode,unit:unit,address:address,street:street,suburd:suburd,city:city,state:state},
                            success:function(data){
                                if (data.success==200) {
                                                        swal({
                                                                type:'success',
                                                                title: 'Added!',
                                                                text: 'Client Added Successfully',
                                                                timer: 1000
                                                            });
                                                    var rowHtml2 = `<tr>
                                                                         <td>${countData}</td>
                                                                         <td>${data.data.zipCode??'N/A'}</td>
                                                                         <td>${data.data.unit??'N/A'}</td>
                                                                         <td>${data.data.addressNumber??'N/A'}</td>
                                                                         <td>${data.data.streetAddress??'N/A'}</td>
                                                                         <td>${data.data.suburb??'N/A'}</td>
                                                                         <td>${data.data.city??'N/A'}</td>
                                                                         <td>${data.data.state??'N/A'}</td>
                                                                         <td><a onclick="removeAddress(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                                     </tr>`;

                                                    $("#clientData").append(rowHtml2);
                                                    $("#saveClient")[0].reset();

                                                    }
                            }
                        });

                      });


 function removeAddress(that,clientId) {
    var label="Address";
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
                         url: "{{route('client.delete')}}",
                         data: {
                             "clientId": clientId,
                             "_token": "{{ csrf_token() }}"
                         },
                         dataType: 'json',
                         success: function(result) {
                                 swal({
                                     type:'success',
                                     title: 'Deleted!',
                                     text: 'Address Deleted',
                                     timer: 1000
                                 });

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

@endsection
