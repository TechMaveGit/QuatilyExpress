@extends('admin.layout')
@section('content')


    <style>
        .first {
            color: red;
            font-weight: bold;
            padding-top: 8px;
        }

        .firstcls1 {
            color: red;
        }

        .title_head h4 {
            margin-bottom: 30px;
            position: absolute;
            margin: -2px;
            margin-top: -61px;
        }

        .dark-mode .customClose {
            color: #fff;
        }

        .light-mode .customClose {

            color: #000 !important;
        }

        .customClose {
            font-size: 25px;
            padding: 0pc;
            color: #fff;
            position: absolute;
            display: flex;
            justify-content: center;
            background: transparent;
            border: none;
            right: 20px;
            top: 5px;
        }
        #firstEditError {
        color: red;
        font-weight: bold;
        padding-top: 8px;
    }

    #documentValidation {
        color: red;
        font-weight: bold;
        padding-top: 8px;
    }
    </style>


{{-- <style>

</style> --}}



    <div class="modal fade zoomIn" id="editRate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close customClose" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4>Person Price</h4>

                </div>

                <div class="modal-body">
                    <div class="mt-2 text-center">


                        <form method="post" action="{{ route('editPersonId') }}" />@csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="check_box">
                                    <label class="form-label" for="exampleInputEmail1" style="">Type</label>
                                    <div class="form-group">
                                        <select class="form-control" id="edittype" name="vehicleType"
                                            data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                            <option value="">Selec Any one</option>
                                            @foreach ($types as $alltypes)
                                                <option value="{{ $alltypes->id }}">{{ $alltypes->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span id="VehicleTypeErrorss" class="text-danger" hidden="">Please select any one
                                        type.</span>
                                </div>
                            </div>

                            <input type="hidden" name="typeiD" id="typeiD" value="" />
                            <input type="hidden" name="personId" value="{{ $person }}" />

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Day</label>
                                    <input type="text" name="hourlyRatePayableDay" id="hourlyRatePayableDay"min="0" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Night</label>

                                    <input type="text" name="hourlyRatePayableNight" id="hourlyRatePayableNight"
                                        min="0" class="form-control fc-datepicker" aria-describedby="emailHelp"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Saturday</label>
                                    <input type="text" name="hourlyRatePayableSaturday" id="hourlyRatePayableSaturday"
                                        min="0" class="form-control fc-datepicker" aria-describedby="emailHelp"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Sunday</label>
                                    <input type="text" name="hourlyRatePayableSunday" id="hourlyRatePayableSunday"
                                        min="0" class="form-control fc-datepicker" aria-describedby="emailHelp"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleInputEmail1">Extra Hourly Rate</label>
                                    <input type="text" name="extraHourlyRate" id="extraHourlyRate" min="0"
                                        class="form-control fc-datepicker" aria-describedby="emailHelp" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="search_btn text-end">
                                    <button type="submit" class="btn btn-primary srch_btn" fdprocessedid="cgqwgp">Update
                                        Rate </button>
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


    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Person Edit</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('person') }}">Person</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Person Edit</li>

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
                                        <a href="#home" data-bs-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                            <span><i class="ti-light-bulb"></i></span>
                                            <span> Basic Information</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#address" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                            <span><i class="ti-agenda"></i></span>
                                            <span> Address</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#reminder" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            <span><i class="ti-calendar"></i></span>
                                            <span>Reminders </span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="#rate" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            <span><i class="fe fe-dollar-sign"></i></span>
                                            <span>Rates </span>
                                        </a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="#document" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            <span><i class="ti-id-badge"></i></span>
                                            <span>Document</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="tab-content  text-muted">
                                    <div class="tab-pane show active" id="home">

                                        <form action="{{ route('person.edit', ['id' => $person]) }}" method="post"> @csrf

                                            <div class="main_bx_dt__">
                                                <div class="top_dt_sec">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <input type="hidden" name="personValue1"
                                                                    id="personValue1" value="1" />
                                                                <label class="form-label" for="exampleInputEmail1">Name
                                                                    <span class="red">*</span></label>
                                                                <input type="text" class="form-control" name="name"
                                                                    value="{{ $editPerson->userName ?? 'N/A' }}"
                                                                    id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">Surname</label>
                                                                <input type="text" class="form-control" name="surname"
                                                                    value="{{ $editPerson->surname ?? 'N/A' }}"
                                                                    id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                    placeholder="">

                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Email
                                                                    <span class="red">*</span></label>
                                                                <input type="text" class="form-control" name="email"
                                                                    value="{{ $editPerson->email ?? 'N/A' }}"
                                                                    aria-describedby="emailHelp" placeholder="" readonly>
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Date Of
                                                                    Birth</label>

                                                                <input type="text"
                                                                    class="form-control onlydate dob_valid"
                                                                    value="{{ $editPerson->dob ?? 'N/A' }}" id="basicDate"
                                                                    name="dob" aria-describedby="emailHelp"
                                                                    placeholder="">

                                                            </div>

                                                        </div>
                                                        <div class="col-lg-4">
                                                            <label for="simpleinput" class="form-label">Mobile No. <span class="red">*</span></label>
                                                            <div class="input-group ">
                                                                <div class="input-group-prepend">
                                                                    <select id="country" class="form-control select2"
                                                                        name="country_code"
                                                                        data-placeholder="Select a country"
                                                                        data-dynamic-select required>

                                                                        @foreach ($countryCode as $countryCodes)
                                                                            <option value={{ $countryCodes->dial_code }}     {{ $countryCodes->dial_code == $editPerson->dialCode ? 'selected' : '' }}                                                                             data-img="{{ $countryCodes->flag }}">
                                                                                {{ isset($countryCodes->dial_code) ? $countryCodes->dial_code : '' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <input type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                                    value="{{ old('mobile_number') ?? $editPerson->mobileNo }}"
                                                                    name="mobile_number" minlength="8" maxlength="13"
                                                                    class="form-control " required>
                                                                @error('mobile_number')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Phone Principal </label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputEmail1"
                                                                    value="{{ $editPerson->phonePrincipal ?? 'N/A' }}" 
                                                                    name="phoneprinciple" aria-describedby="emailHelp"
                                                                    placeholder="" >
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Phone
                                                                    Aux</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputEmail1"
                                                                    value="{{ $editPerson->phoneAux ?? 'N/A' }}"
                                                                    name="phoneaux" aria-describedby="emailHelp"
                                                                    placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">TFN</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputEmail1"
                                                                    value="{{ $editPerson->tfn ?? 'N/A' }}" name="tfn"
                                                                    aria-describedby="emailHelp" placeholder="">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">ABN</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleInputEmail1"
                                                                    value="{{ $editPerson->abn ?? 'N/A' }}" name="abn"
                                                                    aria-describedby="emailHelp" placeholder="">
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    for="exampleInputEmail1">Password</label>
                                                                <input type="text" class="form-control"
                                                                    name="password" aria-describedby="emailHelp"
                                                                    placeholder="">
                                                            </div>
                                                        </div>




                                                        @php
                                                            $roles = DB::table('roles')
                                                                ->where('name', '!=', 'my permission')
                                                                ->orderBy('id', 'DESC')
                                                                ->get();
                                                            $adminRoleId =
                                                                DB::table('admins')
                                                                    ->where('email', $editPerson->email)
                                                                    ->orderBy('id', 'DESC')
                                                                    ->first()->role_id ?? '';
                                                        @endphp

                                                        <div class="col-lg-4">
                                                            <div class="check_box">
                                                                <label class="form-label">Select Role <span
                                                                        class="red">*</span></label>
                                                                <div class="form-group">
                                                                    <select class="form-control select2 form-select"
                                                                        name="roles" data-placeholder="Choose one"
                                                                        required>
                                                                        <option value="">Select any one</option>
                                                                        @foreach ($roles as $allrole)
                                                                            <option value="{{ $allrole->id }}"
                                                                                {{ $allrole->id == $editPerson->role_id ? 'selected' : '' }}>
                                                                                {{ $allrole->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="exampleInputEmail1">Extra Rate (Per Hour) <span class="red">*</span></label>
                                                                <input type="number" class="form-control" min="0" id="exampleInputEmail1" step="any" value="{{old('extra_rate_per_hour') ?? $editPerson->extra_rate_per_hour}}" autocomplete="off" name="extra_rate_per_hour" aria-describedby="emailHelp" placeholder="" required>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="bottom_footer_dt">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="action_btns text-end">
                                                                <button type="submit" value="Submit"
                                                                    class="btn btn-primary"><i class="bi bi-save"></i>
                                                                    Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                        <!-- main_bx_dt -->
                                    </div>

                                    <div class="tab-pane " id="address">
                                        <div class="main_bx_dt__">
                                            <div class="top_dt_sec">
                                                <form class="saveclass" id="saveAddress">
                                                    <div class="row">
                                                        <input type="hidden" name="personValue2" id="personValue2"
                                                            value="2" />
                                                        <input type="hidden" name="personId"
                                                            value="{{ $person }}" />
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Zip Code</label>
                                                                        <input type="text" class="form-control"
                                                                            name="zipCode" id="addZipCode"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                        <span class="firstcls1" id="addZipCodeError"
                                                                            class="text-danger" hidden>Please add zip
                                                                            code.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Unit</label>
                                                                        <input type="text" class="form-control"
                                                                            name="unit" id="unitErrorId"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                        <span class="firstcls1" id="unitError"
                                                                            class="text-danger" hidden>Please add Unit.</span>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Address Number</label>
                                                                        <input type="text" class="form-control"
                                                                            name="addressNumber" id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Street Address</label>
                                                                        <input type="text" class="form-control"
                                                                            name="streetAddress" id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Suburb</label>
                                                                        <input type="text" class="form-control"
                                                                            name="suburb" id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">City</label>
                                                                        <input type="text" class="form-control"
                                                                            name="city" id="cityErrorId"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                            <span class="firstcls1" id="cityError"
                                                                            class="text-danger" hidden>Please Add City.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">State</label>
                                                                        <input type="text" class="form-control"
                                                                            name="state" id="stateErrorId"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                            <span class="firstcls1" id="stateError"
                                                                            class="text-danger" hidden>Please Add State.</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="add_address text-end">
                                                                <button type="submit" class="theme_btn btn btn-primary"
                                                                    id="add_person_btn">+ Add Address</button>

                                                            </div>
                                                        </div>
                                                </form>



                                                <div class="col-lg-12 mt-4">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered text-nowrap mb-0">
                                                            <thead class="border-top">
                                                                <tr>

                                                                    <th class="bg-transparent border-bottom-0">Zip Code
                                                                    </th>
                                                                    <th class="bg-transparent border-bottom-0">Unit</th>
                                                                    <th class="bg-transparent border-bottom-0">Address
                                                                        Number</th>
                                                                    <th class="bg-transparent border-bottom-0">Street
                                                                        Address</th>
                                                                    <th class="bg-transparent border-bottom-0">Suburb</th>
                                                                    <th class="bg-transparent border-bottom-0">City</th>
                                                                    <th class="bg-transparent border-bottom-0">State</th>


                                                                    <th class="bg-transparent border-bottom-0"
                                                                        style="width: 5%;">Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="personAddress">
                                                                @if (isset($editPerson->getaddress))
                                                                    @forelse($editPerson->getaddress as $key=>$alladdress)
                                                                        <tr class="border-bottom">
                                                                            <td>{{ $alladdress->zipCode }}</td>
                                                                            <td>{{ $alladdress->unit }}</td>
                                                                            <td>{{ $alladdress->addressNumber }}</td>
                                                                            <td>{{ $alladdress->streetAddress }}</td>
                                                                            <td>{{ $alladdress->suburb }}</td>
                                                                            <td>{{ $alladdress->city }}</td>
                                                                            <td>{{ $alladdress->state }}</td>
                                                                            <td>
                                                                                <div class="g-2">
                                                                                    <a onclick="removePerson(this,'{{ $alladdress->id }}')"
                                                                                        class="btn text-danger btn-sm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-original-title="Delete"><span
                                                                                            class="fe fe-trash-2 fs-14"></span></a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>

                                                                    @empty
                                                                    @endforelse
                                                                @endif




                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        </div>
                                    <!-- main_bx_dt -->
                                    </div>

                                    <div class="tab-pane email_template" id="reminder">
                                        <div class="main_bx_dt__">
                                            <div class="top_dt_sec">
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <form class="saveclass" id="saveReminder">
                                                            <input type="hidden" name="personValue3" id="personValue3"
                                                                value="3" />
                                                            <input type="hidden" name="personId"
                                                                value="{{ $person }}" />
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-4">
                                                                    <div class="check_box">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Email Reminder
                                                                            Type</label>
                                                                        <div class="form-group">

                                                                            <select class="form-control select2 form-select"
                                                                                name="reminderType"
                                                                                data-placeholder="Choose one">

                                                                                @forelse ($reminder as $allreminder)
                                                                                    <option value="{{ $allreminder->id }}">
                                                                                        {{ $allreminder->reminderName }}
                                                                                    </option>

                                                                                @empty
                                                                                @endforelse

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <div class="search_btn">
                                                                        <button type="submit"
                                                                            class="btn btn-primary srch_btn"
                                                                            id="add_person_btn">+ Add Type</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </form>

                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap mb-0">
                                                                <thead class="border-top">
                                                                    <tr>

                                                                        <th class="bg-transparent border-bottom-0">Email
                                                                            Reminder Type</th>
                                                                        <th class="bg-transparent border-bottom-0"
                                                                            style="width: 5%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="saveRemindertR">

                                                                    @if (isset($editPerson->getreminder))
                                                                        @foreach ($editPerson->getreminder as $key => $Personreminder)
                                                                            <tr class="border-bottom" id="personReminder">

                                                                                <td>{{ $Personreminder->getReminder->reminderName }}
                                                                                </td>
                                                                                <td>
                                                                                    <div class="g-2">
                                                                                        <a onclick="removeReminder(this,'{{ $Personreminder->id }}')"
                                                                                            class="btn text-danger btn-sm"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-original-title="Delete"><span
                                                                                                class="fe fe-trash-2 fs-14"></span></a>

                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif



                                                                </tbody>
                                                            </table>
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
                                                        <form id="documentBaseForm" method="post"
                                                            enctype='multipart/form-data'>
                                                            @csrf
                                                            <input type="hidden" name="personValue5" value="5" />
                                                            <input type="hidden" name="person_id"
                                                                value="{{ Request::segment(4) }}" id="person_id" />
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Name</label>
                                                                        <input type="text" name="document_name"
                                                                            class="form-control" id="firstEdit"
                                                                            aria-describedby="emailHelp" placeholder="">
                                                                        <p class="first" id="firstEditError"
                                                                            style="display: none">Please Add Name</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Status</label>

                                                                        <select class="form-control select2 form-select"
                                                                            data-placeholder="Choose one"
                                                                            name="document_status">
                                                                            <option value="1">Active</option>
                                                                            <option value="2">Inactive</option>

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="check_box">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Upload document</label>
                                                                        <div class="form-group">
                                                                            <input type="file" class="dropify"
                                                                                id="documentAdd" data-height="100"
                                                                                name="document_file" />
                                                                            <p class="first" id="documentValidation"
                                                                                style="display: none">Document Field is
                                                                                required</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 mb-5">
                                                                    <div class="search_btn text-end">
                                                                        <button type="submit"
                                                                            class="btn btn-primary srch_btn">+ Add
                                                                            Document</button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table id="custom_table"
                                                            class="table table-bordered text-nowrap mb-0">
                                                            <thead class="border-top">
                                                                <tr>
                                                                    <th class="bg-transparent border-bottom-0">S.No</th>
                                                                    <th class="bg-transparent border-bottom-0">Name</th>
                                                                    <th class="bg-transparent border-bottom-0">Doc</th>
                                                                    <th class="bg-transparent border-bottom-0">Status</th>
                                                                    <th class="bg-transparent border-bottom-0"
                                                                        style="width: 5%;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="basic-datatable_body">
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                @if (isset($documents))
                                                                    @foreach ($documents as $document)
                                                                        <tr class="border-bottom">
                                                                            <td> {{ $i }}</td>
                                                                            <td> {{ $document->name }}</td>
                                                                            <td><a href="{{ $document->document ?  asset(env('STORAGE_URL'). $document->document) : '' }}" target="_blank">View Doc</a></td>
                                                                            <td> {{ $document->status == '1' ? 'Active' : 'Inactive' }}
                                                                            </td>

                                                                            <td><a onclick="removePersonDoc(this,{{ $document->id }})"
                                                                                    class="btn text-danger btn-sm"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete"><span
                                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                                            </td>

                                                                        </tr>
                                                                        @php
                                                                            $i++;
                                                                        @endphp
                                                                    @endforeach
                                                                @endif

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>

                                    <div class="tab-pane email_template" id="rate">
                                        <div class="main_bx_dt__">
                                            <div class="top_dt_sec">
                                                <div class="row">

                                                    <form id="monetizeId">
                                                        <div class="col-lg-12">
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-12">
                                                                    <div class="title_head">
                                                                        {{-- <h4>Person Price  ok</h4> --}}
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <div class="check_box">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Type</label>
                                                                        <div class="form-group">

                                                                            <input type="hidden" name="personValue4"
                                                                                id="personValue4" value="4" />
                                                                            <input type="hidden" name="personId"
                                                                                value="{{ $person }}" />


                                                                            <select class="form-control select2 form-select"
                                                                                id="VehicleType" name="type"
                                                                                data-placeholder="Choose one">
                                                                                <option value=""></option>
                                                                                @php
                                                                                    $types = DB::table('types')->get();
                                                                                @endphp
                                                                                @forelse ($types as $alltypes)
                                                                                    <option value="{{ $alltypes->id }}">
                                                                                        {{ $alltypes->name }}</option>
                                                                                @empty
                                                                                @endforelse


                                                                            </select>
                                                                        </div>
                                                                        <span id="VehicleTypeError" class="text-danger"
                                                                            hidden>Please select any one type.</span>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Hourly Rate Payable
                                                                            Day</label>

                                                                        <input type="number" name="hourlyRatePayableDay"
                                                                            min="0" class="form-control"
                                                                            aria-describedby="emailHelp" placeholder="">

                                                                        <p class="first" id="hourlyRatePayableDayError"
                                                                            style="display: none">Please Add Hourly Rate
                                                                            Payable Day</p>

                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Hourly Rate Payable
                                                                            Night</label>

                                                                        <input type="text" name="hourlyRatePayableNight"
                                                                            id="hourlyRatePayableNight2" min="0"
                                                                            class="form-control fc-datepicker"
                                                                            aria-describedby="emailHelp" placeholder="">

                                                                        <p class="first" id="hourlyRatePayableNightError"
                                                                            style="display: none">Please Add Hourly Rate
                                                                            Payable Night</p>



                                                                        <!--<input type="text" class="form-control" name="hourlyRatePayableNight" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Hourly Rate Payable
                                                                            Saturday</label>
                                                                        <input type="text" name="hourlyRatePayableSaturday"
                                                                            id="hourlyRatePayableSaturday3" min="0"
                                                                            class="form-control fc-datepicker"
                                                                            aria-describedby="emailHelp" placeholder="">

                                                                        <p class="first" id="hourlyRatePayableSaturdayError"
                                                                            style="display: none">Please Add Hourly Rate
                                                                            Payable Saturday</p>

                                                                        <!--<input type="text" class="form-control" name="hourlyRatePayableSaturday" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Hourly Rate Payable
                                                                            Sunday</label>
                                                                        <input type="text" name="hourlyRatePayableSunday"
                                                                            id="hourlyRatePayableSunday4" min="0"
                                                                            class="form-control fc-datepicker"
                                                                            aria-describedby="emailHelp" placeholder="">

                                                                        <p class="first" id="hourlyRatePayableSundayError"
                                                                            style="display: none">Please Add Hourly Rate
                                                                            Payable Sunday</p>

                                                                        <!--<input type="text" class="form-control" name="hourlyRatePayableSunday" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"
                                                                            for="exampleInputEmail1">Extra Hourly Rate</label>


                                                                        <input type="text" name="extraHourlyRate"
                                                                            id="extraHourlyRate5" min="0"
                                                                            class="form-control fc-datepicker"
                                                                            aria-describedby="emailHelp" placeholder="">

                                                                        <p class="first" id="extraHourlyRateError"
                                                                            style="display: none">Please Add Extra Hourly Rate
                                                                        </p>

                                                                        <!--<input type="text" class="form-control" name="extraHourlyRate" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">-->
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="search_btn text-end">
                                                                        <button type="submit"
                                                                            class="btn btn-primary srch_btn"
                                                                            fdprocessedid="cgqwgp">Update Rate </button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="col-lg-12 mt-5">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap mb-0">
                                                                <thead class="border-top">
                                                                    <tr>

                                                                        <th class="bg-transparent border-bottom-0">Vehicle Type
                                                                        </th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly Rate
                                                                            Payable Day</th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly Rate
                                                                            Payable Night</th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly Rate
                                                                            Payable Saturday</th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly Rate
                                                                            Payable Sunday</th>
                                                                        <th class="bg-transparent border-bottom-0">Extra Hourly
                                                                            Rate</th>
                                                                        <th class="bg-transparent border-bottom-0"
                                                                            style="width: 5%;">Action</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="monetizeIdAppend">
                                                                    @forelse ($personRating as $alllpersonRating)
                                                                        <tr class="border-bottom">
                                                                            @php
                                                                                $typeName =
                                                                                    DB::table('types')
                                                                                        ->orderBy('id', 'DESC')
                                                                                        ->where(
                                                                                            'id',
                                                                                            $alllpersonRating->type,
                                                                                        )
                                                                                        ->first()->name ?? 'N/A';
                                                                            @endphp
                                                                            <td>{{ $typeName }}</td>
                                                                            <td>{{ $alllpersonRating->hourlyRatePayableDays }}
                                                                            </td>
                                                                            <td>{{ $alllpersonRating->hourlyRatePayableNight }}
                                                                            </td>
                                                                            <td>{{ $alllpersonRating->hourlyRatePayableSaturday }}
                                                                            </td>
                                                                            <td>{{ $alllpersonRating->hourlyRatepayableSunday }}
                                                                            </td>
                                                                            <td>{{ $alllpersonRating->extraHourlyRate }}</td>
                                                                            <td>
                                                                                <div class="g-2">
                                                                                    <a onclick="editRate('{{ $alllpersonRating->type }}','{{ $alllpersonRating->hourlyRatePayableDays ?? 'N/A' }}','{{ $alllpersonRating->hourlyRatePayableNight ?? 'N/A' }}','{{ $alllpersonRating->hourlyRatePayableSaturday ?? 'N/A' }}','{{ $alllpersonRating->hourlyRatepayableSunday ?? 'N/A' }}','{{ $alllpersonRating->extraHourlyRate ?? 'N/A' }}')"
                                                                                        class="btn text-primary btn-sm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-original-title="Edit"><span
                                                                                            class="fe fe-edit fs-14"></span></a>
                                                                                    <a onclick="removeRate(this,'{{ $alllpersonRating->id }}')"
                                                                                        class="btn text-danger btn-sm"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-original-title="Delete"><span
                                                                                            class="fe fe-trash-2 fs-14"></span></a>

                                                                                </div>
                                                                            </td>
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



        const numericInput1 = document.getElementById('hourlyRatePayableDay1');
        const numericInput2 = document.getElementById('hourlyRatePayableNight2');
        const numericInput3 = document.getElementById('hourlyRatePayableSaturday3');
        const numericInput4 = document.getElementById('hourlyRatePayableSunday4');
        const numericInput5 = document.getElementById('extraHourlyRate5');

        numericInput1.addEventListener('keydown', function(event) {
            const key = event.key;
            if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        numericInput2.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        numericInput3.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        numericInput4.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        numericInput5.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        const numericInput11 = document.getElementById('hourlyRatePayableDay');
        const numericInput22 = document.getElementById('hourlyRatePayableNight');
        const numericInput33 = document.getElementById('hourlyRatePayableSaturday');
        const numericInput44 = document.getElementById('hourlyRatePayableSunday');
        const numericInput55 = document.getElementById('extraHourlyRate');

        numericInput11.addEventListener('keydown', function(event) {
            const key = event.key;
            if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        numericInput22.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        numericInput33.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        numericInput44.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

        numericInput55.addEventListener('keydown', function(event) {
            const key = event.key;
            // Check if the pressed key is a letter
            if (/^[a-zA-Z]$/.test(key)) {
                // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });
    </script>



    <!-- document save  -->
    <script>
        $('#documentBaseForm').on('submit', function(e) {


            var firstEdit = $.trim($('#firstEdit').val());

            var fileInput = document.getElementById('documentAdd');

            if (firstEdit === '') {
                $("#firstEditError").show();
                return false;
            } else {
                $("#firstEditError").hide();
            }

            if (fileInput.files.length === 0) {
                $("#documentValidation").show();
                return false;
            } else {
                $("#documentValidation").hide();
            }


            e.preventDefault();
            var formData = new FormData(this);
            var person_id = $('#person_id').val();
            $.ajax({
                type: "POST",
                url: "{{ route('person.edit', ['id' => Request::segment(4)]) }}",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success == '200') {

                        $("#firstEditError").hide();
                        $("#documentValidation").hide();

                        $("#documentBaseForm")[0].reset();
                        $(".dropify-clear").trigger("click");
                        swal({
                            type: 'success',
                            title: 'Added!',
                            text: 'Person Document Added Successfully',
                            timer: 1000
                        });
                        window.location.reload();
                        $('#basic-datatable tbody').empty();
                        if (Array.isArray(data.documents) && data.documents.length > 0) {
                            let storage_url = "{{env('STORAGE_URL')}}";
                            
                            var tableHtml = '<tbody>';
                            var sno = 1;
                            data.documents.forEach(doc => {
                                var document_urls_dtaa = storage_url+doc.document;
                                var rowHtml2 = `<tr>
                                                    <td>${sno}</td>
                                                    <td>${doc.name}</td>
                                                    <td><img src="{{ asset('${document_urls_dtaa}') }}" alt="Document Image" width="100px"></td>
                                                    <td>${doc.status == '1' ? 'Active':'Inactive' }</td>
                                                    <td><a onclick="removePersonDoc(this, ${doc.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a></td>
                                                </tr>`;
                                $("#basic-datatable tbody").append(rowHtml2);
                                sno++;
                            });
                            tableHtml += '</tbody>';
                        } else {

                            $("#basic-datatable tbody").append(
                                "<tr><td colspan='4'>No documents available</td></tr>");
                        }

                    }

                },
            });

        })
    </script>

    <script>
        $('#saveAddress').on('submit', function(e) {
            e.preventDefault();
            var rowCount = $("#personAddress tr").length;
            var countData = rowCount + 1;


            var addZipCode = $("#addZipCode").val();
            if (addZipCode.trim() == '') {
                $("#addZipCodeError").attr('hidden', false);
                return false;
            } else {
                $("#addZipCodeError").attr('hidden', true);
            }

            var unitError = $.trim($('#unitErrorId').val());
            if (unitError.trim() == '') {
                $("#unitError").attr('hidden', false);
                return false;
            } else {
                $("#unitError").attr('hidden', true);
            }

            var cityError = $.trim($('#cityErrorId').val());
            if (cityError.trim() == '') {
                $("#cityError").attr('hidden', false);
                return false;
            } else {
                $("#cityError").attr('hidden', true);
            }

            var stateError = $.trim($('#stateErrorId').val());
            if (stateError.trim() == '') {
                $("#stateError").attr('hidden', false);
                return false;
            } else {
                $("#stateError").attr('hidden', true);
            }


            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('person.edit', ['id' => 2]) }}",
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
                            text: 'Person Address Added Successfully',
                            timer: 1000
                        });
                        var rowHtml2 = `<tr>
                                                                <td>${data.data.zipCode}</td>
                                                                <td>${data.data.unit}</td>
                                                                <td>${data.data.addressNumber}</td>
                                                                <td>${data.data.streetAddress}</td>
                                                                <td>${data.data.suburb}</td>
                                                                <td>${data.data.city}</td>
                                                                <td>${data.data.state}</td>
                                                                <td>
                                                                    <div class="g-2">
                                                                        <a onclick="removePerson(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>

                                                                    </div>
                                                                </td>
                                                        </tr>`;

                        $("#personAddress").append(rowHtml2);
                        $("#saveAddress")[0].reset();
                    }

                },
            });

        })


        function removePerson(that, personId) {
            var label = "Address";
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
                            url: "{{ route('person.delete.address') }}",
                            data: {
                                "personId": personId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                        type: 'success',
                                        title: 'Deleted!',
                                        text: 'Person Deleted',
                                        timer: 1000
                                    },
                                    function() {
                                        location.reload();
                                    }
                                );


                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }

                            },
                            error: function(data) {

                            }
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
    </script>


    <!--  Add person reminder -->
    <script>
        $('#saveReminder').on('submit', function(e) {
            e.preventDefault();
            var rowCount = $("#personAddress tr").length;
            var countData = rowCount + 1;
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('person.edit', ['id' => 3]) }}",
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
                            text: 'Person Reminder Added Successfully',
                            timer: 1000
                        });
                        var rowHtml2 = `<tr>
                                                            <td>${data.data.typeName}</td>
                                                            <td>
                                                                <div class="g-2">
                                                                    <a onclick="removeReminder(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                                </div>
                                                            </td>
                                                        </tr>`;

                        $("#saveRemindertR").append(rowHtml2);
                        $("#saveReminder")[0].reset();
                    }

                },
            });

        })


        function removeRate(that, personId) {
            console.log(that);
            var label = "removeRate";
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
                            url: "{{ route('deleteRate') }}",
                            data: {
                                "personId": personId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                        type: 'success',
                                        title: 'Deleted!',
                                        text: 'Remove Rate Deleted',
                                        timer: 1000
                                    },
                                    function() {
                                        location.reload();
                                    }

                                );

                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }
                            },
                            error: function(data) {

                            }
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }


        function removeReminder(that, personId) {
            var label = "Address";
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
                            url: "{{ route('person.delete.reminder') }}",
                            data: {
                                "personId": personId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                        type: 'success',
                                        title: 'Deleted!',
                                        text: 'Reminder Deleted',
                                        timer: 1000
                                    },
                                    function() {
                                        location.reload();
                                    });

                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }


                                // window.setTimeout(function(){ } ,1000);
                                // location.reload();

                            },
                            error: function(data) {

                            }
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
    </script>



    <!--  Add person monetizeId -->


    <script>
        $('#monetizeId').on('submit', function(e) {
            e.preventDefault();
            var rowCount = $("#monetizeId tr").length;
            var countData = rowCount + 1;

            var clientCenterName = document.getElementById('VehicleType').value;
            if (clientCenterName == '') {
                $("#VehicleTypeError").attr('hidden', false);
                return false;
            } else {
                $("#VehicleTypeError").attr('hidden', true);
            }

            var dropdowntype = $("#edittype").val();


            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('person.edit', ['id' => 4]) }}",
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
                            text: 'Person Rates Added Successfully',
                            timer: 1000
                        });

                        var rowHtml2 = `<tr>
                                                            <td>${data.data.dropdowntype}</td>
                                                            <td>${data.data.hourlyRatePayableDays}</td>
                                                            <td>${data.data.hourlyRatePayableNight}</td>
                                                            <td>${data.data.hourlyRatePayableSaturday}</td>
                                                            <td>${data.data.hourlyRatepayableSunday}</td>
                                                            <td>${data.data.extraHourlyRate}</td>
                                                            <td>
                                                                <div class="g-2">
                                                                    <a onclick="editRate('+'dropdowntype'+')${data.data.hourlyRatePayableDays}','${data.data.hourlyRatePayableNight}','${data.data.hourlyRatePayableSaturday}','${data.data.hourlyRatepayableSunday}','${data.data.extraHourlyRate}')" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>
                                                                    <a onclick="removeRate(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                                </div>
                                                            </td>
                                                        </tr>`;

                        $("#monetizeIdAppend").append(rowHtml2);
                        $("#monetizeId")[0].reset();
                        $('#edittype').val('').trigger('change');
                        // $('#edittype').val(${data.data.dropdowntype}).trigger('change');

                    }

                    if (data.success == 300) {
                        swal({
                            type: 'success',
                            title: 'Added!',
                            text: 'Person Rates Updated Successfully',
                            timer: 1000
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 100);



                        $("#monetizeId")[0].reset();

                    }

                },
            });

        })


        function removeReminder(that, personId) {
            var label = "Address";
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
                            url: "{{ route('person.delete.reminder') }}",
                            data: {
                                "personId": personId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                        type: 'success',
                                        title: 'Deleted!',
                                        text: 'Reminder Deleted',
                                        timer: 1000
                                    },
                                    function() {
                                        location.reload();
                                    }
                                );

                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }


                                // window.setTimeout(function(){ } ,1000);
                                // location.reload();

                            },
                            error: function(data) {

                            }
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
    </script>

    <script>
        // remove person document

        function removePersonDoc(that, personId) {
            var label = "Address";
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
                            url: "{{ route('person.Persondocument.delete') }}",
                            data: {
                                "personId": personId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                swal({
                                    type: 'success',
                                    title: 'Deleted!',
                                    text: 'Document Deleted',
                                    timer: 1000
                                }, );

                                if (that) {
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }


                                // window.setTimeout(function(){ } ,1000);
                                // location.reload();

                            },
                            error: function(data) {

                            }
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
    </script>

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


        function editRate(getType, hourlyRateChargeableDays, ourlyRateChargeableNight, hourlyRateChargeableSaturday,
            hourlyRateChargeableSunday, extraHourlyRate) {
            $('#editRate').modal('show');
            $('#edittype').val(getType).trigger('change');
            $('#typeiD').val(getType);
            $('#hourlyRatePayableDay').val(hourlyRateChargeableDays);

            $('#hourlyRatePayableNight').val(ourlyRateChargeableNight);
            $('#hourlyRatePayableSaturday').val(hourlyRateChargeableSaturday);
            $('#hourlyRatePayableSunday').val(hourlyRateChargeableSunday);
            $('#extraHourlyRate').val(extraHourlyRate);


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
