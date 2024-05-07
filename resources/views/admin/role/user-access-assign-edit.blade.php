



@extends('admin.layout')
@section('content')


<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Administration</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Administration</li>
            <li class="breadcrumb-item active" aria-current="page">Assign Role Edit</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="row">
        <div class="col-lg-12">


                <form action="{{route('administration.assignEdit',['id'=>$users->id])}}" method="post"> @csrf
                    <div class="card">
                        <div class="card-header card_h">
                                <div class="top_section_title">
                                    <h5>Assign Role Edit</h5>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">User name</label>
                                        <div class="form-group">

                                         <input type="text" class="form-control"  value="{{ $users->name }}" name="name" autocomplete="off" />

                                       </div>
                                    </div>
                                </div>



                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Email</label>
                                        <div class="form-group">

                                            <input type="email" class="form-control" value="{{ $users->email }}" name="email" />
                                        </div>
                                    </div>
                                </div>






                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Password</label>
                                        <div class="form-group">

                                         <input type="password" class="form-control" name="password"/>
                                       </div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Select Role</label>
                                        <div class="form-group">

                                           <select class="form-control select2 form-select" name="role_id" data-placeholder="Choose one">
                                            @foreach ($roles as $allrole)
                                            <option value="{{$allrole->id}}" {{$allrole->id == $users->role_id ? 'selected' : '' }}>{{$allrole->name}}</option>
                                            @endforeach

                                               </select>
                                       </div>
                                    </div>
                                </div>



                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Status</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="status" data-placeholder="Choose one" required>
                                                   <option value="">Select Status</option>
                                                   <option value="1" {{$users->status == 1 ? 'selected' : '' }}>Active</option>
                                                   <option value="0" {{$users->status == 0 ? 'selected' : '' }}>Inactive</option>

                                               </select>
                                       </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="bottom_footer_dt">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="action_btns text-end">
                                        <button type="submit" class="theme_btn btn btn-primary"><i class="ti-save"></i> Save </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                </div>
        </div>
     </div>
</div>
</div>




@endsection
