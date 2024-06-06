@extends('admin.layout')
@section('content')
 <!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Client Add</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
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
                            <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
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
                                <span><i class="fe fe-dollar-sign"></i></span>
                                <span>Rate </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#document" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span><i class="ti-id-badge"></i></span>
                                <span>Cost Centers</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#base" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span><i class="ti-id-badge"></i></span>
                                <span>Base</span>
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
                                                <h6>{{ $client->name}}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Short Name</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->shortName}}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>ACN</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->acn}}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>ABN</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->abn}}</h6>
                                            </div>
                                        </li>



                                    </ul>
                                    <div class="detail_box">
                                <h6>Note</h6>
                                <p>{{$client->notes}}</p></div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="detail_box ps-4">
                                    <ul>
                                        <li>
                                            <div class="detail_title">
                                                <h6>State</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{$client->getState->name??''}}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Phone Principal</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{$client->phonePrinciple}}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Mobile Phone</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->mobilePhone }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Phone Aux</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->phomneAux}}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Fax Phone</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->faxPhone }}</h6>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="detail_title">
                                                <h6>Website</h6>
                                            </div>
                                            <div class="detail_ans">
                                                <h6>{{ $client->website }}  </h6>
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


                                                        <!-- <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse ($client->getaddress as $allclient)
                                                    <tr class="border-bottom">

                                                       <td>{{$allclient->zipCode  }}</td>
                                                       <td>{{$allclient->unit	  }}</td>
                                                       <td>{{$allclient->addressNumber}}</td>
                                                       <td>{{$allclient->streetAddress }}</td>
                                                       <td>{{$allclient->suburb}}</td>
                                                       <td>{{$allclient->city}}</td>
                                                       <td>{{$allclient->state}}</td>

                                                    </tr>
                                                    @empty

                                                    @endforelse


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

                        </div>

                        <div class="tab-pane email_template" id="messages">
                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                    <div class="col-lg-12">
                                            <div class="title_head">
                                                <h4>Monetize Info</h4>
                                            </div>
                                        </div>
                                    <div class="col-lg-12 mt-3">
                                    <div class="table-responsive">
                                            <table  class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>
                                                        <th class="bg-transparent border-bottom-0">S.No</th>
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

                                                        <!-- <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse ($client->getrates as $allclient)
                                                    <tr class="border-bottom">
                                                       <td>{{ $loop->iteration }}</td>
                                                        <td>{{$allclient['getType']->name	  }}</td>
                                                        <td>{{$allclient->hourlyRateChargeableDays		  }}</td>
                                                        <td>{{$allclient->ourlyRateChargeableNight}}</td>
                                                        <td>{{$allclient->hourlyRateChargeableSaturday }}</td>
                                                        <td>{{$allclient->hourlyRateChargeableSunday}}</td>
                                                        <td>{{$allclient->hourlyRatePayableDay	}}</td>
                                                        <td>{{$allclient->hourlyRatePayableNight}}</td>
                                                        <td>{{$allclient->hourlyRatePayableSaturday	}}</td>
                                                        <td>{{$allclient->hourlyRatePayableSunday}}</td>

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


                        <div class="tab-pane email_template" id="document">
                               <div class="main_bx_dt__">
                                   <div class="top_dt_sec">
                                    <div class="row">


                                    <div class="col-lg-12">
                                    <div class="table-responsive">
                                            <table id="custom_table" class="table table-bordered text-nowrap mb-0">
                                                <thead class="border-top">
                                                    <tr>

                                                        <th class="bg-transparent border-bottom-0">Cost Center</th>
                                                        {{-- <th class="bg-transparent border-bottom-0">State</th> --}}
                                                        {{-- <th class="bg-transparent border-bottom-0">Status</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @forelse ($ClientcenterName as $allclient)
                                                    <tr class="border-bottom">
                                                        <td>{{$allclient->name ?? ''  }}</td>
                                                        {{-- <td>{{$allclient->client}}</td> --}}
                                                        {{-- @php
                                                        $state= DB::table('states')->where('id',$allclient->state)->first()->name ?? '' ;
                                                        @endphp
                                                        <td>{{$state}}</td> --}}
                                                        {{-- <td> {{ $allclient->status == '1' ? 'Active' : 'Inactive' }}</td> --}}

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

                            <div class="tab-pane email_template" id="base">
                                <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                     <div class="row">


                                     <div class="col-lg-12">
                                     <div class="table-responsive">
                                             <table id="custom_table" class="table table-bordered text-nowrap mb-0">
                                                 <thead class="border-top">
                                                     <tr>
                                                         <th class="bg-transparent border-bottom-0">S.No</th>
                                                         <th class="bg-transparent border-bottom-0">Client Base</th>
                                                         <th class="bg-transparent border-bottom-0">Cost Center	</th>
                                                         <th class="bg-transparent border-bottom-0">Location	</th>

                                                         <!-- <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th> -->
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                    @foreach ($clientbase as $key=>$allclientbase)
                                                    <tr class="border-bottom">
                                                       <td>{{ $loop->iteration  }}</td>
                                                       <td>{{ $allclientbase->base}}</td>
                                                       <td>{{ $allclientbase->cost_center_name}}</td>
                                                       <td>{{ $allclientbase->location}}</td>

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

@endsection
