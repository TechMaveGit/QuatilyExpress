@extends('admin.layout')
@section('content')
    <!--app-content open-->
    <div class="main-content app-content mt-0">
        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Inspection Edit</h1>
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
                            <form action="{{ route('inspection.view', ['id' => $inspection->id]) }}" method="post"
                                enctype="multipart/form-data">@csrf
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                               <label class="form-label" for="exampleInputEmail1">Driver Name</label>
                                               <input class="form-control mb-4"  readonly value="{{ $inspection->getAppDriver->userName??'' }}" />
                                               </div>
                                         </div>
                                         <div class="col-lg-4">
                                            <div class="mb-3">
                                               <label class="form-label" for="exampleInputEmail1">Driver Surname</label>
                                               <input class="form-control mb-4"  readonly value="{{ $inspection->getAppDriver->surname??'' }}" />
                                               </div>
                                         </div>
                                         <div class="col-lg-4">
                                            <div class="mb-3">
                                               <label class="form-label" for="exampleInputEmail1">Driver Email</label>
                                               <input class="form-control mb-4"  readonly value="{{ $inspection->getAppDriver->email??'' }}" />
                                               </div>
                                         </div>
                                            <div class="col-lg-12">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">REGO <span
                                                            class="red">*</span></label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 form-select" name="selectrego"
                                                            data-placeholder="Choose one">
                                                            <option value="" data-select2-id="select2-data-2-vo6r">Select
                                                            </option>
                                                            @forelse ($rego as $allrego)
                                                                <option value="{{ $allrego->id }}"
                                                                    {{ $allrego->id == $inspection->regoNumber ? 'selected="selected"' : '' }}>
                                                                    {{ $allrego->rego }}</option>
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
                                                    <textarea class="form-control mb-4" name="notes" id="exampleInputEmail1" placeholder="Comments" rows="4">{{ $inspection->Notes }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="car_inspection_box">
                                                    <div class="check_box">
                                                        <label class="form-label" for="exampleInputEmail1">Front <span
                                                                class="red">*</span></label>
                                                        <div class="form-group front">
                                                            <input type="file" class="dropify"
                                                                data-default-file="{{ $inspection->front ? asset(env('STORAGE_URL') . $inspection->front ?? 'N/A') : '' }}"
                                                                name="frontImage" data-height="100" />
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
                                                                data-default-file="{{ $inspection->frontleft ? asset(env('STORAGE_URL') . $inspection->frontleft ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->frontRight ? asset(env('STORAGE_URL') . $inspection->frontRight ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->leftSide ? asset(env('STORAGE_URL') . $inspection->leftSide ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->rightSide ? asset(env('STORAGE_URL') . $inspection->rightSide ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->backSide ? asset(env('STORAGE_URL') . $inspection->backSide ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->backLeftSide ? asset(env('STORAGE_URL') . $inspection->backLeftSide ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->backRightSide ? asset(env('STORAGE_URL') . $inspection->backRightSide ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                                                                data-default-file="{{ $inspection->cockpit ? asset(env('STORAGE_URL') . $inspection->cockpit ?? 'N/A') : '' }}"
                                                                data-height="100" />
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
                        @endisset

                        @if (empty($inspection->id))
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-4">
                                            <div class="car_inspection_box">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Front <span
                                                            class="red">*</span></label>
                                                    <div class="form-group front">
                                                        <input type="file" class="dropify"
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->front ?? '' }}"
                                                            name="frontImage" data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->frontleft ?? '' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->frontRight ?? '' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->leftSide ?? '' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->rightSide ?? '' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->backSide ?? 'N/A' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->backLeftSide ?? 'N/A' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->backRightSide ?? 'N/A' }}"
                                                            data-height="100" />
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
                                                            data-default-file="{{ asset('assets/inspection/carimage') }}/{{ $inspection->cockpit ?? 'N/A' }}"
                                                            data-height="100" />
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
