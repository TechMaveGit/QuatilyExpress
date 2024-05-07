<body class="app sidebar-mini ltr dark-mode">

    <style>
  .dt-button.dropdown-item.buttons-columnVisibility.active {
  background-color: #282618; /* Replace with your desired color code */
  /* You can also add other styles as needed */
}
.confirm{
            background-color: #4ecc48!important;
        }
        </style>




     <!-- GLOBAL-LOADER -->
     <div id="global-loader">
        <!-- <img src="{{ asset('public/assets/images/loader.svg')}}" class="loader-img" alt="Loader"> -->
        <div class="dot-spinner">
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
            <div class="dot-spinner__dot"></div>
        </div>
    </div>
    <!-- /GLOBAL-LOADER -->


 <?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }

    // echo "<pre>";
    // print_r(Auth::guard('adminLogin')->user());

   ?>

 <script>

    @if(Session::has('message'))

    toastr.options =

    {

        "closeButton" : true,

        "progressBar" : true

    }
        toastr.success("{{ session('message') }}");    @endif
    @if(Session::has('error'))

    toastr.options =

    {

        "closeButton" : true,

        "progressBar" : true

    }

            toastr.error("{{ session('error') }}");

    @endif
    @if(Session::has('info'))

    toastr.options =

    {

        "closeButton" : true,

        "progressBar" : true

    }

            toastr.info("{{ session('info') }}");

    @endif
    @if(Session::has('warning'))

    toastr.options =

    {

        "closeButton" : true,

        "progressBar" : true

    }

  toastr.warning("{{ session('warning') }}");
@endif

</script>

