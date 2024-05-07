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

<style>
    .dt-buttons{
        margin-left: -158px;
    }
    .dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fff;
}
    </style>


   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
            </div>
            <form action="{{route('deleterole')}}" method="post"/>@csrf
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






<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Administration</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Administration</li>
            <li class="breadcrumb-item active" aria-current="page">Manage Role</li>

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
                       <h5>All Roles </h5>

                       @if(in_array("1", $arr))
                       <a href="{{ route('administration.role.add') }}" class="btn btn-primary" style="margin: 3px">+ Add New Role</a>
                       @endif
                    </div>
                    <a class="btn btn-green" style="color: white;" id="exportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a>


                </div>

                <div class="card-body">
                  <div class="table-responsive">
                    {{-- <table id="example" class="table table-bordered mb-0" style="margin: 0px !important;width: 100%;"> --}}
                        <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">
                        <thead class="border-top">
                                <tr>

                                    <th class="bg-transparent border-bottom-0">S.NO</th>
                                    <th class="bg-transparent border-bottom-0">Role Type</th>

                                    <th class="bg-transparent border-bottom-0">Description</th>
                                    <th class="bg-transparent border-bottom-0">Date</th>
                                    {{-- <th class="bg-transparent border-bottom-0">Status</th> --}}
                                    <th class="bg-transparent border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($roles as $role)
                                @php
                                     $dateTime = new DateTime($role->created_at);
                                     $created_at = $dateTime->format('Y/m/d H:i:s');
                                @endphp

                                <tr>
                                    <td class="id"><a href="javascript:void(0);" class="fw-medium link-primary">{{ $loop->iteration }}</a></td>
                                    <td class="">{{ $role->name }}</td>
                                    <td class="">{{ Str::limit($role->description,25)}}</td>
                                    <td class="">{{ $created_at}}</td>

                                    {{-- <td class="">
                                       @if ($role->status=='1')
                                       Active
                                       @endif
                                       @if ($role->status=='0')
                                       Inactive
                                      @endif
                                    </td> --}}

                                    <td>
                                        <div class="g-2">

                                            @if(in_array("2", $arr))
                                            <a class="btn text-primary btn-sm" href="{{ route('edit.role.permission',['id'=>$role->id]) }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit"><span
                                                    class="fe fe-edit fs-14"></span></a>
                                                    @endif


                                                    @if(in_array("3", $arr))
                                                    <a href="{{ route('view.role.permission',['id'=>$role->id]) }}" class="btn text-info btn-sm"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="View"><span
                                                            class="fe fe-eye fs-14"></span></a>
                                                            @endif


                                                            @if(in_array("4", $arr))
                                            {{-- <a onclick="remove_user_role({{$role->id}})" class="btn text-danger btn-sm"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Delete"><span
                                                    class="fe fe-trash-2 fs-14"></span></a> --}}
                                                    @endif

                                        </div>
                                    </td>

                                          {{-- <td>
                                                 <div class="dropdown d-inline-block">
                                                     <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                         <i class="ri-more-fill align-middle"></i>
                                                     </button>
                                                     <ul class="dropdown-menu dropdown-menu-end" style="">
                                                         <li><a class="dropdown-item edit-item-btn" href="{{url('admin/edit-role')}}/{{ $role->id}}"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a></li>
                                                         <li><a class="dropdown-item edit-item-btn" href="{{url('admin/view-role-permission')}}/{{ $role->id}}"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                                                         <li>
                                                             <a  onclick="remove_user_role({{$role->id}})" class="dropdown-item remove-item-btn">
                                                                 <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                             </a>
                                                         </li>
                                                     </ul>
                                                 </div>
                                             </td> --}}
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
    <!-- CONTAINER END-->
</div>
 </div>



 <script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        exportToExcel('custom_table');
    });

    function exportToExcel(tableId) {
        const table = document.getElementById(tableId);
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        const filename = 'role.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>





 <style>
    .dt-button.dropdown-item.buttons-columnVisibility.active {
  background-color: #282618; /* Replace with your desired color code */
  /* You can also add other styles as needed */
}

.brdcls .select2-selection__rendered{
    border-color: red;
    height: 40px;
    line-height: 20px;
    border: 1px solid #ccc;
    padding: 0px 5px;
    border-radius: 4px;
}


    .status-ToBeApr{
    color: #2ecc71;
    background-color: #2ecc7114;
    padding: 3px 10px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 12px;
}
    .dt-buttons{
        margin-left: -158px;
    }
    .btncls {
	padding-left: 4px !important;
	padding-right: 4px !important;
	margin: 0px !important;
	min-width: 0px !important;
	margin-right: 4px !important;
}
.flex_div {
    display: flex;
    width: 100%;
}
.filter_flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.flex_div .btn-green {
    padding-right: 35px;
    margin-left: 10px;
}

    </style>

<style>
    .table td {
    padding: 4px 8px;
}
    .flex-wrap{
         margin-left: -127px;
         margin-top: 20px;
    }
    /* data table customoization */

  .tabltoparea #export-button-container button{
    margin-right: 5px;
  }
  div.dataTables_wrapper {
    overflow-x: scroll;
  }
  .entries_pagination{
    display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 20px;
  }
  .tabltoparea {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
</style>


 <style>
    .sweet-alert button.cancel {
        background-color: #c0a611 !important;
    }
    </style>



<script>
    function remove_user_role(id)
        {
            var id = id;
            $('#hidden_class').val(id);
            $("#deleteRecordModal").modal('show');

        }

    </script>





@endsection

