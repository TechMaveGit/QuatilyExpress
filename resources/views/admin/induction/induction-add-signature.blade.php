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

                           <form action="{{route('induction.uploadSignature',['id'=>'1'])}}" method="post" enctype="multipart/form-data"> @csrf
                                <div class="top_dt_sec">
                                    <div class="row">

                                        <?php
                                        $driverRole=  Auth::guard('adminLogin')->user();
                                        if($driverRole->role_id='33')
                                            {
                                                $email=$driverRole->email;
                                                $driverId=DB::table('drivers')->where('email',$email)->first()->id??'';
                                                ?>
                                            <input type="hidden" name="driverName" value="{{ $driverId }}" />
                                            <input type="hidden" name="induction_id" value="{{ $induction_id }}" />
                                            <?php }  else {?>
                                            @php
                                                $driverRole='';
                                            @endphp
                                                <?php } ?>



                                        <div class="col-lg-12">
                                            <div class="check_box">
                                                <label class="form-label" for="exampleInputEmail1">Upload Signature</label>
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
