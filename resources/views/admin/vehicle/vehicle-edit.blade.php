@extends('admin.layout')
@section('content')

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Vehicles Edit</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item" aria-current="page">Vehicles</li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="card">
            <div class="card-body p-0">

                      <form action="{{ route('vehicle.edit', ['id' => $vehicleId->id]) }}" method="post">@csrf
                         <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                    <div class="col-lg-4">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Type</label>
                                                        <div class="form-group">

                                                          <select class="form-control select2 form-select" name="selectType" data-placeholder="Choose one">

                                                              @forelse ($allTypes as $type)
                                                                    <option value="{{$type->id}}" {{ $type->id == $types ? 'selected="selected"' : '' }} >{{ $type->name }}</option>
                                                             @empty

                                                            @endforelse


                                                            </select>
                                                    </div>
                                                    </div>
                                                </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Rego</label>
                                                <input type="text" class="form-control" name="rego" id="exampleInputEmail1" value="{{ $vehicleId->rego }}" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Odometer</label>
                                                <input type="number" min="0" class="form-control" name="odometer" id="exampleInputEmail1" value="{{ $vehicleId->odometer }}" aria-describedby="emailHelp" placeholder="">
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
                                                <label class="form-label" for="exampleInputEmail1">Model</label>
                                                <input type="text" class="form-control" name="model" id="exampleInputEmail1" value="{{ $vehicleId->modelName}}" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Driver Responsible <span class="red">*</span></label>
                                                <div class="form-group">

                                           <select class="form-control select2 form-select" name="driverResponsible" data-placeholder="Choose one">
                                           <option value="" data-select2-id="select2-data-2-23cq">Selected</option>


                                           @forelse ($allresponsibles as $responsibles)
                                           <option value="{{ $responsibles->id }}" {{ $responsibles->id == $rsp ? 'selected="selected"' : '' }}  data-select2-id="select2-data-9-rghz">{{$responsibles->userName }} ( {{$responsibles->email }} )</option>
                                           @empty

                                         @endforelse




                                               </select>
                                       </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">What you want to control for this vehicle?</label>
                                                <div class="checkbox_flex">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="vehicleControl" value="1" id="autoSizingCheck1a" {{ $vehicleId->controlVehicle == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="autoSizingCheck1a">
                                                       Control Inspection
                                                        </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="vehicleControl" value="2" id="autoSizingCheck1b" {{ $vehicleId->controlVehicle == 2 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="autoSizingCheck1b">
                                                    Control Reminder
                                                        </label>
                                                </div>

                                                {{-- <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="vehicleControl" value="3" id="autoSizingCheck1b" {{ $vehicleId->controlVehicle == 3 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="autoSizingCheck1b">
                                                        No Option
                                                        </label>
                                                </div> --}}

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
                                                <label class="form-label" for="exampleInputEmail1">Rego Due Date</label>
                                                <input type="text" class="form-control onlydatenew" name="regoDate"   min="1000-01-01" max="9999-12-31" value="{{ $vehicleId->regoDueDate}}" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Service Due Date</label>
                                                <input type="text" class="form-control onlydatenew" name="servicesDue"   min="1000-01-01" max="9999-12-31" value="{{ $vehicleId->serviceDueDate}}" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Inspection Due Date</label>
                                                <input type="text" class="form-control onlydatenew" name="inspenctionDue"   min="1000-01-01" max="9999-12-31" value="{{ $vehicleId->inspectionDueDate}}" aria-describedby="emailHelp" placeholder="">
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
                            <!-- main_bx_dt -->
                </form>
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
@endsection
