@extends('admin.layout')
@section('content')
    <?php
    $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()), true);
    $arr = [];
    foreach ($D as $v) {
        $arr[] = $v['permission_id'];
    }
    ?>


    <style>
        .old {
            display: none;
        }
    </style>



    <style>
        .dt-buttons {
            margin-left: -158px;
        }
    </style>
    <style>
       .dropdown.colum_visibility_ak:nth-child(odd){
    display: none !important;
}

.dropdown.colum_visibility_ak {
  top: 23px;
  margin-left: 20px;
}
        /* .colum_visibility_ak {
            display: none !important;
        } */
    </style>



    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->

        <div class="page-header">

            <h1 class="page-title">Clients</h1>

            <div>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                    <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->

                    <li class="breadcrumb-item active" aria-current="page">Clients</li>



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




                                <form action="{{ route('clients') }}" id="filterFormData" method="post"> @csrf

                                    <div class="row align-items-center">



                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Name</label>
                                                <input type="text" class="form-control fc-datepicker" name="name"
                                                    value="{{ $name }}" id="" aria-describedby="emailHelp"
                                                    placeholder="" fdprocessedid="u0f1z">
                                            </div>

                                        </div>

                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Mobile No</label>
                                                <input type="text" class="form-control fc-datepicker" name="mobileNo"
                                                    value="{{ $mobileNo }}" id="" aria-describedby="emailHelp"
                                                    placeholder="" fdprocessedid="u0f1z">
                                            </div>

                                        </div>


                                        <div class="col-lg-4">
                                            <div class="check_box">
                                                <label class="form-label" for="exampleInputEmail1">State</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select" name="state"
                                                        data-placeholder="Choose one" style="adding: 7px 16px;}">
                                                        <option value="">Select Any One</option>
                                                        @php
                                                            $states = DB::table('states')->get();
                                                        @endphp
                                                        @foreach ($states as $allstates)
                                                            <option value="{{ $allstates->id }}"
                                                                {{ $allstates->id == $state ? 'selected="selected"' : '' }}>
                                                                {{ $allstates->name }}</option>
                                                        @endforeach


                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="check_box">
                                                <label class="form-label" for="exampleInputEmail1">Status</label>
                                                <div class="form-group">
                                                    <select class="form-control select2 form-select" name="clientStatus"
                                                        data-placeholder="Choose one" style="adding: 7px 16px;}">
                                                        <option value="1"
                                                            {{ $status == 1 ? 'selected="selected"' : '' }}>Active</option>
                                                        <option value="2"
                                                            {{ $status == 2 ? 'selected="selected"' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="col-lg-4">

                                            <div class="search_btn">

                                                <button type="submit" class="btn btn-primary">Search</button>
                                                <a href="{{ route('clients') }}" class="btn btn-danger">Reset</a>

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

                                    <h5>All Clients</h5>

                                    @if (in_array('21', $arr))
                                        <a href="{{ route('client.add') }}" class="btn btn-primary">+ Add New Client</a>
                                    @endif


                                </div>
                                <br>
                                {{-- <a class="btn btn-green" style="color: white; margin: 4px;" id="clientexportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a> --}}
                                <button class="btn btn-green" style="color: white; margin: 4px;"
                                    onclick="window.location='{{ route('export.clients', request()->input()) }}'"><i
                                        class="fa fa-file-excel-o"></i>Download Excel</button>





                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table id="basic-datatable_client" class="table table-hover mb-0"
                                        style="margin: 0px !important;width: 100%;">

                                        <thead class="border-top">

                                            <tr>
                                               
                                                {{-- <th class="bg-transparent border-bottom-0 hidden"></th> --}}

                                                <th class="bg-transparent border-bottom-0">Id</th>

                                                <th class="bg-transparent border-bottom-0">Name</th>

                                                <th class="bg-transparent border-bottom-0">Short Name</th>

                                                <th class="bg-transparent border-bottom-0">Abn</th>

                                                <th class="bg-transparent border-bottom-0">Phone Principal</th>

                                                <th class="bg-transparent border-bottom-0">State</th>

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
        var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            var formData = new FormData($('#filterFormData')[0]);
            table = $('#basic-datatable_client').DataTable({
                "processing": true,
                "serverSide": true,
                // "dom": 'lBfrtip',
                // "buttons": [
                //     'colvis'
                // ],
                "ajax": {
                    "url": "{{ route('clients.ajaxTable') }}",
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
                        "data": "id"
                    },
                    {
                        "data": "Name"
                    },
                    {
                        "data": "Short Name"
                    },
                    {
                        "data": "Abn"
                    },
                    {
                        "data": "Phone Principal"
                    },
                    {
                        "data": "State"
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
        document.getElementById('clientexportBtn').addEventListener('click', function() {
            exportToExcel('basic-datatable_client');
        });

        function exportToExcel(tableId) {
            const table = $('#' + tableId).DataTable();
            const data = table.rows().data().toArray();

            const ws = XLSX.utils.json_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
            const filename = "client{{ date('ymdhisa') }}.xlsx";
            XLSX.writeFile(wb, filename);
        }
    </script>







    <script>
        function changeStatus(clientId, select) {
            if (!pagrLoaded) {
                var statusValue = select.value;
                var clientId = clientId;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('client.status') }}",
                    data: {
                        clientId: clientId,
                        statusValue: statusValue
                    },
                    success: function(data) {
                        if (data.success == 200) {
                            $("#message" + clientId + "").text("Status Changed Successfully...");
                            $("#message" + clientId + "").fadeIn('fast');
                        }
                    }
                });

                setTimeout(function() {

                    $("#message" + clientId + "").fadeOut('fast');

                }, 1000);
            }
        }
    </script>

<script>
    function deleteClient(id) {
        swal({
                title: "Are you sure?",
                text: "Do you want to Delete!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, Skip",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('delete-client') }}",
                        data: {
                            "id": id,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                            if (result > 0) {
                                swal("Deleted!", "Client Deleted successfully.", "success");
                                window.location.reload();
                            } else {
                                swal({
                                    title: 'Error!',
                                    text: 'Something went wrong',
                                    timer: 3000
                                }).then(
                                    function() {},
                                    // handling the promise rejection
                                    function(dismiss) {
                                        if (dismiss === 'timer') {
                                            console.log('I was closed by the timer')
                                        }
                                    }
                                )
                            }
                        },
                        error: function(data) {
                            console.log("error");
                            console.log(result);
                        }
                    });
                } else {
                    swal("Skiped", "Your Client is safe :)", "error");
                }
            });
    }
</script>
@endsection
