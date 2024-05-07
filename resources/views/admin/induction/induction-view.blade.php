@extends('admin.layout')
@section('content')

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Induction View</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item " aria-current="page">Induction</li>
            <li class="breadcrumb-item active" aria-current="page">Induction Edit</li>

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

                                <div class="top_dt_sec">
                                    <div class="row">

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $inductionDetail->title }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Description</label>
                                                <input type="textarea" class="form-control" name="description" value="{{ $inductionDetail->description }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" disabled>
                                            </div>
                                        </div>



                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Status</label>
                                                <div class="form-group">

                                                <select class="form-control select2 form-select" name="status" data-placeholder="Choose one" disabled>
                                                <option value="1" {{ $inductionDetail->status == 1 ? 'selected="selected"' : '' }}>Active</option>
                                                <option value="0" {{ $inductionDetail->status == 0 ? 'selected="selected"' : '' }}>Inactive</option>

                                               </select>
                                                  </div>
                                            </div>
                                        </div>
                                                <div class="col-lg-12">
                                                    <div class="check_box">
                                                        {{-- <label class="form-label" for="exampleInputEmail1">View Upload File</label> --}}
                                                        <div class="form-group">

                                                            <a href="{{ asset('public/assets/Induction/image/'.$inductionDetail->uploadFile.'')}}" target="_blank">View Document
                                                            </a>

                                                        </div>
                                                    </div>

                                                    </div>


                                    </div>
                                </div>

                            </div>
                            <!-- main_bx_dt -->
            </div>
        </div>
     </div>
</div>
</div>
@endsection
