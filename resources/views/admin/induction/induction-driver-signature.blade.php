@extends('admin.layout')
@section('content')


<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Induction View</h1>
    <div>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Induction View</li>
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
                    <div class="card-header">
                    <div class="top_section_title">
                       <h5>Driver Report</h5>
                    </div>
                </div>
                        <div class="card-body">
                        <div class="">
                        <table id="custom_table"  class="table table-bordered text-nowrap mb-0">
                            <thead class="border-top">
                                <tr>
                                    <th class="bg-transparent border-bottom-0">S.No</th>
                                    <th class="bg-transparent border-bottom-0">Name</th>
                                    <th class="bg-transparent border-bottom-0">Email</th>
                                    <th class="bg-transparent border-bottom-0">Mobile No</th>
                                    <th class="bg-transparent border-bottom-0">View Signature</th>
                                    <th class="bg-transparent border-bottom-0">Date</th>
                             </tr>
                            </thead>
                            <tbody>

                            @foreach ($inductiondriver as $allinductiondriver)
                                <tr class="border-bottom">
                                    <td class="td sorting_1">{{ $loop->iteration }}</td>
                                    <td class="td sorting_1">{{ $allinductiondriver['getDriver']->fullName??'' }} </td>
                                    <td class="td sorting_1">{{ $allinductiondriver['getDriver']->email??'' }}</td>
                                    <td class="td sorting_1">{{ $allinductiondriver['getDriver']->mobileNo??'' }}</td>
                                    <td class="td sorting_1">
                                    <a href="{{asset(env('STORAGE_URL').$allinductiondriver->signature.'')}}" target="_blank" title="Read PDF">View Signature</a>
                                    </td>
                                    <td class="td sorting_1">{{ date('Y-m-d h:i A', strtotime($allinductiondriver->created_at))}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                        </div>
                    </div>
                </div>
        </div>
     </div>
</div>
</div>
@endsection
