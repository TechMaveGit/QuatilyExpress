@extends('admin.layout')
@section('content')



<!-- Modal -->
 <div class="modal fade" id="shift_approve" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

    <form action="{{ route('admin.shift.shiftapprove') }}" method="post"/>@csrf


       <div class="modal-content">
          <div class="modal-body">
             <div class="row">
                <div class="col-lg-12">
                   <div class="approve_cnt">
                      <img src="{{ asset('public/assets/images/newimages/question-mark.png')}}" alt="">
                      <h3>Do you want to approve ?</h3>
                      <input type="hidden" name="shiftId" id="shiftId" />
                      <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Architecto, delectus?</p>
                   </div>
                </div>
             </div>
          </div>
          <div class="modal-footer">
             <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Yes</button>
             <button type="button" class="btn btn-info" data-bs-dismiss="modal">No</button>
          </div>
       </div>

    </form>


    </div>
 </div>




 <!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Shift Report</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Shift</li>
            <li class="breadcrumb-item active" aria-current="page">Shift Report</li>

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
                        <div class="card-header card_h">
                                <div class="top_section_title">
                                    <h5>Filter</h5>
                                </div>
                            </div>
                        <div class="card-body">


                            <form action="{{ route('admin.shift.report') }}" method="post"/> @csrf
                            <div class="row align-items-center">
                               <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">State</label>
                                        <div class="form-group">
                                        <select class="form-control select2 form-select" name="state" data-placeholder="Choose one">
                                            <option value="" selected="">Select</option>
                                            @forelse ($alldropdowns as $allalldropdowns)
                                            <option value="{{ $allalldropdowns->id }}" @if ($state == $allalldropdowns->id ) {{ 'selected' }} @endif>{{ $allalldropdowns->name }}</option>

                                            @empty

                                            @endforelse

                                          </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1"> Client</label>

                                        <div class="form-group">

                                           <select class="form-control select2 form-select" name="client" data-placeholder="Choose one">
                                                 <option value="">Select</option>
                                                 @forelse ($client as $allclient)
                                            <option value="{{ $allclient->id }}" @if ($clients == $allclient->id ) {{ 'selected' }}  @endif>{{ $allclient->name }}</option>

                                            @empty

                                            @endforelse
                                               </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Status</label>
                                        <div class="form-group">

                                           <select class="form-control select2 form-select" name="status" data-placeholder="Choose one">
                                            <option value="" selected="">Select</option>
                                            @forelse ($shiftstatus as $allshiftstatus)
                                            <option value="{{ $allshiftstatus->id }}">{{ $allshiftstatus->name }}</option>

                                            @empty

                                            @endforelse

                                               </select>
                                       </div>
                                    </div>
                                </div>
                                       <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Start </label>
                                                <input type="text" class="form-control" id="basicDate1" name="start" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Finish</label>
                                                <input type="text" class="form-control" id="basicDate2" name="finish" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                <div class="col-lg-12">
                                 <div class="search_btn">
                                 <button type="submit" class="btn btn-primary "><i class="fe fe-search"></i> Search</button>
                                  <a href="{{ route('admin.shift.report') }}" class="btn btn-info "><i class="fe fe-refresh-ccw"></i> Clear Filter</a>
                                  <button type="submit" class="btn btn-green "> <i class="fa fa-file-excel-o"></i> Download Excel</button>
                                  <button type="submit" class="btn btn-green "><i class="fa fa-file-excel-o"></i> Import Excel</button>

                                 </div>
                                </div>
                            </div>
                          </form>
                        </div>

                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header">
                    <div class="top_section_title">
                       <h5>All Driver Report</h5>
                       <!-- <a href="person-add.php" class="btn btn-primary">+ Add New Person</a> -->
                    </div>

                </div>
                        <div class="card-body">
                        <div class="table_box">
                        <table id="basic-datatable example"  class="table table-bordered mb-0">
                            <thead class="border-top">
                                <tr>

                                    <th class="bg-transparent border-bottom-0">Id</th>
                                    <th class="bg-transparent border-bottom-0">Client</th>
                                    <!-- <th class="bg-transparent border-bottom-0">Cost Center</th> -->
                                    <th class="bg-transparent border-bottom-0">Driver</th>
                                    <th class="bg-transparent border-bottom-0">REGO</th>
                                    <th class="bg-transparent border-bottom-0">Vehicle Type</th>
                                    <th class="bg-transparent border-bottom-0">State</th>
                                    {{-- <th class="bg-transparent border-bottom-0">Pda</th> --}}
                                    <!-- <th class="bg-transparent border-bottom-0">Date Start</th>
                                    <th class="bg-transparent border-bottom-0">Date Finish</th> -->
                                    <th class="bg-transparent border-bottom-0">Base</th>
                                    <th class="bg-transparent border-bottom-0">Status</th>
                                    <th class="bg-transparent border-bottom-0">Total Payable</th>
                                    <th class="bg-transparent border-bottom-0">Traveled KM</th>

                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                               @forelse ($shift as $allshift)

                                <tr class="border-bottom">
                                            <td class="td sorting_1">{{ $loop->iteration }}</td>
                                            <td class="td">{{ $allshift->getClientName->name??'N/A' }}</td>
                                            <td class="td">{{ $allshift->getDriverName->userName??'N/A' }}</td>
                                            <td class="td">{{ $allshift->rego??'N/A' }}</td>
                                            <td class="td">{{ $allshift->getVehicleType->name??'N/A' }}</td>
                                            <td class="td">{{ $allshift->getStateName->name??'N/A' }}</td>
                                            <td class="td">{{ $allshift->base??'N/A' }}</td>

                                            <td class="td">

                                                   @if ($allshift->shiftStatus=='1')

                                                     <span class="btn btn-primary-light status_">Approved</span>
                                                    @elseif($allshift->shiftStatus=='2')

                                                    <span class="btn btn-primary-light status_">In progress</span>
                                                    @elseif ($allshift->shiftStatus=='3')

                                                    <span class="btn btn-primary-light status_">Paid</span>
                                                    @elseif ($allshift->shiftStatus=='4')

                                                    <span class="btn btn-primary-light status_">Rejected</span>
                                                    @elseif ($allshift->shiftStatus=='5')

                                                    <span class="btn btn-primary-light status_">Approve</span>
                                                    @else

                                                    <span class="btn btn-primary-light status_">Unapprove</span>
                                                    @endif
                                            </td>

                                            <td class="td"><span id="span_status_31240">{{'N/A' }}</span>
                                            </td>
                                            <td class="td">{{'N/A' }}</td>
                                            {{-- <td class="td">{{'N/A' }}</td> --}}
                                                        <td>
                                                            <div class="g-2 d-flex">
                                                                {{-- @if(in_array("52", $arr))
                                                            <a onClick='addItem(`{{ $allshift->id }}`)' class="btn text-green btn-sm"><span class="ti-check-box fs-14"></span></a>
                                                            @if(in_array("48", $arr)) --}}

                                                            @if(in_array("53", $arr))
                                                            <a class="btn text-info btn-sm" href="{{ route('admin.shift.report.view', ['id' => $allshift->id]) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-original-title="View"><span
                                                                            class="fe fe-eye fs-14"></span></a>
                                                            @endif

                                                        @if(in_array("42", $arr))
                                                            <a class="btn text-primary btn-sm" href="{{ route('admin.shift.report.edit', ['id' => $allshift->id]) }}"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-original-title="Edit"><span
                                                                    class="fe fe-edit fs-14"></span></a>
                                                        @endif

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
     </div>
</div>
</div>

@endsection
