@extends('admin.layout')
@section('content')

<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Inspection View</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Inspection</li>
                <li class="breadcrumb-item active" aria-current="page">Inspection view</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
           <div class="row">
           <div class="col-lg-12">

           @isset($inspection->id)

              <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">

                            <div class="col-lg-12">
                                <div class="check_box">
                                    <label class="form-label" for="exampleInputEmail1">REGO <span class="red">*</span></label>
                                    <div class="form-group">
                                       <select class="form-control select2 form-select" name="selectrego" data-placeholder="Choose one" disabled>
                                                    <option value="" data-select2-id="select2-data-2-vo6r">Select</option>
                                                    @forelse ($rego as $allrego)
                                                    <option value="{{ $allrego->id }}" {{ $allrego->id == $inspection->regoNumber ? 'selected="selected"' : '' }}>{{ $allrego->rego }}</option>
                                                    @empty
                                                    <option value=""></option>
                                                    @endforelse


                                           </select>
                                   </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                        <div class="mb-3">
                                        <label class="form-label" for="exampleInputEmail1">Comments</label>
                                        <textarea class="form-control mb-4" name="notes" placeholder="Textarea" rows="4" readonly>{{ $inspection->Notes }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
             <div class="car_inspection_box">
                <div class="check_box">
                    <label class="form-label" for="exampleInputEmail1">Front <span class="red">*</span></label>
                    <div class="form-group front">
                            <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->front??'N/A'}}" alt="Mountains" width="220" height="150">
                    </div>
                </div>
             </div>
          </div>

            <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Front Left <span class="red">*</span></label>
                <div class="form-group front-left">

                @if($inspection->frontleft)
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->frontleft??'N/A'}}" alt="Mountains" width="223" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="223" height="150">
                @endif


                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Front Right <span class="red">*</span></label>
                <div class="form-group front-right">

                @if(($inspection->frontRight))
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->frontRight??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif



                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
            <label class="form-label" for="exampleInputEmail1">Left Side <span class="red">*</span></label>

                <div class="form-group left-side">

                @if(($inspection->leftSide))
                 <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->leftSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif

                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Right Side <span class="red">*</span></label>
                <div class="form-group right-side">

                @if(($inspection->rightSide))
                 <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->rightSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif

                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Back <span class="red">*</span></label>
                <div class="form-group back">

                @if(($inspection->backSide))
                   <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->backSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif



                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1"> Back Left Side <span class="red">*</span></label>
                <div class="form-group back-left">

                @if(($inspection->backLeftSide))
                   <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->backLeftSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif


                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Back Right Side <span class="red">*</span></label>
                <div class="form-group front-right">

                @if(($inspection->backRightSide))
                <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->backRightSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif



                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Cockpit <span class="red">*</span></label>
                <div class="form-group cockpit">

                @if(($inspection->cockpit))
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->cockpit??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif


                </div>
            </div>
         </div>
      </div>














                        </div>

                    </div>

                </div>

            @endisset

            @if(empty($inspection->id))
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                                       <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Front <span class="red">*</span></label>
                <div class="form-group front">

                @if(isset($inspection->front))
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->front??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif

                </div>
            </div>
         </div>
      </div>

      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Front Left <span class="red">*</span></label>
                <div class="form-group front-left">

                @if(isset($inspection->frontleft))
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->frontleft??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="222" height="150">
                @endif


                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Front Right <span class="red">*</span></label>
                <div class="form-group front-right">

                @if(isset($inspection->frontRight))
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->frontRight??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif



                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
            <label class="form-label" for="exampleInputEmail1">Left Side <span class="red">*</span></label>

                <div class="form-group left-side">

                @if(isset($inspection->leftSide))
                 <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->leftSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif

                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Right Side <span class="red">*</span></label>
                <div class="form-group right-side">

                @if(isset($inspection->rightSide))
                 <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->rightSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif

                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Back <span class="red">*</span></label>
                <div class="form-group back">

                @if(isset($inspection->backSide))
                   <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->backSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif



                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1"> Back Left Side <span class="red">*</span></label>
                <div class="form-group back-left">

                @if(isset($inspection->backLeftSide))
                   <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->backLeftSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif


                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Back Right Side <span class="red">*</span></label>
                <div class="form-group front-right">

                @if(isset($inspection->backRightSide))
                <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->backRightSide??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif



                </div>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="car_inspection_box">
            <div class="check_box">
                <label class="form-label" for="exampleInputEmail1">Cockpit <span class="red">*</span></label>
                <div class="form-group cockpit">

                @if(isset($inspection->cockpit))
                  <img src="{{ asset('assets/inspection/carimage')}}/{{$inspection->cockpit??'N/A'}}" alt="Mountains" width="220" height="150">
                @else
                  <img src="{{ asset('assets/images/newimages/logo-qe_1.png')}}" alt="Mountains" width="220" height="150">
                @endif


                </div>
            </div>
         </div>
      </div>

                    </div>

                </div>

            </div>

            @endisset
            </div>

           </div>
        </div>
    </div>
</div>
@endsection
