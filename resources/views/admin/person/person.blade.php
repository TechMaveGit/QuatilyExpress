@extends('admin.layout')
@section('content')
<style>
.dark-mode .customClose{
    font-size: 25px;
    padding: 0pc;
    color: #fff;
    display: flex;
    justify-content: center;
    height: 30px;
    background: transparent;
    border: none;
}
.light-mode .customClose {
    font-size: 25px;
    padding: 0pc;
    color: #000 !important;
    display: flex;
    justify-content: center;
    height: 30px;
    background: transparent;
    border: none;
}
</style>
<!-- delete Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close customClose" data-bs-dismiss="modal"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('person.deletePerson')}}" method="post" />@csrf
            <div class="modal-body">
                <div class="mt-2 text-center">
                    {{-- <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon> --}}
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                    <input type="hidden" name="common" id="hidden_class" value="" />
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
@if(in_array("9", $arr) || in_array("10", $arr) || in_array("11", $arr) || in_array("12", $arr) )
 <!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Person</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
            <li class="breadcrumb-item active" aria-current="page">Person</li>
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
                            <form action="{{route('person')}}" method="post">@csrf
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Name</label>
                                        <input type="text" class="form-control fc-datepicker" name="name" value="{{ $name }}" id="" aria-describedby="emailHelp" placeholder="" fdprocessedid="u0f1z">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Email</label>
                                        <input type="text" class="form-control fc-datepicker" name="email" id="" value="{{ $email }}" aria-describedby="emailHelp" placeholder="" fdprocessedid="u0f1z">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Status</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="selectStatus" data-placeholder="Choose one">
                                            <option value="">Select Any One</option>
                                                   <option value="1" {{ $status == 1 ? 'selected="selected"' : '' }}>Active</option>
                                                   <option value="2" {{ $status == 2 ? 'selected="selected"' : '' }}>Inactive</option>
                                               </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                 <div class="search_btn">
                                 <button type="submit" class="btn btn-primary srch_btn">Search</button>
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
                       <h5>All Person</h5>
                       @if(in_array("9", $arr))
                       <a href="{{ route('person.add') }}" class="btn btn-primary" style="margin: 3px ">+ Add New Person</a>
                       @endif
                    </div>
                    <a class="btn btn-green" style="color: white;" id="personexportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a>
                    {{-- <a  class="btn btn-green srch_btn ms-3" id="exportBtn" style="color: white;"> <i class="fa fa-file-excel-o"></i> Download Excel</a> --}}
                </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">
                            <thead class="border-top">
                                <tr>
                                    <th hidden></th>
                                    <th class="bg-transparent border-bottom-0">Id</th>
                                    <th class="bg-transparent border-bottom-0">Name</th>
                                    <th class="bg-transparent border-bottom-0">Surname</th>
                                    <th class="bg-transparent border-bottom-0">Email</th>
                                    <th class="bg-transparent border-bottom-0">Role</th>
                                    <th class="bg-transparent border-bottom-0">Status</th>
                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($person as $allperson)
                                    <tr class="border-bottom">
                                        <td hidden></td>
                                        <td>{{ $allperson->id}}</td>
                                        <td>{{ $allperson->userName	 }} {{ $allperson->surname	 }}</td>
                                        <td>{{ $allperson->surname }}</td>
                                        <td>{{ $allperson->email }}</td>
                                        <td>{{ $allperson->roleName->name ?? '' }}</td>
                                        <td>
                                            <div class="form-group">
                                                    <select class="form-control select2 form-select" onchange="changeStatus('{{$allperson->id}}',this)" data-placeholder="Choose one">
                                                            <option value="1" {{ $allperson->status == 1 ? 'selected="selected"' : '' }}>Active</option>
                                                            <option value="2" {{ $allperson->status == 2 ? 'selected="selected"' : '' }}>Inactive</option>
                                                    </select>
                                                    <p id="message{{ $allperson->id	 }}" class="message"></p>
                                                </div>
                                        </td>
                                        <td>
                                                <div class="g-2">
                                                    @if(in_array("10", $arr))
                                                <a class="btn text-info btn-sm" href="{{ route('person.view', ['id' => $allperson->id]) }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="View"><span
                                                            class="fe fe-eye fs-14"></span></a>  @endif
                                                            @if(in_array("11", $arr))
                                                    <a class="btn text-primary btn-sm" href="{{ route('person.edit', ['id' => $allperson->id]) }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Edit"><span
                                                            class="fe fe-edit fs-14"></span></a> @endif
                                                            @if(in_array("12", $arr))
                                                                <a class="btn text-danger btn-sm" onclick="remove_vehicle({{ $allperson->id}})" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
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
    function remove_vehicle(id)
    {
        var id = id;
        $('#hidden_class').val(id);
        $("#deleteRecordModal").modal('show');
    }
</script>
<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"></script>
<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/jquery-3.7.0.js">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    document.getElementById('personexportBtn').addEventListener('click', function () {
        // Call function to export table data to Excel
        exportToExcel('custom_table');
    });
    function exportToExcel(tableId) {
        const table = document.getElementById(tableId);
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        const filename = 'person.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>
<script>
    function changeStatus(personId,select)
    {
        if (!pagrLoaded) {
            var statusValue=select.value;
            var personId=personId;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url:"{{ route('personStatus') }}",
                data:{personId:personId,statusValue:statusValue},
                success:function(data){
                    if (data.success==200) {
                        $("#message"+personId+"").text("Status Changed Successfully...");
                        $("#message"+personId+"").fadeIn('fast');
                    }
                }
            });
            setTimeout(function() {
                $("#message"+personId+"").fadeOut('fast');
            }, 1000);
        }
    }
</script>
@endif
@endsection
