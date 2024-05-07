<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from brandio.io/envato/iofrm/html/login4.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 14 Sep 2023 11:08:03 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Express</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/login-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/login-assets/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/login-assets/css/iofrm-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/assets/login-assets/css/iofrm-theme4.css')}}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/assets/images/newimages/imgpsh_fullsize_anim (1).png')}}">

</head>
<body>
    <style>
   .logo {
    margin-top: 16px;
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}
        .img-holder {
    width: 603px;
    background-color: #704608;
}
.form-content {
    background-color: #ffffff;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.form-content::before {
    content: '';
    background: rgba(0,0,0,0.5);
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}


.form-content .form-items {
    max-width: 526px !important;
    text-align: left;
    background: #fff !important;
    padding: 20px !important;
    border-radius: 10px !important;
}


.form-content .form-items {
    position: relative;
}
    </style>
    <div class="form-body">
        <div class="website-logo">
            <a href="#">

            </a>
        </div>
        <div class="row">
            <div class="form-holder">
                <div class="form-content" style="background-image:url({{ asset('public/assets/login-assets/images/55595f1018.jpeg')}})">
                    <div class="form-items">
                        <div class="logo">
                            <img class="logo-size" src="{{ asset('public/assets/login-assets/images/logo-qe.png')}}" style="width: 183px;" alt="">
                        </div>

                        <h3>Welcome back!</h3>
                        <p>Enter your email address and password to access admin panel.</p>
                        <div class="page-links">
                            <a href="login.php" class="active">Login</a>
                        </div>
                        <form action="{{route('admin.login')}}" class="adminlogin_form" method="post"/>

                        @csrf
                            <input class="form-control" type="text"  name="email" placeholder="E-mail Address" autocomplete="off" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off" required>
                            @if (\Session::has('success'))
                            <div class="">

                                  <p style="display: contents;
                                     color: red;">{!! \Session::get('success') !!}</p>

                            </div>
                            @endif
                            <div class="form-button">

                                <button id="submit" type="submit" class="ibtn">Login</button>



                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ asset('public/assets/login-assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('public/assets/login-assets/js/popper.min.js')}}"></script>
<script src="{{ asset('public/assets/login-assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('public/assets/login-assets/js/main.js')}}"></script>
</body>

</html>
