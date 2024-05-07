
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

 <!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">System Configuration</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Administration</li>
            <li class="breadcrumb-item active" aria-current="page">System Configuration</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="row">
        <div class="col-xl-12">
            <div class="card show_portfolio_tab">
                <div class="card-header">
                    <ul class="nav nav-tabs">


                        @if(in_array("85", $arr))
                        <li class="nav-item">
                            <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span><i class="fe fe-grid"></i></span>
                                <span> Reminders Configuration</span>
                            </a>
                        </li>
                        @endif

                        @if(in_array("86", $arr))
                        <li class="nav-item">
                            <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                                <span><i class="fe fe-mail"></i></span>
                                <span> Email for reminders </span>
                            </a>
                        </li>
                        @endif


                        @if(in_array("87", $arr))
                        <li class="nav-item">
                            <a href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                <span><i class="fe fe-sliders"></i></span>
                                <span>Email for user password </span>
                            </a>
                        </li>
                        @endif


                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content  text-muted">
                        <div class="tab-pane show active" id="home">

                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Passport expire</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Police Certificate expire</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before VISA expire</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Driver License expire</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Induction expire</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Rego Due Date</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Service Due Date</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Days before Inspection Due Date</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- main_bx_dt -->
                        </div>
                        <div class="tab-pane " id="profile">
                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">

                                    <div class="col-md-6">
                                        <div class="editor_top">
                                          <h5>Email Template for a Expired Document</h5>
                                          <div class="template_action">
                                            <a href="#" class="btn btn-primary"><i class="fe fe-eye"></i></a>
                                            <a href="#" class="btn btn-info"><i class="fe fe-send"></i></a>
                                          </div>
                                        </div>

                                <div class="card card_edt">

                                    <div class="card-body">

                                        <div id="summernote">
                                            <p>Hello Summernote</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                        <div class="editor_top">
                                          <h5>Email Template for a Expired Rego</h5>
                                          <div class="template_action">
                                            <a href="#" class="btn btn-primary"><i class="fe fe-eye"></i></a>
                                            <a href="#" class="btn btn-info"><i class="fe fe-send"></i></a>
                                          </div>
                                        </div>

                                <div class="card card_edt">

                                    <div class="card-body">

                                        <div id="summernote1">
                                            <p>Hello Summernote</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                        <div class="editor_top">
                                          <h5>Email Template for a Expired Service</h5>
                                          <div class="template_action">
                                            <a href="#" class="btn btn-primary"><i class="fe fe-eye"></i></a>
                                            <a href="#" class="btn btn-info"><i class="fe fe-send"></i></a>
                                          </div>
                                        </div>

                                <div class="card card_edt">

                                    <div class="card-body">

                                        <div id="summernote2">
                                            <p>Hello Summernote</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                        <div class="editor_top">
                                          <h5>Email Template for a Expired Inspection</h5>
                                          <div class="template_action">
                                            <a href="#" class="btn btn-primary"><i class="fe fe-eye"></i></a>
                                            <a href="#" class="btn btn-info"><i class="fe fe-send"></i></a>
                                          </div>
                                        </div>

                                <div class="card card_edt">

                                    <div class="card-body">

                                        <div id="summernote3">
                                            <p>Hello Summernote</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- main_bx_dt -->

                        </div>

                        <div class="tab-pane email_template" id="messages">
                        <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                    <div class="row">

                                    <div class="col-md-6">
                                        <div class="editor_top">
                                          <h5>Email Template for a Lost Password</h5>
                                          <!-- <div class="template_action">
                                            <a href="#" class="btn btn-primary"><i class="fe fe-eye"></i></a>
                                            <a href="#" class="btn btn-info"><i class="fe fe-send"></i></a>
                                          </div> -->
                                        </div>

                                <div class="card card_edt">

                                    <div class="card-body">

                                        <div id="summernote5">
                                            <p>Hello Summernote</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                        <div class="editor_top">
                                          <h5>Email Template for a New User</h5>
                                          <!-- <div class="template_action">
                                            <a href="#" class="btn btn-primary"><i class="fe fe-eye"></i></a>
                                            <a href="#" class="btn btn-info"><i class="fe fe-send"></i></a>
                                          </div> -->
                                        </div>

                                <div class="card card_edt">

                                    <div class="card-body">

                                        <div id="summernote6">
                                            <p>Hello Summernote</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                    </div>
                                </div>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
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
        </div>
     </div>
</div>
</div>



@endsection
