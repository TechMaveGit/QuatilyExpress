@extends('admin.layout')
@section('content')

<style>

.form-check-input:checked {
    background-color: var(--primary-bg-color) !important;
    border-color: var(--primary-bg-color) !important;
}
.dark-mode .form-check-input {
    width: 20px;
    height: 20px;
}
    </style>

<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Administration</h1>
        <div>
              <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Administration</li>
                <li class="breadcrumb-item"><a href="{{ route('administration.role') }}">Manage Role</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Role</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

 <form action="{{route('admin.viewRole')}}" method="post"> @csrf
    <div class="side-app">
        <input type="hidden" name="roleId" value="{{ $id }}" />

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card_h">
                                <div class="top_section_title">
                                    <h5>Edit Role</h5>
                                </div>
                            </div>
                           <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Role Name</label>
                                        <input type="text" class="form-control" name="name" value="{{$roleDetail->name}}" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="">
                                    </div>

                                    @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif


                                </div>

                                {{-- <div class="col-lg-6">
                                    <div>
                                       <label for="basiInput" class="form-label">Status</label>
                                       <select class="form-select  mb-3" name="status" aria-label="Default select example" fdprocessedid="wnnmvq" required="">
                                          <option>Select</option>
                                          <option value="1" {{ $roleDetail->status == 1 ? 'selected="selected"' : '' }}>Active</option>
                                          <option value="0" {{ $roleDetail->status == 0 ? 'selected="selected"' : '' }}>Inactive</option>
                                       </select>
                                    </div>
                                 </div> --}}

                                <div class="col-lg-12">
                                    <div class="check_box">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control">{{ $roleDetail->description }}</textarea>
                                    </div>
                                </div>



                                 </div>
                          </div>

                    </div>

                </div>

            </div>
        </div>
    </div>



   <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <div class="row">



                @if($roleDetail->name!=="Driver")


                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Admin Dashboard</h5>
                            </div>
                        </div>


                        <div class="card-body card_body_h">

                          <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                                <th>Menu / Action	</th>
                                <th>View Dashboard</th>
                                 <th>View ( All Fleet Details )</th>
                                 <th>View (Total Cost Chart )</th>

                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td class="text-">Dashboard</td>
                                        @foreach($permission as $key=>$value)
                                            @if ($value->verify_status=='70')
                                                <td>
                                                    <div class="form-check">


                                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>



                                                        <label class="form-check-label" for="autoSizingCheck2a">

                                                            </label>
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                </tr>

                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif


                @if($roleDetail->name=="Driver")
                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Driver Dashboard</h5>
                            </div>
                        </div>


                        <div class="card-body card_body_h">

                          <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Show Dashboard</th>
                            <th>View</th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td class="text-">Dashboard</td>
                                        @foreach($permission as $key=>$value)
                                            @if ($value->verify_status=='69')
                                                <td>
                                                    <div class="form-check">

                                                        @if($roleDetail->name=="Driver")
                                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                                        @endif

                                                        @if($roleDetail->name!=="Driver")
                                                        <input class="form-check-input" type="checkbox" id="autoSizingCheck2a" disabled>
                                                        <p>Any add for driver Role
                                                        @endif

                                                        <label class="form-check-label" for="autoSizingCheck2a">

                                                            </label>
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                </tr>

                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif



                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Administration</h5>
                            </div>
                        </div>


                        <div class="card-body card_body_h">

                          <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>View</th>
                            {{-- <th>Delete</th> --}}
                            </tr>
                            </thead>
                            <tbody>

                            <tr>

                            <td class="text-">Manage Role</td>

                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='1')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach

                            </tr>





                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                 <!-------------------------- 4  -->
                 <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5> Vehicle Type</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            {{-- <th>Delete</th> --}}
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="text-">Add Type</td>
                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='17')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>








                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>State</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                                <td class="text-">State</td>
                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='18')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>







                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>System Configuration
                                </h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                            <th>Menu / Action</th>
                            <th>Add Reminders Configuration</th>
                            <th>Add Email for reminders</th>
                            <th>Add Email for user password</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td class="text-"> Reminders Configuration</td>
                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='71')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>




                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>





                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Expenses Sheet</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td class="text-"> General Expenses</td>
                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='12')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>


                            <tr>
                                <td class="text-">Toll Expenses</td>
                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='13')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>


                            <tr>
                                <td class="text-">Operation Expenses</td>
                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='14')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>






                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>




                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Expense Dashboard</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                            <th>Menu / Action</th>
                            <th>View</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>

                            <td class="text-">Expense Dashboard</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='67')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>












                <!-------------------------- ---------------------->
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Shift Management</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                             <th>Add Shift </th>
                            <th>Add Miss Shift</th>
                            <th>Approve</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>View Parcels</th>
                            <th>Import</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>
                                <td class="text-">Shift Report</td>

                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='15')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach

                                @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='16')
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                            <label class="form-check-label" for="autoSizingCheck2a">

                                                </label>
                                        </div>
                                    </td>
                                @endif
                                @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>














                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Person</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>View</th>
                            <th>Edit</th>

                            <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                            <td class="text-">Person</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='4')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach

                            </tr>





                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Clients</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                            <td class="text-">Client</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='7')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach

                            </tr>

                            {{-- <tr>
                            <td class="text-">Cost Center</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='6')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach


                            </tr> --}}



                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Vehicle</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>View</th>
                            <th>Edit</th>

                            <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                            <td class="text-">Vehicle</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='8')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>




                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Delivery Tracking</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                            <th>Menu / Action</th>
                            <th>View</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                            <td class="text-">Delivery Tracking</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='68')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Current Live Tracking</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                            <th>Menu / Action</th>
                            <th>View</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                            <td class="text-">Current Live Tracking</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='72')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Inspection</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>

                            <th>Menu / Action</th>
                            <th>Add</th>
                            <th>View</th>
                            <th>Edit</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr>
                            <td class="text-">Inspection</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='9')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                            </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>





                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Induction</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                            <tr>
                                <th>Menu / Action</th>
                                <th>Add</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>View</th>
                                <th>View Signature</th>
                                @if($roleDetail->name=="Driver")
                                <th>Add Signature</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>

                            <tr>

                            <td class="text-">Induction</td>
                            @foreach($permission as $key=>$value)
                                @if ($value->verify_status=='10')
                                        @if($value->id == '88')
                                            @if($roleDetail->name=="Driver")
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                                    <label class="form-check-label" for="autoSizingCheck2a">

                                                    </label>
                                                </div>
                                            </td>
                                            @endif
                                        @else
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                                <label class="form-check-label" for="autoSizingCheck2a">

                                                    </label>
                                            </div>
                                        </td>
                                        @endif
                                @endif
                            @endforeach
                            </tr>

                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12">
                    <div class="card">
                       <div class="card-header card_h">
                            <div class="top_section_title">
                                <h5>Induction Driver</h5>
                            </div>
                        </div>
                        <div class="card-body card_body_h">
                        <table class="table table-bordered table-hover mb-0" id="RoleTbl">
                            <thead>
                                <tr>

                                <th>Menu / Action</th>
                                <th>View </th>
                                {{-- <th>View Signature</th> --}}
                                </tr>
                                </thead>
                                <tbody>



                            <tr>

                            <td class="text-">Induction Driver (Document)</td>
                            @foreach($permission as $key=>$value)
                            @if ($value->verify_status=='11')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="permission[]" value="{{$value->id}}" type="checkbox" id="autoSizingCheck2a" <?php if(in_array($value->id,$array)){ echo "checked";}?>>
                                        <label class="form-check-label" for="autoSizingCheck2a">

                                        </label>
                                    </div>
                                </td>
                            @endif
                            @endforeach
                            </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>







                <div class="bottom_footer_dt">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="action_btns text-end">

                                <button type="submit" class="theme_btn btn btn-primary" fdprocessedid="b0iy9w"><i class="ti-save"></i> Save </button>

                            </div>
                        </div>
                    </div>
                </div>
                    </div>

                </div>
            </div>


</form>




    @endsection

