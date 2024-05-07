@extends('admin.layout')
@section('content')
<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">My Profile</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <!-- <li class="breadcrumb-item" aria-current="page">Shift</li> -->
                <li class="breadcrumb-item active" aria-current="page">My Profile</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->




<div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
 <!-- ROW-1 OPEN -->
 <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Reset password</div>
                                    </div>


                                    <form method="POST" action="{{ route('admin.updatePassword') }}"> @csrf
                                        <div class="card-body">
                                        <div class="text-center chat-image mb-5">
                                            <div class="avatar avatar-xxl chat-profile mb-3 brround">
                                                <a class="" href="#"><img alt="avatar" src="{{ asset('public/assets/images/users/21.jpg')}}" class="brround"></a>
                                            </div>
                                            <div class="main-chat-msg-name">
                                                <a href="#">
                                                    <h5 class="mb-1 text-dark fw-semibold">{{ Auth::guard('adminLogin')->user()->name }}</h5>
                                                </a>
                                                <p class="text-muted mt-0 mb-0 pt-0 fs-13"> @php
                                                        $roleId=Auth::guard('adminLogin')->user()->role_id;
                                                        @endphp
                                                        @if($roleId==1)
                                                        Admin
                                                        @else
                                                        @php
                                                       $name= DB::table('roles')->where('id',$roleId)->first()->name;
                                                       echo $name;
                                                       @endphp
                                                        @endif</p>
                                            </div>
                                        </div>


                                        <div class="form-group toggle-container">
                                            <label class="form-label">Old Password</label>
                                            <div class="wrap-input100 validate-input input-group"  id="Password-toggle1">
                                                <input type="password" class="input100 form-control pswd"   name="old_password"  placeholder="New Password">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="fa fa-eye fa-eye-slash togglePassword"></i>
                                                </a>

                                            </div>
                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>



                                        <div class="form-group toggle-container">
                                            <label class="form-label">New Password</label>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle1">

                                                <input type="password" class="input100 form-control pswd" name="new_password"  placeholder="New Password">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="fa fa-eye fa-eye-slash togglePassword"></i>
                                                </a>

                                            </div>
                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="wrap-input100 validate-input input-group" id="Password-toggle2">
                                                <input type="password" class="input100 form-control pswd"  name="confirmed"  placeholder="Confirm Password">
                                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                                    <i class="fa fa-eye fa-eye-slash togglePassword"></i>
                                                </a>


                                            </div>
                                            @error('new_password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button type="submit" href="javascript:void(0)" class="btn btn-primary">Update</button>
                                    </div>
                                </form>

                                </div>

                            </div>
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Personal Details</h3>
                                    </div>
                                    <form action="{{ route('admin.profile') }}" method="post"> @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleInputname">First Name</label>
                                                    <input type="text" class="form-control" name="name" value="{{ Auth::guard('adminLogin')->user()->name??'' }}" id="exampleInputname" placeholder="First Name">
                                                    <input type="hidden" name="userId" value="{{ Auth::guard('adminLogin')->user()->id??'' }}"/>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-12">
                                                <div class="form-group">
                                                   <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" name="email" value="{{  Auth::guard('adminLogin')->user()->email }}" id="exampleInputEmail1" placeholder="Email address">

                                        </div>
                                            </div>



                                        </div>



                                    </div>
                                    <div class="card-footer text-end">
                                        <input type="submit"  class="btn btn-success my-1" value="submit"/>
                                    </div>
                                    </form>
                                </div>


                            </div>
                        </div>


          <script>
document.querySelectorAll('.togglePassword').forEach(el => {
  el.addEventListener('click', e => {
    let password = el.closest('.toggle-container').querySelector('.pswd');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    e.target.classList.toggle('fa-eye-slash');
  });
});
            </script>


                        <!-- ROW-1 CLOSED -->
        </div>
</div>

</div>
@endsection
