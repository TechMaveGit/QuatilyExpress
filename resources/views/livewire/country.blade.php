<div>
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <div class="card">
                <div class="card-body p-0">
                            <form action="{{ route('vehicle.add') }}" method="post"> @csrf
                                <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                        <div class="row">
                                        <div class="col-lg-4">
                                                        <div class="check_box">
                                                            <label class="form-label" for="exampleInputEmail1">Type</label>
                                                            <div class="form-group">

                                                            <select class="form-control select2 form-select" data-placeholder="Choose one" name="selectType">
                                                                 @forelse ($type as $alltype)
                                                                 <option value="{{ $alltype->id}}">{{ $alltype->name}}</option>
                                                                 @empty

                                                                 @endforelse

                                                                </select>
                                                        </div>
                                                        </div>
                                                    </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Rego</label>
                                                    <input type="text" class="form-control" name="rego" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Odometer</label>
                                                    <input type="text" class="form-control" name="odometer" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Date Of Birth</label>
                                                    <input type="text" class="form-control fc-datepicker"  id="basicDate" aria-describedby="emailHelp" placeholder="">
                                                </div>

                                            </div> -->
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Model</label>
                                                    <input type="text" class="form-control" name="model" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Driver Responsible <span class="red">*</span></label>
                                                    <div class="form-group">

                                               <select class="form-control select2 form-select" data-placeholder="Choose one">
                                               <option value="" data-select2-id="select2-data-2-23cq">Selected</option>
                                               @foreach ($Driverresponsible as $allDriverresponsible)


                                                        <option value="{{ $allDriverresponsible->id}}" data-select2-id="select2-data-9-rghz">{{ $allDriverresponsible->name}}</option>
                                                        @endforeach
                                                   </select>
                                           </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">What you want to control for this vehicle?</label>
                                                    <div class="checkbox_flex">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="driverResponsible" value="1" id="autoSizingCheck1a">
                                                        <label class="form-check-label" for="autoSizingCheck1a">
                                                        Control Inspection
                                                            </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="driverResponsible" value="2" id="autoSizingCheck1b">
                                                        <label class="form-check-label" for="autoSizingCheck1b">
                                                        Control Reminder
                                                            </label>
                                                    </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="title_head">
                                                    <h4>Date Info</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Rego Due Date</label>
                                                    <input type="text" class="form-control" name="regoDate" id="basicDate" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Service Due Date</label>
                                                    <input type="text" class="form-control" name="servicesDue" id="basicDate1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Inspection Due Date</label>
                                                    <input type="text" class="form-control" name="inspenctionDue" id="basicDate2" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="bottom_footer_dt">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="action_btns text-end">
                                                    <input type="submit" class="btn btn-primary">
                                                    <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <!-- main_bx_dt -->
                </div>
            </div>
         </div>
    </div>

</div>
