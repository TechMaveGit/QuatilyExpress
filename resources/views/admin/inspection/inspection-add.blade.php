@extends('admin.layout')
@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Inspection Add </h1>
            <div>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Inspection</li>
                    <li class="breadcrumb-item active" aria-current="page">Inspection Add</li>

                </ol>
            </div>
        </div>
        <!-- PAGE-HEADER END -->

        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <form action="{{ route('inspection.add') }}" method="post" enctype="multipart/form-data">@csrf
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">

                                        <div class="col-lg-12">
                                            <div class="check_box">
                                                <label class="form-label" for="exampleInputEmail1">REGO <span
                                                        class="red">*</span></label>
                                                <div class="form-group">

                                                    <select class="form-control select2 form-select" name="selectrego"
                                                        data-placeholder="Choose one">
                                                        <option value="" data-select2-id="select2-data-2-vo6r">Select
                                                        </option>
                                                        @foreach ($regos as $allregos)
                                                            <option value="{{ $allregos->id }}">{{ $allregos->rego }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Comments</label>
                                                <textarea class="form-control mb-4" name="notes" placeholder="Comments" rows="4"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Front <span
                                                            class="red">*</span></label>
                                                    <div class="form-group front">
                                                        <input type="file" class="dropify" name="frontImage"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Front Left <span
                                                            class="red">*</span></label>
                                                    <div class="form-group front-left">
                                                        <input type="file" name="frontLeft" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Front Right <span
                                                            class="red">*</span></label>
                                                    <div class="form-group front-right">
                                                        <input type="file" name="frontRight" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Left Side <span
                                                            class="red">*</span></label>

                                                    <div class="form-group left-side">
                                                        <input type="file" name="leftSide" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Right Side <span
                                                            class="red">*</span></label>
                                                    <div class="form-group right-side">
                                                        <input type="file" name="rightSide" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Back <span
                                                            class="red">*</span></label>
                                                    <div class="form-group back">
                                                        <input type="file" name="back" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1"> Back Left Side
                                                        <span class="red">*</span></label>
                                                    <div class="form-group back-left">
                                                        <input type="file" name="backLeftSide" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Back Right Side
                                                        <span class="red">*</span></label>
                                                    <div class="form-group front-right">
                                                        <input type="file" name="backRightSide" class="dropify"
                                                            data-height="100" accept="image/*" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Cockpit <span
                                                            class="red">*</span></label>
                                                    <div class="form-group cockpit">
                                                        <input type="file" name="cockpit" class="dropify"
                                                            data-height="100" accept="image/*" required />
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

                                                <button type="submit" class="btn btn-primary"
                                                    fdprocessedid="cgqwgp">Save</button>

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
