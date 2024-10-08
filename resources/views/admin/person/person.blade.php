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
#basic-datatable_person_wrapper .dropdown.colum_visibility_ak:nth-child(odd){
    display: none !important;
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
            <form action="{{route('person.deletePerson')}}" method="post">
                @csrf
            <div class="modal-body">
                <div class="mt-2 text-center">
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
   $driverRole = Auth::guard('adminLogin')->user()->role_id;
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
                            <form action="{{route('person')}}" id="filterFormData" method="post">@csrf
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
                    @if ($driverRole != 33)
                    <button class="btn btn-green" style="color: white; margin: 4px;"
                    onclick="window.location='{{ route('export.person', request()->input()) }}'"><i
                        class="fa fa-file-excel-o"></i>Download Excel</button>
                    @endif
                    
                </div>
                        <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable_person" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">
                            <thead class="border-top">
                                <tr>
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
<script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css"></script>

<!-- Include DataTables Buttons CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/jquery-3.7.0.js">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js">
</script>
<script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js">
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    var table;
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        var formData = new FormData($('#filterFormData')[0]);
        table = $('#basic-datatable_person').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('person.ajax.table') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.form = {};
                    for (var pair of formData.entries()) {
                        d.form[pair[0]] = pair[1];
                    }
                }
            },
            "columns": [{
                    "data": "Id"
                },
                {
                    "data": "Name"
                },
                {
                    "data": "Surname"
                },
                {
                    "data": "Email"
                },
                {
                    "data": "Role"
                },
                {
                    "data": "Status"
                },
                {
                    "data": "Action"
                }
            ]
        });

        var columns = table.columns().header().toArray();
    var columnVisibilityDropdown = '<div class="dropdown colum_visibility_ak" style="display:inline-block;">' +
      '<button class="btn btn-warning dropdown-toggle" type="button" id="columnVisibilityDropdown" data-bs-toggle="dropdown" aria-expanded="false">Column Visibility</button>' +
      '<div class="dropdown-menu custom_dp_menu" aria-labelledby="columnVisibilityDropdown">';
    columns.forEach(function(column, index) {
      columnVisibilityDropdown += '<div class="form-check"><input class="form-check-input column-toggle" type="checkbox" value="' + $(column).text() + '" id="Checkme' + index + '" checked><label class="form-check-label" for="Checkme' + index + '">' + $(column).text() + '</label></div>';
    });
    columnVisibilityDropdown += '</div></div>';
    $('.dataTables_length').parent().append(columnVisibilityDropdown);
    table.buttons().container().appendTo($('.dataTables_length').parent());
    $('.column-toggle').on('change', function() {
      var columnIndex = $(this).parent().index();
      table.column(columnIndex).visible(this.checked);
    });
    });
</script>
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
