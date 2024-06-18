@extends('admin.layout')
@section('content')

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Driver</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')  }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Driver</li>
            <li class="breadcrumb-item active" aria-current="page">Document</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

<style>
.first1{
    color: #f1c129!important;
}
.first2{
    color: #136808!important;
}
.first3{
    color: #1f12dc!important;
}
    </style>
 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
    <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header">
                    <div class="top_section_title">
                       <h5>Driver Documents</h5>
                       <!-- <a href="induction-add.php" class="btn btn-primary">+ Add New Induction</a> -->
                    </div>

                </div>
                        <div class="card-body">
                        <div class="table-responsive">
                        <table id="basic-datatable"  class="table table-bordered text-nowrap mb-0">

                            <thead class="border-top">
                                <tr>
                                    <!-- <th class="bg-transparent border-bottom-0">S.No</th> -->
                                    <th class="bg-transparent border-bottom-0 first1">Driving License</th>
                                    <th class="bg-transparent border-bottom-0 first1">Driving Issue Date</th>
                                    <th class="bg-transparent border-bottom-0 first1">Driving Expire Date</th>

                                    <th class="bg-transparent border-bottom-0 first2">Visa</th>
                                    <th class="bg-transparent border-bottom-0 first2">Visa Issue Date</th>
                                     <th class="bg-transparent border-bottom-0 first2">Visa Expire Date</th>

                                    <th class="bg-transparent border-bottom-0 first3">Traffic History</th>
                                    <th class="bg-transparent border-bottom-0 first3">Traffic Issue Date</th>
                                     <th class="bg-transparent border-bottom-0 first3">Traffic Expire Date</th>


                                    <th class="bg-transparent border-bottom-0 first4">Police Check</th>
                                    <th class="bg-transparent border-bottom-0 first4">Police Issue Date</th>
                                    <th class="bg-transparent border-bottom-0 first4">Police Expire Date</th>
                                </tr>
                            </thead>


                            <tbody>
                                    <tr class="border-bottom">
                                                    @if(null !== ($driver->driving_license ?? null))
                                                    <td class="td sorting_1">
                                                        @php
                                                            $whole1 = explode('.',@$driver->driving_license);
                                                            $whole = $whole1[1];
                                                        @endphp
                                                        @if($whole=='pdf')
                                                        <a href="{{asset(env('STORAGE_URL').@$driver->driving_license.'')}}" target="_blank" title="View Document" download="download">Open PDF</a>

                                                        @else
                                                        <a href="{{asset(env('STORAGE_URL').@$driver->driving_license.'')}}" target="_blank" title="View Document">Open Image</a>

                                                        @endif
                                                </td>
                                                @else
                                                <td class="td sorting_1">Not Found</td>
                                                @endif

                                                    <td class="td sorting_1">{{ $driver->driving_license_issue_date }}</td>
                                                    <td class="td sorting_1">{{ $driver->driving_date_expiry_date }}</td>



                                                @if(null !== ($driver->visa ?? null))
                                                <td class="td sorting_1">
                                                        @php
                                                            $whole1 = explode('.',@$driver->visa);
                                                            $whole = $whole1[1];
                                                        @endphp
                                                        @if($whole=='pdf')
                                                        <a href="{{asset(env('STORAGE_URL').@$driver->visa.'')}}" target="_blank" title="View Document">Open PDF</a>

                                                        @else
                                                        <a href="{{asset(env('STORAGE_URL').@$driver->visa.'')}}" target="_blank" title="View Document">Open Image</a>

                                                        @endif
                                                </td>
                                                @else
                                                <td class="td sorting_1">Not Found</td>
                                                @endif

                                                    <td class="td sorting_1">{{ $driver->visa_issue_date 	 }}</td>
                                                    <td class="td sorting_1">{{ $driver->visa_expiry_date }}</td>




                                                @if(null !== ($driver->traffic_history ?? null))
                                                <td class="td sorting_1">
                                                        @php
                                                            $whole1 = explode('.',@$driver->traffic_history);
                                                            $whole = $whole1[1];
                                                        @endphp
                                                        @if($whole=='pdf')
                                                        <a href="{{asset(env('STORAGE_URL').@$driver->traffic_history.'')}}" target="_blank" title="View Document">Open PDF</a>

                                                        @else
                                                        <a href="{{asset(env('STORAGE_URL').@$driver->traffic_history.'')}}" target="_blank" title="View Document">Open Image</a>

                                                        @endif
                                                </td>
                                                @else
                                                <td class="td sorting_1">Not Found</td>
                                                @endif
                                                @if(null !== ($driver->police_chceck ?? null))


                                                <td class="td sorting_1">{{ $driver->traffic_history_issue_date }}</td>

                                                <td class="td sorting_1">{{ $driver->traffic_history_expiry_date }}</td>

                                                <td class="td sorting_1">
                                                    @php
                                                        $whole1 = explode('.',@$driver->police_chceck);
                                                        $whole = $whole1[1];
                                                    @endphp
                                                    @if($whole=='pdf')
                                                    <a href="{{asset(env('STORAGE_URL').@$driver->police_chceck.'')}}" target="_blank" title="View Document">Open PDF</a>

                                                    @else
                                                    <a href="{{asset(env('STORAGE_URL').@$driver->police_chceck.'')}}" target="_blank" title="View Document">Open Image</a>

                                                    @endif
                                            </td>
                                            @else
                                            <td class="td sorting_1">Not Found</td>
                                            @endif

                                                <td class="td sorting_1">{{ $driver->police_chceck_issue_date }}</td>
                                                <td class="td sorting_1">{{ $driver->police_chceck_expiry_date }}</td>

                                        </tr>


                            </tbody>
                        </table>






                        <div class="top_section_title">


                                                   <a href="{{route('driver') }}" class="btn btn-primary">Driver List</a>

                         </div>
                    </div>
                        </div>
                    </div>
                </div>
        </div>
     </div>
</div>
</div>
@endsection
