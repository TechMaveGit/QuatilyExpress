@extends('admin.layout')
@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Add Vehicles</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item " aria-current="page">Vehicles</li>
                    <li class="breadcrumb-item active" aria-current="page">Vehicles Add</li>

                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->
        <div>
            <div class="side-app">
                <!-- CONTAINER -->
                <div class="main-container container-fluid">
                    <div class="card">
                        <div class="card-body p-0">
                            <form action="{{ route('vehicle.add') }}" method="post"> @csrf
                                <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Vehicle Type <span
                                                            class="red">*</span></label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 form-select"
                                                            data-placeholder="Choose one" name="selectType" required>
                                                            <option value=""></option>
                                                            @forelse ($type as $alltype)
                                                                <option value="{{ $alltype->id }}"
                                                                    {{ old('selectType') == $alltype->id ? 'selected' : '' }}>
                                                                    {{ $alltype->name }}</option>
                                                            @empty
                                                            @endforelse

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Rego <span
                                                            class="red">*</span></label>
                                                    <input type="text" class="form-control" name="rego"
                                                        id="exampleInputEmail1" value="{{ old('rego') }}"
                                                        aria-describedby="emailHelp" placeholder="" required>

                                                    @if ($errors->has('rego'))
                                                        <div class="error" style="color: red;">{{ $errors->first('rego') }}
                                                        </div>
                                                    @endif


                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Odometer <span
                                                            class="red">*</span></label>
                                                    <input type="number" min="0" class="form-control"
                                                        name="odometer" id="exampleInputEmail1"
                                                        value="{{ old('odometer') }}" aria-describedby="emailHelp"
                                                        placeholder="" required>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Date Of Birth</label>
                                                        <input type="text" class="form-control fc-datepicker"  id="basicDate" aria-describedby="emailHelp" placeholder="">
                                                    </div>

                                                </div> -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Model <span
                                                            class="red">*</span></label>
                                                    <input type="text" class="form-control" name="model"
                                                        id="exampleInputEmail1" value="{{ old('model') }}"
                                                        aria-describedby="emailHelp" placeholder="" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Driver Responsible
                                                        <span class="red">*</span></label>
                                                    <div class="form-group">

                                                        <select class="form-control select2 form-select"
                                                            name="driverResponsible" data-placeholder="Choose one">
                                                            <option value="" data-select2-id="select2-data-2-23cq">
                                                                Selected</option>
                                                            @foreach ($Driverresponsible as $allDriverresponsible)
                                                                <option value="{{ $allDriverresponsible->id }}"
                                                                    {{ old('driverResponsible') == $allDriverresponsible->id ? 'selected' : '' }}
                                                                    data-select2-id="select2-data-9-rghz">
                                                                    {{ $allDriverresponsible->fullName }}
                                                                    ({{ $allDriverresponsible->email }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">What you want to
                                                        control for this vehicle?</label>
                                                    <div class="checkbox_flex">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="vehicleControl" value="1"
                                                                id="autoSizingCheck1a"
                                                                {{ old('vehicleControl') == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="autoSizingCheck1a">
                                                                Control Inspection
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                name="vehicleControl" value="2"
                                                                id="autoSizingCheck1b"
                                                                {{ old('vehicleControl') == '2' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="autoSizingCheck1b">
                                                                Control Reminder
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="vehicleControl" value="" id="autoNone" {{ old('vehicleControl') == '' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="autoNone">
                                                            None
                                                                </label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="title_head">
                                                    <h4>Date Info</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Rego Due
                                                        Date</label>

                                                    <input type="text" name="regoDate" min="1000-01-01"
                                                        max="9999-12-31" class="form-control onlydatenew"
                                                        value="{{ old('regoDate') }}" aria-describedby="emailHelp"
                                                        placeholder="Y-m-d" />

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Service Due
                                                        Date</label>

                                                    <input type="text" name="servicesDue" min="1000-01-01"
                                                        max="9999-12-31" class="form-control onlydatenew"
                                                        value="{{ old('servicesDue') }}" aria-describedby="emailHelp"
                                                        placeholder="Y-m-d" />

                                                    {{-- <input type="text" class="form-control onlydate"   min="1000-01-01" max="9999-12-31" name="servicesDue" value="{{ old('servicesDue') }}"  name="servicesDue" aria-describedby="emailHelp" placeholder=""> --}}

                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Inspection Due
                                                        Date</label>

                                                    <input type="text" name="inspenctionDue" min="1000-01-01"
                                                        max="9999-12-31" class="form-control onlydatenew"
                                                        value="{{ old('inspenctionDue') }}" aria-describedby="emailHelp"
                                                        placeholder="Y-m-d" />

                                                    {{-- <input type="text" class="form-control onlydate"   min="1000-01-01" max="9999-12-31" name="inspenctionDue" value="{{ old('inspenctionDue') }}"  name="inspenctionDue"  aria-describedby="emailHelp" placeholder=""> --}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="bottom_footer_dt">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="action_btns text-end">
                                                    <input type="submit" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <!-- main_bx_dt -->
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <script>
            // Get the current date in the format YYYY-MM-DD
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

            // Set the min attribute of the date input to the current date
            document.getElementById("datePicker1").setAttribute("min", getCurrentDate());
        </script>


        <script>
            // Get the current date in the format YYYY-MM-DD
            function getCurrentDt() {
                const today = new Date();
                const year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();

                // Add leading zeros to month and day if needed
                month = month < 10 ? `0${month}` : month;
                day = day < 10 ? `0${day}` : day;

                return `${year}-${month}-${day}`;
            }

            // Set the min attribute of the date input to the current date
            document.getElementById("datePicker2").setAttribute("min", getCurrentDt());
        </script>





        <script>
            // Get the current date in the format YYYY-MM-DD
            function getCurrentD() {
                const today = new Date();
                const year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();

                // Add leading zeros to month and day if needed
                month = month < 10 ? `0${month}` : month;
                day = day < 10 ? `0${day}` : day;

                return `${year}-${month}-${day}`;
            }

            // Set the min attribute of the date input to the current date
            document.getElementById("datePicker3").setAttribute("min", getCurrentD());
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


    </div>
@endsection
