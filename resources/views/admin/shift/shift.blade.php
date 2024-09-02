@extends('admin.layout')
@section('content')
<?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }
   ?>
<!--app-content open-->
<div class="main-content app-content mt-0">
   <!-- PAGE-HEADER -->
   <div class="page-header">
      <h1 class="page-title">Shifts</h1>
      <div>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shifts</li>
            <!-- <li class="breadcrumb-item " aria-current="page">Manage Role</li> -->
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
                     <div class="top_section_title_">
                        <div class="left">
                           <h5 class="m-0">All Shifts</h5>
                        </div>
                        <form action="{{ route('admin.shift') }}" method="post">@csrf
                        <div class="right">
                           <div class="check_box_">
                              <div class="form-group m-0">
                                 <select class="form-control select2 form-select" name="shiftStatus" data-placeholder="Choose one">
                                    <option value="1" {{ $status == 1 ? 'selected="selected"' : '' }}>Active</option>
                                    <option value="2" {{ $status == 2 ? 'selected="selected"' : '' }}>Inactive</option>
                                 </select>
                              </div>
                           </div>
                           <div class="search_btn m-0">
                              <button type="submit" class="btn btn-info srch_btn">Search</button>
                              @if(in_array("48", $arr))
                              <a href="{{ route('admin.shift.add') }}" class="btn btn-primary srch_btn">+ Add New Shift</a>
                             @endif
                           </div>
                         </div>
                        </form>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="table_box">
                        <table id="basic-datatable"  class="table table-bordered text-nowrap mb-0">
                           <thead class="border-top">
                              <tr>
                                 <th class="bg-transparent border-bottom-0">Id</th>
                                 <th class="bg-transparent border-bottom-0">Client</th>
                                 <th class="bg-transparent border-bottom-0">State</th>
                                 <th class="bg-transparent border-bottom-0">Vehicle Type</th>
                                 <th class="bg-transparent border-bottom-0">Rego</th>
                                 <th class="bg-transparent border-bottom-0">Odometer Start</th>
                                 <th class="bg-transparent border-bottom-0">Driver</th>
                                 <th class="bg-transparent border-bottom-0">Status</th>
                                 <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                            @forelse ($shift as $allshifts)
                              <tr class="border-bottom">
                                 <td>#00{{ $loop->iteration }}</td>
                                 <td>{{ $allshifts['getClientName']->name??'N/A'}}</td>
                                 <td>{{ $allshifts['getStateName']->name??'N/A'}}</td>
                                 <td>{{ $allshifts['getVehicleType']->name??'N/A'}}</td>
                                 <td>{{ $allshifts->rego }}</td>
                                 <td>{{ $allshifts->odometer }}</td>
                                 <td>{{  App\Models\Driver::whereId($allshifts->driverId)->first()->userName??'N/A' }}</td>
                                 <td>
                                    <?php
                                    if ($allshifts->finishStatus=='0') { ?>
                                    <span class="btn btn-primary-light status_">Created</span>
                                    <?php } elseif($allshifts->finishStatus=='1'){ ?>
                                    <span class="btn btn-danger status_">In Progress</span>
                                    <?php  } elseif($allshifts->finishStatus=='2') { ?>
                                    <span class="btn btn-primary-light status_" onclick="approveAndReject
                                    (`{{ $allshifts->id }}`)">To Be Approved</span>
                                    <?php } elseif ($allshifts->finishStatus=='3') { ?>
                                        <span class="btn btn-primary-light status_">Approved</span>
                                    <?php } elseif ($allshifts->finishStatus=='4') { ?>
                                        <span class="btn btn-primary-light status_">Rejected</span>
                                    <?php } elseif ($allshifts->finishStatus=='5')  { ?>
                                        <span class="btn btn-primary-light status_" onclick="shiftPaid(`{{ $allshifts->id }}`)" >Paid</span>
                                    <?php } else { ?>
                                            <?php } ?>
                                 </td>
                                 <td>
                                    <div class="g-2 route_btn">
                                        @if(in_array("50", $arr))
                                       <a class="btn btn-info" href="{{ route('admin.shift.report.view', ['id' => $allshifts->id]) }}"
                                          data-bs-toggle="tooltip"
                                          data-bs-original-title="View"><span
                                          class="fe fe-eye fs-14"></span></a>
                                          @endif
                                          @if(in_array("49", $arr))
                                       <a class="btn btn-primary" href="{{ route('admin.shift.report.edit', ['id' => $allshifts->id]) }}"
                                          data-bs-toggle="tooltip"
                                          data-bs-original-title="Edit"><span
                                          class="fe fe-edit fs-14"></span></a>
                                          @endif
                                          @if(in_array("51", $arr))
                                       <a href="{{ route('admin.shift.parcels'  , ['id' => $allshifts->id] )}}" class="btn btn-parcel" ><i class="fe fe-box"></i> Parcel Details</a>
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
<script>
    function approveAndReject(shiftId)
        {
            var shiftId = shiftId;
            $("#AppendshiftId").val(shiftId);
            $("#approveAndRejected").modal('show');
        }
function approved()
{
    $("#approveAndRejected").modal('hide');
   var shiftId= $("#AppendshiftId").val();
   var label="Shift";
        swal({
                title: "Are you sure?",
                text: "Do you want to approved this shift !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.shiftapprove')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Shift!',
                                    text: 'Shift Approved Successfully',
                                    timer: 1000
                                });
                                 window.setTimeout(function(){ } ,1000);
                                location.reload();
                                if(that){
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }
                        },
                            error: function(data) {
                        }
                    });
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }
    function rejected()
    {
        $("#approveAndRejected").modal('hide');
        var shiftId= $("#AppendshiftId").val();
        var label="Shift";
        swal({
                title: "Are you sure?",
                text: "Do you want to Rejected this shift !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.shiftRejected')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Shift!',
                                    text: 'Shift Rejected Successfully',
                                    timer: 1000
                                });
                                window.setTimeout(function(){ } ,1000);
                                location.reload();
                                if(that){
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }
                        },
                            error: function(data) {
                        }
                    });
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }
function shiftPaid(shiftId) {
   var label="Address";
        swal({
                title: "Are you sure?",
                text: "Do you want to Paid !",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.shift.shiftPaid')}}",
                        data: {
                            "shiftId": shiftId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Paid!',
                                    text: 'Shift Paid Successfully',
                                    timer: 1000
                                });
                                window.setTimeout(function(){ } ,1000);
                                location.reload();
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
