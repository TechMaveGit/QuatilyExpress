@extends('admin.layout')
@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Person View</h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home_page') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('person') }}">Person</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Person View</li>

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
                                        <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                            <span><i class="ti-agenda"></i></span>
                                            <span> Address</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            <span><i class="ti-calendar"></i></span>
                                            <span>Reminders </span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="#vehicle" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                            <span><i class="fe fe-dollar-sign"></i></span>
                                            <span>Rate </span>
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

                                        <div class="main_bx_dt__">
                                            <div class="top_dt_sec">
                                                <div class="row">
                                                    <div class="col-lg-6 border-right-dashed">
                                                        <div class="detail_box pe-4">
                                                            <ul>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Name</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->userName }}</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Surname</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->surname }}</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Email</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->email }}</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Mobile No.</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>+{{ $personDetail->dialCode }}{{ $personDetail->mobileNo }}</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Date Of Birth</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->dob }}</h6>
                                                                    </div>
                                                                </li>



                                                            </ul>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="detail_box ps-4">
                                                            <ul>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Phone Principal</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->phonePrincipal }}</h6>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>Phone Aux</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->phoneAux }}</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>TFN</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->tfn }}</h6>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="detail_title">
                                                                        <h6>ABN</h6>
                                                                    </div>
                                                                    <div class="detail_ans">
                                                                        <h6>{{ $personDetail->abn }}</h6>
                                                                    </div>
                                                                </li>



                                                            </ul>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>


                                        </div>
                                        <!-- main_bx_dt -->
                                    </div>
                                    <div class="tab-pane " id="profile">
                                        <div class="main_bx_dt__">
                                            <div class="top_dt_sec">
                                                <div class="row">


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
                                                                        <th class="bg-transparent border-bottom-0">Suburb
                                                                        </th>
                                                                        <th class="bg-transparent border-bottom-0">City</th>
                                                                        <th class="bg-transparent border-bottom-0">State
                                                                        </th>


                                                                        <!-- <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @forelse ($personDetail->getaddress as $allpersonDetail)
                                                                        <tr class="border-bottom">

                                                                            <td>{{ $allpersonDetail->zipCode }}</td>
                                                                            <td>{{ $allpersonDetail->unit }}</td>
                                                                            <td>{{ $allpersonDetail->addressNumber }}</td>
                                                                            <td>{{ $allpersonDetail->streetAddress }}</td>
                                                                            <td>{{ $allpersonDetail->suburb }}</td>
                                                                            <td>{{ $allpersonDetail->city }}</td>
                                                                            <td>{{ $allpersonDetail->state }}</td>

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
                                                <div class="row">

                                                    <div class="col-lg-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap mb-0">
                                                                <thead class="border-top">
                                                                    <tr>

                                                                        <th class="bg-transparent border-bottom-0">Email
                                                                            Reminder Type</th>
                                                                        <!-- <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th> -->
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($personDetail->getreminder as $key => $Personreminder)
                                                                        <tr class="border-bottom">

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

                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table id="custom_table"
                                                            class="table table-bordered text-nowrap mb-0">
                                                            <thead class="border-top">
                                                                <tr>
                                                                    <th class="bg-transparent border-bottom-0">Sno</th>
                                                                    <th class="bg-transparent border-bottom-0">Person</th>
                                                                    <th class="bg-transparent border-bottom-0">Doc</th>
                                                                    <th class="bg-transparent border-bottom-0">Status</th>
                                                                    <th class="bg-transparent border-bottom-0"
                                                                        style="width: 5%;">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @isset($documents)
                                                                    @foreach ($documents as $kk => $document)
                                                                        <tr class="border-bottom">
                                                                            <td> {{ $kk + 1 }}</td>
                                                                            <td> {{ $document->name }}</td>
                                                                            <td><img src="{{ $document->document ? asset(env('STORAGE_URL').$document->document) : '' }}"
                                                                                    alt="Document Image" width="100px"></td>
                                                                            <td> {{ $document->status == '1' ? 'Active' : 'Inactive' }}
                                                                            </td>

                                                                            <td><a onclick="removePersonDoc(this,{{ $document->id }})"
                                                                                    class="btn text-danger btn-sm"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-original-title="Delete"><span
                                                                                        class="fe fe-trash-2 fs-14"></span></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endisset
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <!-- main_bx_dt -->
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

                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mt-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered text-nowrap mb-0">
                                                                <thead class="border-top">
                                                                    <tr>

                                                                        <th class="bg-transparent border-bottom-0">Vehicle
                                                                            Type</th>
                                                                        <!-- <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Day</th>
                                                            <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Night</th>
                                                            <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Saturday</th>
                                                            <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Sunday</th> -->
                                                                        <th class="bg-transparent border-bottom-0">Hourly
                                                                            Rate Payable Day</th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly
                                                                            Rate Payable Night</th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly
                                                                            Rate Payable Saturday</th>
                                                                        <th class="bg-transparent border-bottom-0">Hourly
                                                                            Rate Payable Sunday
                                                                        </th>


                                                                    </tr>
                                                                </thead>
                                                                @php
                                                                    $i = 1;
                                                                @endphp
                                                                <tbody>
                                                                    @foreach ($personrates as $allpersonrates)
                                                                        <tr class="border-bottom">
                                                                            <td>{{ App\Models\Type::OrderBy('id', 'desc')->where('id', $allpersonrates->type)->first()->name ?? 'N/A' }}
                                                                            </td>
                                                                            <td>{{ $allpersonrates->hourlyRatePayableDays }}
                                                                            </td>
                                                                            <td>{{ $allpersonrates->hourlyRatePayableNight }}
                                                                            </td>
                                                                            <td>{{ $allpersonrates->hourlyRatePayableSaturday }}
                                                                            </td>
                                                                            <td>{{ $allpersonrates->hourlyRatepayableSunday }}
                                                                            </td>

                                                                        </tr>
                                                                    @endforeach


                                                                </tbody>
                                                            </table>
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
    <script>
        // remove  removeReminder

        function removeReminder(that, personId) {
            var label = "Reminder";
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
                                    text: 'Document Deleted',
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

                            }
                        });
                    } else {
                        swal("Cancelled", label + " safe :)", "error");
                    }
                });
        }
    </script>
@endsection