<style>

    .message{

        margin-bottom: 0px;

        padding-top: 6px;

        color: yellow;

        font-weight: bold;

    }

        </style>    <!-- GLOBAL-LOADER -->

    <!-- /GLOBAL-LOADER -->

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            <!-- app-Header -->
            <div class="app-header header sticky">
                <div class="container-fluid main-container">
                    <div class="d-flex">
                        <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
                        <!-- sidebar-toggle-->
                        <a class="logo-horizontal" href="{{route('admin.dashboard')}}">
                            <img src="{{ asset('public/assets/images/newimages/logo-qe.png')}}" class="header-brand-img desktop-logo" alt="logo">
                            <img src="{{ asset('public/assets/images/newimages/logo-qe.png')}}" class="header-brand-img light-logo1"
                                alt="logo">
                        </a>
                        <!-- LOGO -->

                        <div class="d-flex order-lg-2 ms-auto header-right-icons">
                            <!-- SEARCH -->
                            <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                                aria-controls="navbarSupportedContent-4" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                            </button>
                            <div class="navbar navbar-collapse responsive-navbar p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                                    <div class="d-flex order-lg-2">

                                        <div class="d-flex">
                                            <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                                <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                                <span class="light-layout"><i class="fe fe-sun"></i></span>
                                            </a>
                                        </div>


                                        <div class="dropdown d-flex profile-1">
                                            <a href="{{ route('admin.profile') }}" data-bs-toggle="dropdown" class="nav-link leading-none d-flex">
                                                <img src="https://techmavesoftwaredev.com/webclinic/public/assets/doctor_profile/3305b813dfed14d5855588d82841bc82.png" alt="profile-user"
                                                    class="avatar  profile-user brround cover-image">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                                <div class="drop-heading">
                                                    <div class="text-center">
                                                        <h5 class="text-dark mb-0 fs-14 fw-semibold">
                                                        @php
                                                        $roleId=Auth::guard('adminLogin')->user()->role_id;
                                                        @endphp
                                                        @if($roleId==1)
                                                        Admin
                                                            @else
                                                                    @php
                                                                $name= DB::table('roles')->where('id',$roleId)->first()->name;
                                                                echo $name;
                                                                @endphp
                                                            @endif

                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider m-0"></div>
                                                <a class="dropdown-item" href="{{ route('admin.profile')}}">
                                                    <i class="dropdown-icon fe fe-user"></i> Profile
                                                </a>

                                                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                                    <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /app-Header -->            <!--APP-SIDEBAR-->
            <div class="sticky">
                <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
                <div class="app-sidebar">
                    <div class="side-header">
                        <a class="header-brand1" href="{{route('admin.dashboard')}}">
                            <img src="{{ asset('public/assets/images/newimages/logo-qe.png')}}" class="header-brand-img desktop-logo" alt="logo">
                            <img src="{{ asset('public/assets/images/newimages/imgpsh_fullsize_anim (1).png')}}" class="header-brand-img toggle-logo"
                                alt="logo">
                            <img src="{{ asset('public/assets/images/newimages/logo-qe.png')}}" class="header-brand-img light-logo" alt="logo">
                            <img src="{{ asset('public/assets/images/newimages/logo-qe.png')}}" class="header-brand-img light-logo1"
                                alt="logo">
                        </a>
                        <!-- LOGO -->
                    </div>
                    <div class="main-sidemenu">
                        <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                            </svg></div>
                        <ul class="side-menu">
                            <li class="sub-category">
                                <h3></h3>
                            </li>
                            <li class="slide">
                                <a class="side-menu__item has-link {{ (request()->routeIs('admin.dashboard')) ? 'active' : '' }}" data-bs-toggle="slide" href="{{route('admin.dashboard')}}"><i
                                        class="side-menu__icon fe fe-home"></i><span
                                        class="side-menu__label">Dashboard</span></a>
                            </li>


                            @if(in_array("1", $arr) || in_array("2", $arr) || in_array("3", $arr) ||in_array("4", $arr) || in_array("5", $arr) || in_array("6", $arr) || in_array("7", $arr) || in_array("8", $arr) || in_array("61", $arr) || in_array("62", $arr) || in_array("63", $arr)   || in_array("64", $arr) || in_array("65", $arr) || in_array("66", $arr))

                            <li class="slide {{ (request()->routeIs('administration.role')) ? 'is-expanded' : '' }} {{ (request()->routeIs('administration.userAccess')) ? 'is-expanded' : '' }} {{ (request()->routeIs('administration.system-configuration')) ? 'is-expanded' : '' }}  {{ (request()->routeIs('administration.role.add')) ? 'is-expanded' : '' }} {{ (request()->routeIs('view.role.permission')) ? 'is-expanded' : '' }} {{ (request()->routeIs('administration.role.edit')) ? 'is-expanded' : '' }} {{ (request()->routeIs('vehicle.vehicleType')) ? 'is-expanded' : '' }} {{ (request()->routeIs('state')) ? 'is-expanded' : '' }}">
                                <a class="side-menu__item {{ (request()->routeIs('administration.role')) ? 'active' : '' }} {{ (request()->routeIs('administration.userAccess')) ? 'active' : '' }} {{ (request()->routeIs('administration.system-configuration')) ? 'active' : '' }}   {{ (request()->routeIs('administration.role.add')) ? 'active' : '' }} {{ (request()->routeIs('view.role.permission')) ? 'active' : '' }} {{ (request()->routeIs('administration.role.edit')) ? 'active' : '' }}" {{ (request()->routeIs('vehicle.vehicleType')) ? 'active' : '' }} {{ (request()->routeIs('state')) ? 'active' : '' }} data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-unlock"></i><span
                                        class="side-menu__label">Administration</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>


                                @if(in_array("1", $arr) || in_array("2", $arr) || in_array("3", $arr) ||in_array("4", $arr) || in_array("5", $arr) || in_array("6", $arr) || in_array("7", $arr) || in_array("8", $arr) || in_array("61", $arr) || in_array("62", $arr) || in_array("63", $arr) || in_array("64", $arr) || in_array("65", $arr) || in_array("66", $arr))
								<ul class="slide-menu">
									<li class="panel sidetab-menu">
										<div class="panel-body tabs-menu-body p-0 border-0">
											<div class="tab-content">
												<div class="tab-pane active" id="side1">
													<ul class="sidemenu-list">

                                                        @if(in_array("1", $arr) || in_array("2", $arr) || in_array("3", $arr) ||in_array("4", $arr))
                                                        <li><a href="{{ route('administration.role') }}" class="slide-item {{ (request()->routeIs('administration.role')) ? 'active' : '' }} {{ (request()->routeIs('administration.role.add')) ? 'active' : '' }} {{(request()->routeIs('view.role.permission')) ? 'active' : '' }}  {{ (request()->routeIs('administration.role.edit')) ? 'active' : '' }}">Manage Role</a></li>
                                                        @endif


                                                        @if(in_array("85", $arr) || in_array("86", $arr) || in_array("87", $arr))
                                                        <li><a href="{{ route('administration.system-configuration') }}" class="slide-item {{ (request()->routeIs('administration.system-configuration')) ? 'active' : '' }}">System Configuration</a></li>
                                                        @endif

                                                        @if(in_array("61", $arr) || in_array("62", $arr) || in_array("63", $arr))

                                                        <li><a href="{{ route('vehicle.vehicleType') }}" class="slide-item {{ (request()->routeIs('vehicle.vehicleType')) ? 'active' : '' }}">Vehicle Type</a></li>


                                                        @if(in_array("64", $arr) || in_array("65", $arr) || in_array("66", $arr))

                                                        <li><a href="{{ route('state') }}" class="slide-item {{ (request()->routeIs('state')) ? 'active' : '' }}">State</a></li>

                                                        @endif



                                                        @endif



                                                    </ul>

                                                </div>

											</div>
										</div>
									</li>
								</ul>
                                @endif
                            </li>
                            @endif



                            @if(in_array("37", $arr) || in_array("38", $arr) || in_array("41", $arr) || in_array("42", $arr) || in_array("46", $arr) || in_array("47", $arr) || in_array("67", $arr))
                            <li class="slide {{ (request()->routeIs('expense-dashboard')) ? 'is-expanded' : '' }} {{ (request()->routeIs('expense.sheet')) ? 'is-expanded' : '' }}">
                                <a class="side-menu__item {{ (request()->routeIs('expense-dashboard')) ? 'active' : '' }} {{ (request()->routeIs('expense.sheet')) ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti-stats-up"></i><span
                                        class="side-menu__label">Expenses</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
								<ul class="slide-menu mega-slide-menu">
                                    <li class="panel sidetab-menu">

                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="side5">
                                                    <ul class="sidemenu-list mega-menu-list">

                                                        @if(in_array("67", $arr))
                                                        <li><a href="{{ route('expense-dashboard') }}" class="slide-item {{ (request()->routeIs('expense-dashboard')) ? 'active' : '' }}">Expense Dashboard</a></li>
                                                        @endif

                                                        @if(in_array("37", $arr) || in_array("38", $arr) || in_array("41", $arr) || in_array("42", $arr) || in_array("46", $arr) || in_array("47", $arr))
                                                        <li><a href="{{ route('expense.sheet') }}" class="slide-item {{ (request()->routeIs('expense.sheet')) ? 'active' : '' }}">Expense Sheet</a></li>
                                                        @endif
                                                    </ul>

                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            @endif


                            @if(in_array("48", $arr) || in_array("49", $arr) || in_array("50", $arr) || in_array("51", $arr) || in_array("52", $arr) || in_array("53", $arr) || in_array("54", $arr) || in_array("70", $arr))
                            <li class="slide {{ (request()->routeIs('admin.shift')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.add')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.report')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.report.view')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.report.edit')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.route.map')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.parcels')) ? 'is-expanded' : '' }} {{ (request()->routeIs('admin.shift.missed.shift')) ? 'is-expanded' : '' }}">
                                <a class="side-menu__item {{ (request()->routeIs('admin.shift')) ? 'active' : '' }} {{ (request()->routeIs('admin.shift.add')) ? 'active' : '' }} {{ (request()->routeIs('admin.shift.report')) ? 'active' : '' }} {{ (request()->routeIs('admin.shift.report.view')) ? 'active' : '' }} {{ (request()->routeIs('admin.shift.report.edit')) ? 'active' : '' }}" {{ (request()->routeIs('admin.shift.route.map')) ? 'active' : '' }}  {{ (request()->routeIs('admin.shift.parcels')) ? 'active' : '' }} {{ (request()->routeIs('admin.shift.missed.shift')) ? 'is-expanded' : '' }} data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon fe fe-file-text"></i><span
                                        class="side-menu__label">Shift Management</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
								<ul class="slide-menu mega-slide-menu">
                                    <li class="panel sidetab-menu">
                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="side5">
                                                    <ul class="sidemenu-list mega-menu-list">
                                                        @if(in_array("48", $arr) || in_array("49", $arr)  || in_array("50", $arr) || in_array("51", $arr) || in_array("52", $arr) || in_array("53", $arr) || in_array("54", $arr))
                                                        <li><a href="{{ route('admin.shift.report') }}" class="slide-item {{ (request()->routeIs('admin.shift.report')) ? 'active' : '' }} {{ (request()->routeIs('admin.shift.missed.shift')) ? 'active' : '' }}">Shift Report</a></li>
                                                        @endif

                                                    </ul>

                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            @endif


                            {{-- @if(in_array("5", $arr) || in_array("6", $arr) || in_array("7", $arr))

                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('administration.userAccess')) ? 'active' : '' }} {{ (request()->routeIs('administration.userAccess')) ? 'active' : '' }} {{ (request()->routeIs('padministration.userAccess')) ? 'active' : '' }} {{ (request()->routeIs('administration.userAccess')) ? 'active' : '' }} "  href="{{ route('administration.userAccess') }}  " ><i
                                        class="side-menu__icon icon icon-user"></i><span
                                        class="side-menu__label">User Access Role</span></a>
                            </li>

                            @endif --}}


                            @if(in_array("9", $arr) || in_array("10", $arr) || in_array("11", $arr) || in_array("12", $arr))
                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('person')) ? 'active' : '' }} {{ (request()->routeIs('person.add')) ? 'active' : '' }} {{ (request()->routeIs('person.edit')) ? 'active' : '' }} {{ (request()->routeIs('person.view')) ? 'active' : '' }} "  href="{{ route('person') }}  " ><i
                                        class="side-menu__icon icon icon-user"></i><span
                                        class="side-menu__label">Person</span></a>
                            </li>
                            @endif


                            @if(in_array("21", $arr) || in_array("22", $arr) || in_array("23", $arr) || in_array("24", $arr))
                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('clients')) ? 'active' : '' }} {{ (request()->routeIs('client.view')) ? 'active' : '' }} {{ (request()->routeIs('client.edit')) ? 'active' : '' }} {{ (request()->routeIs('client.add')) ? 'active' : '' }}" href="{{ route('clients') }}"   ><i
                                        class="side-menu__icon icon icon-people"></i><span
                                        class="side-menu__label">Clients</span></a>
                            </li>
                            @endif

                            @if(in_array("25", $arr) || in_array("26", $arr) || in_array("27", $arr) || in_array("28", $arr))
                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('vehicle')) ? 'active' : '' }} {{ (request()->routeIs('vehicle.add')) ? 'active' : '' }}" href="{{ route('vehicle') }}"  ><i
                                        class="side-menu__icon ti-car"></i><span
                                        class="side-menu__label">Vehicles</span></a>
                            </li>
                            @endif


                            @if(in_array("68", $arr))
                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('live-tracking')) ? 'active' : '' }}" href="{{ route('live-tracking') }}" ><i
                                        class="side-menu__icon ti-map-alt"></i><span
                                        class="side-menu__label">Delivery Tracking</span></a>
                            </li>
                            @endif

                            @if(in_array("84", $arr))
                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('driver.location')) ? 'active' : '' }}" href="{{ route('driver.location') }}" ><i
                                        class="side-menu__icon ti-map-alt"></i><span
                                        class="side-menu__label">Current Live Tracking</span></a>
                            </li>
                            @endif

                            @if(in_array("29", $arr) || in_array("30", $arr) || in_array("31", $arr) || in_array("32", $arr))
                            <li>
                                <a class="side-menu__item has-link {{ (request()->routeIs('inspection')) ? 'active' : '' }}" href="{{ route('inspection') }}" ><i
                                        class="side-menu__icon fe fe-search"></i><span
                                        class="side-menu__label">Inspection</span></a>
                            </li>
                            @endif


                            @if(in_array("71", $arr) || in_array("72", $arr) || in_array("73", $arr)  || in_array("43", $arr) || in_array("44", $arr) || in_array("45", $arr) || in_array("74", $arr) || in_array("75", $arr) || in_array("88", $arr))
                               <li class="slide {{ (request()->routeIs('induction')) ? 'is-expanded' : '' }} {{ (request()->routeIs('driver')) ? 'is-expanded' : '' }}" >
                                <a class="side-menu__item {{ (request()->routeIs('induction')) ? 'active' : '' }} {{ (request()->routeIs('driver')) ? 'active' : '' }}" data-bs-toggle="slide" href="javascript:void(0)"><i
                                        class="side-menu__icon ti-write"></i><span
                                        class="side-menu__label">Induction</span><i
                                        class="angle fe fe-chevron-right"></i>
                                </a>
								<ul class="slide-menu mega-slide-menu">
                                    <li class="panel sidetab-menu">

                                        <div class="panel-body tabs-menu-body p-0 border-0">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="side5">
                                                    <ul class="sidemenu-list mega-menu-list">

                                                        @if(in_array("71", $arr) || in_array("72", $arr) || in_array("73", $arr))
                                                          <li><a href="{{ route('induction') }}" class="slide-item {{ (request()->routeIs('induction')) ? 'active' : '' }}">Induction</a></li>
                                                         @endif

                                                        @if(in_array("43", $arr) || in_array("44", $arr) || in_array("45", $arr))
                                                        <li><a href="{{ route('driver') }}" class="slide-item {{ (request()->routeIs('driver')) ? 'active' : '' }}">Drivers</a></li>
                                                        @endif


                                                    </ul>

                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            @endif

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                                width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                            </svg></div>
                    </div>
                </div>
            </div>
            <!--/APP-SIDEBAR-->
