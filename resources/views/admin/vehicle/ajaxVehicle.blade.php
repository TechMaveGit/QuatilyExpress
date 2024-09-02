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

@php
    
    $driverRole =  Auth::guard('adminLogin')->user()->role_id;
@endphp


<!-- delete Modal -->

<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close customClose" data-bs-dismiss="modal"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{route('vehicle.delete')}}" method="post" />@csrf

            <div class="modal-body">

                <div class="mt-2 text-center">

                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">

                        {{-- <h4>Are you Sure ?</h4> --}}



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







<!--app-content open-->

<div class="main-content app-content mt-0">

    <!-- PAGE-HEADER -->

    <div class="page-header">

        <h1 class="page-title">Vehicles</h1>

        <div>

            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>

                <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->

                <li class="breadcrumb-item active" aria-current="page">Vehicles</li>



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

                            <div class="row align-items-center">



                                <form action="{{ route('vehicle.ajaxTable') }}" method="post">@csrf

                                    <div class="col-lg-4">

                                        <div class="check_box">

                                            <label class="form-label" for="exampleInputEmail1">Status</label>

                                            <div class="form-group">

                                                <select class="form-control select2 form-select" name="checkStatus" data-placeholder="Choose one">
                                                    <option value="1" {{ $checkStatus == "1" ? 'selected="selected"' : '' }}>Active</option>
                                                    <option value="2" {{ $checkStatus == "2" ? 'selected="selected"' : '' }}>Inactive</option>
                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="search_btn">

                                            <button type="submit" class="btn btn-primary srch_btn">Search</button>
                                            <a href="{{ route('vehicle') }}" class="btn btn-danger srch_btn">Reset</a>

                                        </div>

                                    </div>

                                </form>



                            </div>



                        </div>

                    </div>



                </div>


                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-header">

                            <div class="top_section_title">

                                <h5>All Vehicles</h5>
                                <?php
                          $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
                          $arr = [];
                          foreach($D as $v)
                          {
                            $arr[] = $v['permission_id'];
                          }
                          ?>

                                @if(in_array("25", $arr))
                                <a href="{{ route('vehicle.add') }}" class="btn btn-primary">+ Add New Vehicle</a>
                                @endif



                            </div>
                            @if($driverRole!=33)
                            <a class="btn btn-green" style="color: white; margin: 3px;"  id="exportBtn" > <i class="fa fa-file-excel-o"></i> Download Excel</a>


                            @endif


                        </div>

                        <div class="card-body">

                            <div class="table-responsive">


                            <table id="basic-datatable_client" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">

                                <thead class="border-top">
                                    <tr>
                                        <th>id</th>
                                        <th>Rego</th>
                                        <th>Type</th>
                                        <th>Odometer</th>
                                        <th>Model</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>




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
$(document).ready( function ()
{
            $('#basic-datatable_client').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": "{{ route('getAjaxData') }}",
                        "columns": [
                            { "data": "id" },
                            { "data": "Rego"},
                            { "data": "Type"},
                            { "data": "Odometer"},
                            { "data": "Model"},
                            { "data": "Status"},
                            { "data": "Action"}
                        ]
            });
});
</script>



<script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        exportToExcel('custom_table');
    });

    function exportToExcel(tableId) {
        const table = document.getElementById(tableId);
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        const filename = 'vehicle.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>



{{--
<script>
    $(document).ready(function(){
      // Attach a change event handler to the dropdown
      $("#myDropdown").change(function(){   alert("ok");
        // Get the selected value
        var selectedValue = $(this).val();

        // Show an alert with the selected value
        alert("Selected Value: " + selectedValue);
      });
    });
  </script> --}}


<script>
    function remove_vehicle(id)

    {

        var id = id;

        $('#hidden_class').val(id);

        $("#deleteRecordModal").modal('show');



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



                url: "{{ route('vehicle.status') }}",



                data: {
                    clientId: clientId
                    , statusValue: statusValue
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

@endsection
