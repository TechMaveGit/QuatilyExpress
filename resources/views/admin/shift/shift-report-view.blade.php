@extends('admin.layout')
@section('content')


@php
$driverRole=  Auth::guard('adminLogin')->user();
@endphp


<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
    <h1 class="page-title">Shift View</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_page') }}">Dashboard</a></li>
                <li class="breadcrumb-item " aria-current="page">Shift Report</li>
                <li class="breadcrumb-item active" aria-current="page">Shift View</li>
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
                        
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content  text-muted">
                            
                            <div class="tab-pane show active" id="home">
                               
                                  @php

                                   $finishshifts=DB::table('finishshifts')->where('shiftId',$shiftView->id)->first();

                                   $clientbase=  DB::table('clientbases')->where('id',$shiftView->base)->first();
                                   $rego=  DB::table('vehicals')->where('id',$shiftView->rego)->first();
                                @endphp

                            <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                        <h2>
                                            <span><i class="ti-light-bulb"></i></span>
                                            <span> Show Shift</span>
                                        </h2>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Shift Id</label>
                                                    <input type="text" class="form-control" name="dateFinish" value="QE{{ $shiftView->shiftRandId??'' }}"  readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">State <span class="red">*</span></label>
                                                    <div class="form-group">

                                                    <select class="form-control select2 form-select" data-placeholder="Choose one" disabled>
                                                            @foreach ($allstate as $allstate)
                                                              <option value="{{ $allstate->id }}" @if($allstate->id ==$shiftView->state) selected @else @endif >{{ $allstate->name }}
                                                             </option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Client <span class="red">*</span></label>
                                                    <div class="form-group">

                                                    <select class="form-control select2 form-select" data-placeholder="Choose one" disabled>
                                                        <option value="">Select any one</option>
                                                        @foreach ($client as $allclient)
                                                        <option value="{{ $allclient->id }}" @if($allclient->id ==$shiftView->client) selected @else @endif >{{ $allclient->name }}
                                                       </option>
                                                      @endforeach
                                                        </select>
                                                   </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Cost Centre  <span class="red">*</span></label>
                                                    <div class="form-group">

                                                    <select class="form-control select2 form-select" data-placeholder="Choose one" disabled>
                                                        <option value="">Select any one</option>
                                                        @foreach ($costCenter as $allcostCenter)
                                                        <option value="{{ $allcostCenter->id }}" @if($allcostCenter->id==$shiftView->costCenter) selected @else @endif >{{ $allcostCenter->name }}
                                                       </option>
                                                      @endforeach
                                                        </select>
                                                </div>
                                                </div>
                                            </div>

                                           <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Status <span class="red">*</span></label>
                                                    <div class="form-group">
                                                    <select class="form-control select2 form-select" disabled>
                                                           <option value="">Select any one</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='0') selected @else @endif >Created</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='1') selected @else @endif >In Progress</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='2') selected @else @endif >To Be Approved</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='3') selected @else @endif >Approved</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='4') selected @else @endif >Rejected</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='5') selected @else @endif >Paid</option>
                                                            <option value="1" @if($shiftView['finishStatus'] =='6') selected @else @endif >Already Paid</option>
                                                        </select>

                                                </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Base <span class="red">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $clientbase->base??'N/A' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                        <div class="check_box">
                                                            <label class="form-label" for="exampleInputEmail1">Vehicle Type <span class="red">*</span></label>
                                                            <div class="form-group">

                                                            <select class="form-control select2 form-select" data-placeholder="Choose one" disabled>
                                                                <option value="">Select any one</option>
                                                                @foreach ($types as $alltypes)
                                                                   <option value="{{ $alltypes->id }}" @if($alltypes->id ==$shiftView->vehicleType) selected @else @endif >{{ $alltypes->name }}
                                                                   </option>

                                                              @endforeach
                                                                </select>
                                                        </div>
                                                        </div>
                                                    </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">

                                                    <label class="form-label" for="exampleInputEmail1">REGO <span class="red">*</span></label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $rego->rego??'' }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Driver </label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 form-select" name="driverId" id="appendDriverResponiable" data-placeholder="Choose one" disabled>
                                                                <option value="">Select Any One</option>
                                                                    @forelse ($driverAdd as $AdddriverAdd)
                                                                    <option value="{{ $AdddriverAdd->id }}" @if($AdddriverAdd->id == $shiftView->driverId) selected @else @endif">{{ $AdddriverAdd->userName }} {{ $AdddriverAdd->surname??'' }} ({{ $AdddriverAdd->email??'' }})</option>
                                                                    @empty
                                                                    @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Odometer  <span class="red">*</span></label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->odometer }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1"> Scanner ID <span class="red">*</span></label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->scanner_id }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Parcels Taken  <span class="red">*</span></label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->parcelsToken }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>

                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Mobile Date Start</label>
                                                    <input type="text" class="form-control" id="#basicDate" value="{{ date('Y-m-d H:i:s',strtotime($shiftView->shiftStartDate)) }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Mobile Date Finish</label>
                                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($shiftView->getFinishShifts->endDate ??'')->format('Y-m-d') }} {{ \Carbon\Carbon::parse($shiftView->getFinishShifts->endTime ??'')->format('H:i:s') }}" placeholder="" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Driver Rate</label>
                                                    <input type="text" class="form-control "
                                                    value="{{ $extra_rate_per_hour }}"
                                                    aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>

                                            @if (isset($finishshifts->addPhoto))
                                            <div class="col-lg-3">
                                                <div class="mb-3" style="width: 116px;">
                                                    <label class="form-label" for="exampleInputEmail1">Shift Image</label>
                                                    <a href="{{ asset(env('STORAGE_URL') . $finishshifts->addPhoto) }}" target="_blank">
                                                        <img src="{{ asset(env('STORAGE_URL') . $finishshifts->addPhoto) }}" alt="Image" style="max-width: 53%;" />
                                                    </a>
                                                                                                                </div>
                                            </div>
                                        @endif

                                        <hr>
                                        <hr>
                                        <h2>
                                            <span><i class="ti-agenda"></i></span>
                                            <span> Shift Hr. Management</span>
                                        </h2>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Hours Day Shift  </label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $dayHours1 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Hours Night Shift</label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $nightHour1 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
                                                  @if ($driverRole->role_id!='33')
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Saturday Hours</label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->saturdayHours??'0' }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Sunday Hours</label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->sundayHours??'0' }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
                                                  @endif
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Hours Weekend Shift</label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->weekendHours??'0' }} "  aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
                                                  @php
                                                      $finalAmount='';
                                                  @endphp
   
                                                  @if ($driverRole->role_id!='33')
   
                                                  <div class="col-lg-3">
   
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Amount Payable Day Shift</label>
   
                                                       @php
                                                           $day='0';
                                                       @endphp
                                                       @if($shiftView->getFinishShifts->dayHours ?? 0 !='0')
                                                        @php
                                                           $day = ($shiftView->getClientCharge->hourlyRatePayableDay + $extra_rate_per_hour ?? 0) * ($shiftView->getFinishShifts->dayHours ?? 0);
                                                        @endphp
                                                        @else
                                                        @php
                                                        $day = 0
                                                        @endphp
                                                           @endif
                                                       <input type="text" class="form-control secondcls" id="exampleInputEmail1" value="{{ $day ??'0' }}"  aria-describedby="emailHelp" placeholder="" readonly>
   
   
   
   
                                                   </div>
   
                                                  </div>
   
   
   
   
   
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Amount Payable Night Shift</label>
   
                                                       @if($shiftView->getFinishShifts->nightHours ?? 0 !='0')
                                                        @php
                                                             $night = ($shiftView->getClientCharge->hourlyRatePayableNight + $extra_rate_per_hour ?? 0) * ($shiftView->getFinishShifts->nightHours ?? 0);
                                                        @endphp
                                                        @else
                                                        @php
                                                        $night = 0
                                                        @endphp
                                                       @endif
                                                       <input type="text" class="form-control secondcls" id="exampleInputEmail1" value="{{ $night ??'0' }}" aria-describedby="emailHelp" placeholder="" readonly>
   
   
   
   
                                                   </div>
   
                                                  </div>
   
   
   
                                               <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Amount Payable Weekend Shift</label>
   
   
                                                           @php
                                                               $saturday = 0;
                                                               $sunday = 0;
   
                                                               if ($shiftView->getFinishShifts && $shiftView->getFinishShifts->saturdayHours != '0') {
                                                                   $saturday = ($shiftView->getClientCharge->hourlyRatePayableSaturday + $extra_rate_per_hour ?? 0) * ($shiftView->getFinishShifts->saturdayHours ?? 0);
                                                               }
   
                                                               if ($shiftView->getFinishShifts && $shiftView->getFinishShifts->sundayHours != '0') {
                                                                   $sunday = ($shiftView->getClientCharge->hourlyRatePayableSunday + $extra_rate_per_hour ?? 0) * ($shiftView->getFinishShifts->sundayHours ?? 0);
                                                               }
                                                               $finalAmount=$saturday +  $sunday;
                                                           @endphp
   
                                                           <input type="text" class="form-control secondcls" id="exampleInputEmail1" value="{{ $saturday + $sunday }}" aria-describedby="emailHelp" placeholder="" readonly>
   
                                                   </div>
                                               </div>
   
   
                                               <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Amount Chargeable Day Shift</label>
                                                   @php
                                                       $chargeDayShift = ($shiftView->getClientCharge->hourlyRateChargeableDays??0) * ($shiftView->getFinishShifts->dayHours ?? 0);
                                                       $chargeNight = ($shiftView->getClientCharge->ourlyRateChargeableNight??0) * ($shiftView->getFinishShifts->nightHours ?? 0);
                                                   @endphp
   
                                                       <input type="text" class="form-control thirdcls" id="exampleInputEmail1" value="{{ round($chargeDayShift,2) }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
                                               </div>
   
   
   
   
                                           <div class="col-lg-3">
                                               <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Amount Chargeable Night Shift</label>
                                                   <input type="text" class="form-control thirdcls" id="exampleInputEmail1" value="{{ round($chargeNight,2) }}"  aria-describedby="emailHelp" placeholder="" readonly>
                                               </div>
                                           </div>
   
   
   
                                           @if(!empty($shiftView->getFinishShifts->saturdayHours))
                                           @php
                                               $saturday = ($shiftView->getClientCharge->hourlyRateChargeableSaturday )  * ($shiftView->getFinishShifts->saturdayHours ?? 0) ;
                                           @endphp
                                           @else
                                           @php
                                               $saturday=0;
                                               @endphp
                                           @endif
   
   
   
                                           @if(!empty($shiftView->getFinishShifts->sundayHours))
                                           @php
                                           $sunday = $shiftView->getClientCharge->hourlyRateChargeableSunday * $shiftView->getFinishShifts->sundayHours;
                                           @endphp
                                           @else
                                           @php
                                           $sunday=0;
                                           @endphp
                                           @endif
   
   
                                           <div class="col-lg-3">
                                               <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Amount Chargeable Saturday Hours</label>
                                                   <input type="text" class="form-control thirdcls" id="exampleInputEmail1" value="{{ round($saturday,2) }}"  aria-describedby="emailHelp" placeholder="" readonly>
                                               </div>
   
                                           </div>
   
                                           <div class="col-lg-3">
                                               <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Amount Chargeable Sunday Hours</label>
                                                   <input type="text" class="form-control thirdcls" id="exampleInputEmail1" value="{{ round($sunday,2) }}"  aria-describedby="emailHelp" placeholder="" readonly>
                                               </div>
   
                                           </div>
                                           @endif
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Parcel Taken</label>
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->parcelsToken }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Parcel Delivered</label>
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->parcelsDelivered??''}}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Odometer Start</label>
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->odometerStartReading??''}}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Odometer Finish</label>
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->odometerEndReading??''}}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                   @php
                                                   $km = ($shiftView->getFinishShift->odometerEndReading  ?? 0) - ($shiftView->getFinishShift->odometerStartReading ?? 0);
                                                   @endphp
   
                                                  </div>
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Traveled KM</label>
                                                       <input type="text" value="{{ $km }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>
   
                                                  </div>
   
   
   
                                               <div class="col-lg-3">
                                                   <div class="mb-3">
   
                                                       <label class="form-label" for="exampleInputEmail1">Date Start</label>
                                                       @if ($finishshifts)
                                                       <input type="text" class="form-control" id="#basicDate" value="{{ $shiftView->shiftStartDate }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                       @else
                                                       <input type="text" class="form-control" id="#basicDate" value="" aria-describedby="emailHelp" placeholder="" readonly>
                                                       @endif
   
                                                   </div>
                                               </div>
                                               <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Date Finish </label>
                                                       @if ($finishshifts)
                                                       <input type="text" class="form-control" id="#basicDate1" value="{{ $finishshifts->endDate??'N/A' }} {{ $finishshifts->endTime??'N/A' }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                       @else
                                                       <input type="text" class="form-control" id="#basicDate1" value="" aria-describedby="emailHelp" placeholder="" readonly>
                                                       @endif
                                                   </div>
                                               </div>
   
                                               <div class="col-lg-3">
   
                                               </div>
   
   
                                           </div>
                                        </div>

                                        <hr>
                                        <hr>
                                        <h2>
                                            <span><i class="ti-clipboard"></i></span>
                                            <span>Monetize Information</span>
                                        </h2>
                                            <form action="{{ route('admin.shift.report.edit', ['id'=>$shiftView->id]) }}" method="post">@csrf
                                                <input type="hidden" name="hrManagerment" value="3"/>
                                                 <div class="top_dt_sec">
                                                    <div class="row">
                                                        @php
                                                           $chargeDayShift = ($shiftView->getClientCharge->hourlyRateChargeableDays ?? 0) * ($shiftView->getFinishShifts ? $shiftView->getFinishShifts->dayHours : 0);
                                                           $chargeNight = ($shiftView->getClientCharge->ourlyRateChargeableNight ?? 0) * ($shiftView->getFinishShifts ? $shiftView->getFinishShifts->nightHours : 0);
            
                                                           $saturday = $shiftView->getFinishShifts && $shiftView->getFinishShifts->saturdayHours
                                                                           ? ($shiftView->getClientCharge->hourlyRateChargeableSaturday ?? 0) * $shiftView->getFinishShifts->saturdayHours
                                                                           : 0;
            
                                                           $sunday = $shiftView->getFinishShifts && $shiftView->getFinishShifts->sundayHours
                                                                           ? ($shiftView->getClientCharge->hourlyRateChargeableSunday ?? 0) * $shiftView->getFinishShifts->sundayHours
                                                                           : 0;
                                                       @endphp
                                                       @php
                                                       $payAmount = round($day,2)+ round($night,2) + round($finalAmount,2);
                                                       $updatedAmnt =  round($shiftView->payAmount?? 0 , 2);
                                                        @endphp
                                                        @if ($payAmount < $updatedAmnt)
                                                                @php
                                                                    $finalpayamnnt = round($shiftView->payAmount?? 0 , 2);
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $finalpayamnnt = round($day,2)+ round($night,2) + round($finalAmount,2);
                                                                @endphp
                                                        @endif
            
            
                                                    <div class="col-lg-6">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Payable Per Service</label>
                                                                    <input type="text" class="form-control secondcls" name="amountPayablePerService" value="{{ round($day,2) + round($night,2) + round($finalAmount,2) }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Fuel Levy Payable</label>
                                                                    <input type="text" class="form-control" name="fuelLevyPayable" value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyPayable	??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Extra Payable</label>
                                                                    <input type="text" class="form-control" name="extraPayable" value="{{ $shiftView->getShiftMonetizeInformation->extraPayable	??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Total Payable</label>
                                                                    <input type="text" class="form-control secondcls" name="totalPayable" value="{{ $finalpayamnnt}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-lg-6">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleInputEmail1">Amount Chargeable Per Service</label>
                                                                        <input type="number"  id="charge1" class="form-control" onInput="edValueKeyChargePrs('a')" name="amountChargeablePerService" @if($shiftView->finishStatus =='5') disabled @else @endif value="{{ round($saturday ?? 0,2)+ round($sunday ?? 0,2) + round($chargeDayShift ?? 0,2) + round($chargeNight ?? 0,2) }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                                        <input type="hidden" id="hiddenChargePrice" value="{{ round($saturday ?? 0,2)+ round($sunday ?? 0,2) + round($chargeDayShift ?? 0,2) + round($chargeNight ?? 0,2) }}"/>
                                                                     </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable</label>
                                                                        <input type="number" class="form-control" name="fuelLevyChargeable" value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyChargeable	??'' }}"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable250</label>
                                                                        <input type="number" class="form-control" name="fuelLevyChargeable250" value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyChargeable250	??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable400</label>
                                                                        <input type="number" class="form-control" name="fuelLevyChargeable400" value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyChargeable400	??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleInputEmail1">Extra Chargeable</label>
                                                                        <input type="text" class="form-control" name="extraChargeable" value="{{ $shiftView->getShiftMonetizeInformation->extraChargeable	??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="exampleInputEmail1">Total Chargeable</label>
                                                                        <input type="text" class="form-control thirdcls" name="totalChargeable" value="{{ round($shiftView->chageAmount ?? 0, 2) }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            
            
                                                           
            
            
                                                       
                                                           <div class="col-lg-12">
                                                            <div class="row">
                                                            <div class="col-lg-6">
                                                            <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Comments</label>
                                                            <textarea class="form-control mb-4" name="comments" placeholder="Please Enter Your Comment" readonly rows="4">{{ $shiftView->getShiftMonetizeInformation->comments	??'' }}</textarea>
            
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Approved Reason</label>
                                                            <textarea class="form-control mb-4" name="approvedReason" placeholder="Please Enter Your Comment" readonly rows="4">{{ $shiftView->getShiftMonetizeInformation->approvedReason	??'' }}</textarea>
            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
            
                                            </div>
            
                                            <hr>
            
                                            {{-- <div class="bottom_footer_dt">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="action_btns text-end">
                                                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                                                            <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <!-- main_bx_dt -->
                                        </div>
                                            </form>
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
