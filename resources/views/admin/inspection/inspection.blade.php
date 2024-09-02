@extends('admin.layout')
@section('content')



<?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }
   $driverRole=  Auth::guard('adminLogin')->user()->role_id;
   ?>


<style>
    .dt-buttons{
        margin-left: -158px;
    }
    </style>



<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Inspections</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <!-- <li class="breadcrumb-item" aria-current="page">Administration</li> -->
            <li class="breadcrumb-item active" aria-current="page">Inspections</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
    <div class="row">

                <div class="col-lg-12 p-0">
                    <div class="card">
                    <div class="card-header">
                    <div class="flexMobile">
                    <div class="top_section_title">
                       <h5>All Inspections</h5>
                    </div>
                    <div class="ActionBtn scrollBtn">
                    @if(in_array("29", $arr))
                       <a href="{{ route('inspection.add') }}" style="margin: 3px;" class="btn btn-primary">+ Add New Inspection</a>
                       @endif
                       @if ($driverRole != 33)
                    <a class="btn btn-green" style="color: white;" id="exportBtn"> <i class="fa fa-file-excel-o"></i> Download Excel</a>
                    @endif
                     </div>
                    </div>
                   
                  

                </div>
                        <div class="card-body">
                        <div class="">
                        <table id="custom_table"  class="table table-bordered text-nowrap mb-0"  style="margin: 0px !important;width: 100%;">
                            <thead class="border-top">
                                <tr>
                                    <th class="bg-transparent border-bottom-0">Item Id</th>
                                    <!--<th class="bg-transparent border-bottom-0">Driver Name</th>-->
                                    <th class="bg-transparent border-bottom-0">Rego</th>
                                    <th class="bg-transparent border-bottom-0">Comments</th>
                                    <th class="bg-transparent border-bottom-0">Date Inspection</th>
                                    <?php
                                           
                                             if($driverRole!='33')
                                             { ?>
                                    <th class="bg-transparent border-bottom-0">Inspection Done By</th>
                                    <?php }?>
                                    <!-- <th class="bg-transparent border-bottom-0">status</th> -->
                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @forelse ($inspection as $key=>$allinspection)
                                    <tr class="border-bottom">
                                        <td class="td sorting_1">{{ $key+1 }}</td>
                                        @php
                                        $ewgoNumbe=DB::table('vehicals')->where('id',$allinspection->regoNumber)->first()->rego??'N/A';
                                        @endphp

                                        <td class="td">{{$ewgoNumbe}}</td>
                                        <td class="td">{{ Str::of($allinspection->Notes)->words(6, '...')}}</td>
                                        <td class="td">{{$allinspection->created_at}}</td>


                                           <?php
                                             if($driverRole!='33')
                                             { ?>
                                                    @if ($allinspection->driverInspections=='1')
                                                    <td>
                                                        <span class="btn btn-primary-light status_">{{ $allinspection->getAppDriver->userName??'' }} {{ (isset($allinspection->getAppDriver->surname) && $allinspection->getAppDriver->surname!='N/A') ? $allinspection->getAppDriver->surnam :'' }}</span>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <span class="btn btn-danger" style="padding: 2px 12px;">Admin Side</span>
                                                    </td>
                                                    @endif
                                        <?php } else{ ?>

                                            <?php } ?>


                                        <td>
                                        <div class="d-flex">
                                            @if(in_array("31", $arr))
                                            <a class="btn text-info btn-sm" style="margin: 3px " href="{{ route('inspection.view', ['id'=>$allinspection->id]) }}"

                                                data-bs-toggle="tooltip"

                                                data-bs-original-title="View"><span

                                                    class="fe fe-eye fs-14"></span></a>
                                                    @endif


                                                    @if(in_array("79", $arr))
                                                    <a class="btn text-primary btn-sm" style="margin: 3px " href="{{ route('inspection.edit', ['id'=>$allinspection->id]) }}"

                                                        data-bs-toggle="tooltip"

                                                        data-bs-original-title="Edit"><span

                                                            class="fe fe-edit fs-14"></span></a>
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
        const filename = 'inspection.xlsx';
        XLSX.writeFile(wb, filename);
    }
</script>



@endsection
