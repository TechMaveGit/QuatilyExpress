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



   <!-- delete Modal -->
    <div class="modal fade zoomIn" id="editTypeForm" tabindex="-1" aria-hidden="true">
        {{-- <div class="modal fade" id="editTypeForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header headerCLS">

                    <button type="button" class="close customClose" data-bs-dismiss="modal"  aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>



                    {{-- <button type="button" class="close customClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button> --}}
                </div>
                <form action="{{ route('vehicle.vehicleTypeEdit') }}" method="post"/>@csrf

                <div class="col-lg-12">

                    <div class="mb-3">

                        <label class="form-label" for="exampleInputEmail1">Type Name <span class="red">*</span></label>

                        <input type="text" class="form-control" name="typeName" id="typeName" aria-describedby="emailHelp" placeholder="" fdprocessedid="gfd6b" required>
                        <input type="hidden" class="form-control" name="typeId" id="typeId" aria-describedby="emailHelp" placeholder="" fdprocessedid="gfd6b">

                    </div>

                </div>

                <div class="bottom_footer_dt">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="action_btns text-end">

                                <button type="submit" value="Submit" class="btn btn-primary" fdprocessedid="cxhrte"><i class="bi bi-save"> </i>Save</button>

                            </div>

                        </div>

                    </div>

                </div>




            </form>
            </div>
        </div>
    </div>
<!--end modal -->





   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="deletetype" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('vehicle.vehicleTypeDelete') }}" method="post"/>@csrf
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        {{-- <h4>Are you Sure ?</h4> --}}
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                    <input type="hidden" name="typeId" id="typeDeleteId" value=""/>

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
    <h1 class="page-title">Vehicle Type</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Adminstration</a></li>
            <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
            <li class="breadcrumb-item active" aria-current="page">Vehicle type</li>

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
                        <div class="card-body">
                            <form action="{{ route('vehicle.vehicleType') }}" method="post"> @csrf
                                <div class="row align-items-center">

                                    <div class="col-lg-3">

                                        <div class="mb-3">

                                            <label class="form-label" for="exampleInputEmail1">Vehicle type<span class="red">*</span></label>

                                            <input type="text" class="form-control" id="exampleInputEmail1" name="typeName" aria-describedby="emailHelp" placeholder="" fdprocessedid="3jf91" required>

                                        </div>

                                    </div>

                                    <div class="col-lg-3 ps-0">
                                    <div class="search_btn">
                                        @if(in_array("61", $arr))
                                        <button type="submit" class="btn btn-primary srch_btn" fdprocessedid="cgqwgp">Add Type</button>
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card brdcls">
                    <div class="card-header">
                    <div class="top_section_title">
                       <h5>All vehicle type</h5>
                    </div>
                    {{-- <a class="btn btn-green" style="color: white;" id="exportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a> --}}


                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">


                            <thead class="border-top">
                                <tr>
                                    <th class="bg-transparent border-bottom-0">S.No</th>
                                    <th class="bg-transparent border-bottom-0">Type Name</th>
                                    <th class="bg-transparent border-bottom-0" style="width: 20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                  @forelse ($type as $key=> $alltype)

                                  <tr class="border-bottom">
                                    <td class="td sorting_1">{{ $key+1  }}</td>
                                    <td class="td sorting_1">{{ $alltype->name }}</td>
                                    <td>
                                        <div class="g-2">
                                            @if(in_array("62", $arr))
                                             <a onclick="showEditForm('{{ $alltype->id }}','{{ $alltype->name }}')" class="btn text-primary btn-sm"  data-bs-toggle="tooltip" data-bs-original-title="Edit"><span
                                                    class="fe fe-edit fs-14"></span></a>
                                                    @endif

                                                    @if(in_array("63", $arr))
                                                    <a onclick="deleteType('{{ $alltype->id }}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
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
    $(document).ready(function() {
        var table = $('#example').DataTable({

            "scrollX": true, // Enable horizontal scrolling if needed
            "paging": true, // Enable pagination
            "searching": true, // Enable searching
            "fixedHeader": true, // Keep the header fixed while scrolling
            "dom": 'lBfrtip', // Include buttons, column visibility, and length menu
            "buttons": [
                'colvis', // Add the column visibility button
                 'excel'
            ],
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Customize entries dropdown options
            "pageLength": 10 // Set default page length
        });
    });
</script>



{{--




<script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        // Call function to export table data to Excel
        exportToExcel('example');
    });

    function exportToExcel(tableId) {
        const table = document.getElementById(tableId);
        const ws = XLSX.utils.table_to_sheet(table);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        const filename = 'shift-report.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>
 --}}


<script>
    function showEditForm(id,typeName)
        {
          //  alert(id);
            var id = id;
            $('#typeId').val(id);
            $('#typeName').val(typeName);
            $("#editTypeForm").modal('show');

        }
</script>

<script>
    function deleteType(id)
        {
          //  alert(id);
            var id = id;
            $('#typeDeleteId').val(id);
            $("#deletetype").modal('show');

        }

</script>



@endsection
