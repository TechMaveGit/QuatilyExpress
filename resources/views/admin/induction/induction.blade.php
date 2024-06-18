@extends('admin.layout')
@section('content')


<?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }
//   echo "<pre>";
//   print_r($arr); die;
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

            <form action="{{route('induction.delete')}}" method="post" >@csrf

            <div class="modal-body">

                <div class="mt-2 text-center">

                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>

                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">

                        <h4>Are you Sure ?</h4>

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
    <h1 class="page-title">Induction</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
            <li class="breadcrumb-item active" aria-current="page">Induction</li>

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


                            <form action="{{ route('induction') }}" method="post"> @csrf
                                <div class="row align-items-center">
                                    <div class="col-lg-4">
                                        <div class="check_box">
                                            <label class="form-label" for="exampleInputEmail1">Status</label>
                                            <div class="form-group">

                                            <select class="form-control select2 form-select" name="selectStatus">
                                                    <option value="1" {{ $selectStatus == '1' ? "selected" : "" }}>Active</option>
                                                    <option value="0" {{ $selectStatus == '0' ? "selected" : "" }}>Inactive</option>
                                                </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="search_btn">
                                        <button type="submit" class="btn btn-primary srch_btn" fdprocessedid="cgqwgp">Search</button>


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
                            <h5>  All Induction Document</h5>


                            @if(in_array("71", $arr))
                            <a href="{{ route('induction.add') }}"  style="margin: 2px" class="btn btn-primary">+ Add New Induction</a>
                            @endif

                            </div>

                            <a class="btn btn-green" style="color: white;" id="exportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a>

                        </div>

                        <div class="card-body">
                        <div class="table-responsive">
                        <table id="custom_table"  class="table table-bordered text-nowrap mb-0">
                            <thead class="border-top">
                                <tr>

                                    <th class="bg-transparent border-bottom-0">Id</th>

                                    <th class="bg-transparent border-bottom-0">Title</th>
                                    <th class="bg-transparent border-bottom-0">Description</th>
                                    <th class="bg-transparent border-bottom-0">File</th>

                                    <th class="bg-transparent border-bottom-0">status</th>
                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>



                           @forelse ($induction as $allinduction)

                                <tr class="border-bottom">
                                <td class="td sorting_1">{{ $allinduction->id }}</td>

                                <td class="td sorting_1">{{ $allinduction->title }}</td>

                                <td class="td sorting_1">{{ Str::of($allinduction->description)->words(8, '...'); }}</td>

                                <td class="td sorting_1">
                                    @php
                                        $whole1 = explode('.',$allinduction->uploadFile);
                                        $whole = $whole1[1];
                                    @endphp
                                    @if($whole=='pdf')
                                    <a href="{{asset(env('STORAGE_URL').$allinduction->uploadFile.'')}}" target="_blank" title="Read PDF">Open PDF</a>

                                    @else
                                    <a href="{{asset(env('STORAGE_URL').$allinduction->uploadFile.'')}}" target="_blank" title="Read PDF">Open Image</a>

                                    @endif
                               </td>

                               <td class="td sorting_1"> {{ $allinduction->status == 1 ? 'Active' : 'Inactive' }}</td>


                                     <td>
                                         <div class="g-2">

                                            @if(in_array("73", $arr))
                                                  <a class="btn text-danger btn-sm" onclick="remove_induction('{{ $allinduction->id }}')" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                            @endif

                                                @if(in_array("72", $arr))
                                                    <a class="btn text-primary btn-sm" href="{{ route('induction.edit', ['id' => $allinduction->id]) }}" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>
                                                @endif

                                                @if(in_array("74", $arr))
                                                <a class="btn text-info btn-sm" href="{{ route('induction.view', ['id' => $allinduction->id]) }}"
                                                    data-bs-toggle="tooltip" data-bs-original-title="View"><span class="fe fe-eye fs-14"></span></a>
                                                    @endif

                                                    @if(in_array("75", $arr))
                                                    <a class="btn btn-info" href="{{ route('induction.driver', ['id' => $allinduction->id]) }}"
                                                    data-bs-toggle="tooltip" data-bs-original-title="View Signature"><span class="fa-regular fa-signature">View Signature</span></a>
                                                    @endif

                                                    @if(in_array("88", $arr))
                                                    <?php
                                                    $driverRole=  Auth::guard('adminLogin')->user();
                                                    if($driverRole->role_id=='33') { ?>
                                                    <a class="btn btn-info" href="{{ route('induction.upload.signature', ['id' => $allinduction->id]) }}"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Add Signature"><span class="fa-regular fa-signature">Add Signature</span></a>
                                                    <?php } ?>
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
    function remove_induction(id)

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




<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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






@endsection
