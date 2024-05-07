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

   <style>
    .dt-buttons{
        margin-left: -158px;
    }
    </style>

   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <form action="{{route('delete.access.role')}}" method="post"/>@csrf
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you Sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                    <input type="hidden" name="common" id="hidden_class" value=""/>

                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="sumit" class="btn w-sm btn-danger " id="delete-record">Yes, Delete It!</button>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
<!--end modal -->







 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Administration</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Administration</li>
            <li class="breadcrumb-item active" aria-current="page">User Access Role</li>

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
                       <h5>All Users Access Detail</h5>
                       @if(in_array("5", $arr))
                       <a href="{{ route('administration.userAccessAssign') }}" class="btn btn-primary">Assign Role</a>
                        @endif
                    </div>

                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered table-striped dt-responsive nowrap w-100" style="margin: 0px !important;width: 100%;">

                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($userDetail as $alluserDetail)
                            <tr role="row" class="odd">
                                <td class="sorting_1">{{ $loop->iteration }}</td>
                                <td class="sorting_1">{{ $alluserDetail->name}}</td>
                                <td>{{ $alluserDetail->email }}</td>
                                <td>
                                    @php
                                      echo $userRole= DB::table('roles')->where('id',$alluserDetail->role_id)->first()->name??'N/A';
                                    @endphp
                                </td>
                                <td>
                                    <span class="btn btn-primary-light status_">{{$alluserDetail->status == 1 ? 'Active' : 'Inactive' }} </span>
                                   </td>
                                <td>
                                <div class="g-2">
                                    @if(in_array("6", $arr))
                                        <a class="btn text-primary btn-sm" href="{{ route('administration.assignEdit',['id'=>$alluserDetail->id]) }}"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Edit"><span
                                                class="fe fe-edit fs-14"></span></a>
                                                @endif

                                    @if(in_array("69", $arr))
                                    <a onclick="remove_user_role({{$alluserDetail->id}})" class="btn text-danger btn-sm"
                                        data-bs-toggle="tooltip"
                                        data-bs-original-title="Delete"><span
                                            class="fe fe-trash-2 fs-14"></span></a>
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


<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"></script>

<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/jquery-3.7.0.js">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>



<script>
    // Initialize DataTable with Buttons
    $(document).ready(function() {
      $('#example').DataTable( {
          dom: 'Bfrtip',
          buttons: [
              'colvis'
          ]
      } );
  } );
  </script>




<script>
    function remove_user_role(id)
        {
            var id = id;
            $('#hidden_class').val(id);
            $("#deleteRecordModal").modal('show');

        }

    </script>




@endsection



