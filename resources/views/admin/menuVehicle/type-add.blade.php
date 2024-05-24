@extends('admin.layout')
@section('content')

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Induction Add</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home_page')}}">Home</a></li>
            <li class="breadcrumb-item " aria-current="page">Induction</li>
            <li class="breadcrumb-item active" aria-current="page">Induction Add</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="card">
            <div class="card-body p-0">
            <div class="main_bx_dt__">

                           <form action="{{route('induction.add')}}" method="post" enctype="multipart/form-data"> @csrf
                                <div class="top_dt_sec">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Name</label>
                                                <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Status</label>
                                                <div class="form-group">

                                                <select class="form-control select2 form-select" name="status" data-placeholder="Choose one">
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>

                                            </select>
                                       </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Upload File</label>
                                                        <div class="form-group">
                                                          <input name="uploadFile" type="file" class="dropify" data-height="100" required/>
                                                        </div>
                                                    </div>

                                                    </div>


                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">

                                            <button type="submit" class="btn btn-primary" fdprocessedid="cgqwgp">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </form>


                            </div>
                            <!-- main_bx_dt -->
            </div>
        </div>
     </div>
</div>
</div>
@endsection
