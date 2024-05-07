@extends('admin.layout')
@section('content')

<style>
.headerCLS{
    display: flex;
    justify-content: end;
}
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


<?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }
   ?>

   <!-- delete Modal -->
    <div class="modal fade zoomIn" id="editStateForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header headerCLS">

                    <button type="button" class="close customClose" data-bs-dismiss="modal"  aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <form action="{{ route('state.edit') }}" method="post"/>@csrf

                <div class="col-lg-12">

                    <div class="mb-3">

                        <label class="form-label" for="exampleInputEmail1">State Name <span class="red">*</span></label>

                        <input type="text" class="form-control" name="stateName" id="stateName" aria-describedby="emailHelp" placeholder="" fdprocessedid="gfd6b">

                        <br>

                        <div class="form-group">
                            <select class="form-control select2 form-select" id="editstate" name="state" data-placeholder="Choose one" style="adding: 7px 16px;}">
                             <option value="">Select Any One</option>
                                <option value="1" >Active</option>
                                <option value="2" >Inactive</option>
                            </select>
                       </div>



                        <input type="hidden" class="form-control" name="stateId" id="stateId" aria-describedby="emailHelp" placeholder="" fdprocessedid="gfd6b">

                    </div>

                </div>

                <div class="bottom_footer_dt">

                    <div class="row">

                        <div class="col-lg-12">

                            <div class="action_btns text-end">

                                <button type="submit" value="Submit" class="btn btn-primary" fdprocessedid="cxhrte"><i class="bi bi-save"> </i> Edit State</button>

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
   <div class="modal fade zoomIn" id="deleteState" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="{{ route('state.delete') }}" method="post"/>@csrf
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        {{-- <h4>Are you Sure ?</h4> --}}
                        <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Record ?</p>
                    </div>
                    <input type="hidden" name="stateId" id="stateDeleteId" value=""/>

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
    <h1 class="page-title">State</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Administration</li>
            <li class="breadcrumb-item active" aria-current="page">State</li>

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
                            <form action="{{ route('state') }}" method="post"> @csrf
                                <div class="row align-items-center">

                                    <div class="col-lg-3">

                                        <div class="mb-3">

                                            <label class="form-label" for="exampleInputEmail1">State Name<span class="red">*</span></label>

                                            <input type="text" class="form-control" id="exampleInputEmail1" name="stateName" aria-describedby="emailHelp" placeholder="" fdprocessedid="3jf91" required>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">
                                    <div class="search_btn">

                                        @if(in_array("64", $arr))
                                        <button type="submit" class="btn btn-primary srch_btn" fdprocessedid="cgqwgp">Add State</button>
                                        @endif
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
                       <h5>All State</h5>
                    </div>

                </div>
                        <div class="card-body">
                        <div class="table-responsive">

                        {{-- <table id="basic-datatable"  class="table table-bordered text-nowrap mb-0"> --}}
                            <table id="custom_table" class="table table-hover mb-0" style="margin: 0px !important;width: 100%;">

                            <thead class="border-top">
                                <tr>
                                    <th class="bg-transparent border-bottom-0">S.No</th>
                                    <th class="bg-transparent border-bottom-0">State Name</th>
                                    <th class="bg-transparent border-bottom-0">Status</th>
                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                  @forelse ($state as $key=> $allstate)

                                  <tr class="border-bottom">
                                    <td class="td sorting_1">{{ $key+1  }}</td>
                                    <td class="td sorting_1">{{ $allstate->name }}</td>
                                    @if ($allstate->status=='1')
                                    <td class="td sorting_1">Active</td>
                                    @else
                                    <td class="td sorting_1">InActive</td>
                                    @endif


                                    <td>
                                        <div class="g-2">
                                            @if(in_array("65", $arr))
                                             <a onclick="showEditForm('{{ $allstate->id }}','{{ $allstate->name }}',{{ $allstate->status }})" class="btn text-primary btn-sm"  data-bs-toggle="tooltip" data-bs-original-title="Edit"><span
                                                    class="fe fe-edit fs-14"></span></a>
                                                    @endif

                                                    @if(in_array("66", $arr))
                                                    <a onclick="deleteState('{{ $allstate->id }}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
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
    function showEditForm(id,stateName,satus)
        {
            $('#editstate').val(satus).trigger('change');
            var id = id;
            $('#stateId').val(id);
            $('#stateName').val(stateName);
            $("#editStateForm").modal('show');

        }
</script>

<script>
    function deleteState(id)
        {
          //  alert(id);
            var id = id;
            $('#stateDeleteId').val(id);
            $("#deleteState").modal('show');

        }

</script>



@endsection
