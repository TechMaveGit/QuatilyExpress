@extends('admin.layout')
@section('content')

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Vehicles View</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle') }}">Vehicles/</li>
            <li class="breadcrumb-item active" aria-current="page">Vehicles View</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="card">
            <div class="card-body p-0">
            <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                    <div class="col-lg-6 border-right-dashed">
                                <div class="detail_box pe-4">
                                    <ul>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Type</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->types??'N/A' }}</h6>
                                            </div>
                                        </li>
                                        {{-- <li>
                                            <div class="detail_title">
                                                <h6>Rego</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->rego??'N/A' }}</h6>
                                            </div>
                                        </li> --}}
                                        <li>
                                            <div class="detail_title">
                                                <h6>Odometer</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->odometer??'N/A' }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Model</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->modelName??'N/A' }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Driver Responsible</h6>
                                            </div>
                                            <div class="detail_ans">
                                                @php
                                                  $userName = DB::table('drivers')->where('id',$vehicleId->driverResponsible??'0')->first()->userName??'';
                                                @endphp
                                                <h6>{{ $userName??'N/AA' }}</h6>
                                            </div>
                                        </li>
                                        <hr>

                                        <li>
                                            <div class="detail_title">
                                                <h6>Vehicle Rego</h6>
                                            </div>
                                            <div class="detail_ans">

                                                <h6>{{ $vehicleId->rego??'N/AA' }}</h6>

                                            </div>
                                        </li>


                                    </ul>
                                </div>

                            </div>
                            <div class="col-lg-6">



                                <div class="detail_box ps-4">
                                <div class="title_head">
                                                <h4>Date Info</h4>
                                            </div>
                                    <ul>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Rego Due Date</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->regoDueDate??'N/A'	 }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Service Due Date</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->serviceDueDate??'N/A'	 }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Inspection Due Date</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $vehicleId->inspectionDueDate??'N/A' }}</h6>
                                            </div>
                                        </li>



                                    </ul>
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


@endsection
