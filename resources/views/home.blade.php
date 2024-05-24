@extends('admin.layout')

@section('content')

<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home_page') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->
<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
               <div class="card custom-card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon px-0">
                           <span class="rounded p-3 bg-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                                <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z"/>
                              </svg>
                           </span>
                        </div>
                        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 ps-0">
                           <div class="mb-2">Total Driver</div>
                           <div class="text-muted mb-1 fs-12"> <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"> 14,732 </span> </div>
                           <!-- <div> <span class="fs-12 mb-0">Increase by <span class="badge bg-success-transparent text-success mx-1">+4.2%</span> this month</span> </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
               <div class="card custom-card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon secondary  px-0">
                           <span class="rounded p-3 bg-secondary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                              </svg>
                           </span>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 ps-0">
                           <div class="mb-2">Total Clients</div>
                           <div class="text-muted mb-1 fs-12"> <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"> 28,346.00 </span> </div>
                           <!-- <div> <span class="fs-12 mb-0">Increase by <span class="badge bg-success-transparent text-success mx-1">+12.0%</span> this month</span> </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
               <div class="card custom-card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon success px-0">
                           <span class="rounded p-3 bg-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                              </svg>
                           </span>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 ps-0">
                           <div class="mb-2">Total Vehicles</div>
                           <div class="text-muted mb-1 fs-12"> <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"> 1,29,368 </span> </div>
                           <!-- <div> <span class="fs-12 mb-0">Decreased by <span class="badge bg-danger-transparent text-danger mx-1">-7.6%</span> this month</span> </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xl-3">
               <div class="card custom-card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4 d-flex align-items-center justify-content-center ecommerce-icon warning px-0">
                           <span class="rounded p-3 bg-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                              </svg>
                           </span>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 ps-0">
                           <div class="mb-2">Total Shifts</div>
                           <div class="text-muted mb-1 fs-12"> <span class="text-dark fw-semibold fs-20 lh-1 vertical-bottom"> 35,367 </span> </div>
                           <!-- <div> <span class="fs-12 mb-0">Increased by <span class="badge bg-success-transparent text-success mx-1">+2.5%</span> this month</span> </div> -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12 text-end mb-3">
                <a href="#" class="btn btn-primary advanced_filter_btn"><i class="bi-bar-chart"></i> Advance Filters</a>
            </div>
            <div class="col-lg-12 mb-5 advanced_filters">
    <div class="card">
        <div class="card-header card_h">
                <div class="top_section_title">
                    <h5>Filter</h5>
                </div>
            </div>
        <div class="card-body pb-0">
            <div class="row align-items-center">
                    <div class="col-lg-4">
                    <div class="check_box">
                        <label class="form-label" for="exampleInputEmail1">Driver</label>
                        <div class="form-group">

                        <select class="form-control select2 form-select" data-placeholder="Choose one">
                                <option value="1">Vivian</option>
                                <option value="2">Wilber</option>
                                <option value="3">Yaggo</option>
                            </select>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="check_box">
                        <label class="form-label" for="exampleInputEmail1">State</label>
                        <div class="form-group">

                        <select class="form-control select2 form-select" data-placeholder="Choose one">
                                <option value="1">New South Wales</option>
                                <option value="2">Queensland</option>
                                <option value="3">South Australia</option>
                                <option value="3">Tasmania</option>
                                <option value="3">Victoria</option>
                                <option value="3">Western Australia</option>

                            </select>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="check_box">
                        <label class="form-label" for="exampleInputEmail1">Client</label>
                        <div class="form-group">

                        <select class="form-control select2 form-select" data-placeholder="Choose one">
                                <option value="1">Vivian</option>
                                <option value="2">Wilber</option>
                                <option value="3">Yaggo</option>
                            </select>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="check_box">
                        <label class="form-label" for="exampleInputEmail1">Cost Center</label>
                        <div class="form-group">

                        <select class="form-control select2 form-select" data-placeholder="Choose one">
                                <option value="1">Vivian</option>
                                <option value="2">Wilber</option>
                                <option value="3">Yaggo</option>
                            </select>
                    </div>
                    </div>
                </div>
                <div class="col-lg-4 ">
                 <div class="search_btn">
                 <a href="#" class="btn btn-primary srch_btn">Search</a>

                 </div>
                </div>

            </div>

        </div>

    </div>

</div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">$ Monthly Chart</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartLine" class="h-275"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Shift Report By Driver</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartBar2" class="h-275"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Driver Progress</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartBar1" class="h-275"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Monetize Graph as per client & driver</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="chartBar3" class="h-275"></canvas>
                        </div>
                    </div>
                </div>
            </div>
         </div>










    </div>
    <!-- CONTAINER END -->
</div>
</div>
<!--app-content close-->

</div>


@endsection
