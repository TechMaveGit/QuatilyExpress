@extends('admin.layout')
@section('content')

<?php

$D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
$arr = [];
foreach($D as $v)
{
  $arr[] = $v['permission_id'];
}
//  echo "<pre>";
//  print_r($arr);
?>

<!--app-content open-->
<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
    <h1 class="page-title">Shift Edit</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item " aria-current="page">Shift Report</li>
                <li class="breadcrumb-item active" aria-current="page">Shift Edit</li>

            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    @php
    $driverRole=  Auth::guard('adminLogin')->user();
    @endphp

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

                            <div class="main_bx_dt__">
                                    <div class="top_dt_sec">
                                    <h2>
                                        <span><i class="ti-light-bulb"></i></span>
                                        <span> Show Shift</span>
                                    </h2>
                                     <form action="{{ route('admin.shift.report.edit', ['id'=>$shiftView->id]) }}" method="post">@csrf
                                     <input type="hidden" name="hrManagerment" value="1"/>
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Shift Id </label>
                                                    <input type="text" class="form-control" name="dateFinish" value="QE{{ $shiftView->shiftRandId??'' }}"  readonly>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">State  <span class="red">*</span></label>
                                                    <div class="form-group">

                                                    @if($shiftView->finishStatus =='5')
                                                       <select class="form-control select2 form-select" name="state" >
                                                           @foreach ($allstate as $allstate)
                                                                <option value="{{ $allstate->id }}">{{ $allstate->name }} </option>
                                                            @endforeach
                                                        </select>
                                                        @else

                                                         <select class="form-control select2 form-select" onchange="getdata(this)" name="state" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                            @foreach ($allstate as $allstate)
                                                              <option value="{{ $allstate->id }}" @if($allstate->id ==$shiftView->state) selected @else @endif>{{ $allstate->name }} </option>

                                                                @endforeach
                                                        </select>

                                                        @endif


                                                </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Client <span class="red">*</span></label>
                                                    <div class="form-group">


                                                        @if($shiftView->finishStatus =='5')
                                                         <select class="form-control select2 form-select" name="client" id="appendClient" data-placeholder="Choose one" disable>
                                                            <option value="">Select any one</option>
                                                        @foreach ($client as $allclient)
                                                        <option value="{{ $allclient->id }}" @if($allclient->id ==$shiftView->client) selected @else @endif >{{ $allclient->name }}
                                                       </option>
                                                      @endforeach
                                                        </select>

                                                        @else
                                                         <select class="form-control select2 form-select" id="appendClient"  onchange="getCostCenter(this)" name="client" data-placeholder="Choose one" disable>
                                                            <option value="">Select any one</option>
                                                        @foreach ($client as $allclient)
                                                        <option value="{{ $allclient->id }}" @if($allclient->id == $shiftView->client) selected @else @endif >{{ $allclient->name }}
                                                       </option>
                                                      @endforeach
                                                        </select>

                                                        @endif



                                                </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Cost Centre <span class="red">*</span></label>
                                                    <div class="form-group">



                                                      @if($shiftView->finishStatus =='5')
                                                        <select class="form-control select2 form-select" id="appendCostCenter" name="costCenter" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                                @foreach ($costCenter as $allcostCenter)
                                                                <option value="{{ $allcostCenter->id }}">{{ $allcostCenter->name }}
                                                               </option>
                                                              @endforeach
                                                        </select>

                                                        @else
                                                           <select class="form-control select2 form-select" id="appendCostCenter" name="costCenter" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                            @foreach ($costCenter as $allcostCenter)
                                                                <option value="{{ $allcostCenter->id }}" @if($allcostCenter->id ==$shiftView->costCenter) selected @else @endif >{{ $allcostCenter->name }}
                                                               </option>
                                                              @endforeach
                                                            </select>

                                                        @endif







                                                </div>
                                                </div>
                                            </div>

                                            @php
                                            $finishshifts=DB::table('finishshifts')->where('shiftId',$shiftView->id)->first();
                                            @endphp




                                               <div class="col-lg-3">
                                                        <div class="check_box">
                                                            <label class="form-label" for="exampleInputEmail1">Status <span class="red">*</span></label>
                                                            <div class="form-group">


                                                            @if($shiftView->finishStatus =='5')
                                                            <select class="form-control select2 form-select" name="finishStatus">
                                                                <option value="0" @if($shiftView->finishStatus =='0') selected @else @endif >Created</option>
                                                                <option value="1" @if($shiftView->finishStatus =='1') selected @else @endif >In Progress</option>
                                                                <option value="2" @if($shiftView->finishStatus =='2') selected @else @endif >To Be Approved</option>
                                                                <option value="3" @if($shiftView->finishStatus =='3') selected @else @endif >Approved</option>
                                                                <option value="4" @if($shiftView->finishStatus =='4') selected @else @endif >Rejected</option>
                                                                <option value="5" @if($shiftView->finishStatus =='5') selected @else @endif >Paid</option>
                                                                <option value="6" @if($shiftView->finishStatus =='6') selected @else @endif >Already Paid</option>
                                                            </select>

                                                            @else
                                                            <select class="form-control select2 form-select" name="finishStatus">
                                                                <option value="0" @if($shiftView->finishStatus =='0') selected @else @endif >Created</option>
                                                                <option value="1" @if($shiftView->finishStatus =='1') selected @else @endif >In Progress</option>
                                                                <option value="2" @if($shiftView->finishStatus =='2') selected @else @endif >To Be Approved</option>
                                                                <option value="3" @if($shiftView->finishStatus =='3') selected @else @endif >Approved</option>
                                                                <option value="4" @if($shiftView->finishStatus =='4') selected @else @endif >Rejected</option>
                                                                <option value="5" @if($shiftView->finishStatus =='5') selected @else @endif >Paid</option>
                                                                <option value="6" @if($shiftView->finishStatus =='6') selected @else @endif >Already Paid</option>
                                                            </select>

                                                            @endif





                                                        </div>
                                                        </div>
                                                    </div>




                                                <div class="col-lg-3">
                                                  <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Base <span class="red">*</span></label>
                                                    <div class="form-group">

                                                        @php
                                                         $clientbases= DB::table('clientbases')->where('id',$shiftView->base)->get();
                                                        @endphp
                                                         @if($shiftView->finishStatus =='5')
                                                           <select class="form-control select2 form-select" id="appendBase" name="base">
                                                            <option value="">Select any one</option>
                                                               @foreach ($clientbases as $allClientBase)
                                                                <option value="{{ $allClientBase->id }}" @if($allClientBase->id == $shiftView->base) selected @else @endif >{{ $allClientBase->base }}
                                                               </option>
                                                              @endforeach
                                                           </select>

                                                        @else
                                                         <select class="form-control select2 form-select" id="appendBase" name="base"  data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                              @foreach ($clientbases as $allClientBase)
                                                                <option value="{{ $allClientBase->id }}" @if($allClientBase->id == $shiftView->base) selected @else @endif >{{ $allClientBase->base }}
                                                               </option>
                                                              @endforeach
                                                           </select>


                                                        @endif
                                                   </div>
                                                </div>
                                            </div>



                                            @if(Auth::guard('adminLogin')->user())

                                            @php
                                                $driverEmail=Auth::guard('adminLogin')->user()->email;
                                                $driverId= DB::table('drivers')->where('email',$driverEmail)->first()->id??'';

                                            @endphp

                                        @else

                                        @php
                                            $driverId='';
                                        @endphp

                                        @endif

                                        @if(!in_array("70", $arr))
                                            <div class="col-lg-3">
                                                <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Driver </label>
                                                    <div class="form-group">
                                                        <select class="form-control select2 form-select" name="driverId" id="appendDriverResponiable" data-placeholder="Choose one">
                                                                <option value="">Select Any One</option>
                                                                    @forelse ($driverAdd as $AdddriverAdd)
                                                                    <option value="{{ $AdddriverAdd->id }}" @if($AdddriverAdd->id == $shiftView->driverId) selected @else @endif">{{ $AdddriverAdd->userName }}</option>
                                                                    @empty
                                                                    @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @else

                                        <input type="hidden" name="driverId" value="{{ $driverId }}"/>





                                        @endif




                                            <div class="col-lg-3">
                                                        <div class="check_box">
                                                            <label class="form-label" for="exampleInputEmail1">Vehicle Type <span class="red">*</span></label>
                                                            <div class="form-group">
                                                         @if($shiftView->finishStatus =='5')
                                                        <select class="form-control select2 form-select" id="appendVehicleType"  onchange="getDriverResponiable(this)"  name="vehicleType" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                            @foreach ($types as $alltypes)
                                                               <option value="{{ $alltypes->id }}" @if($alltypes->id ==$shiftView->vehicleType) selected @else @endif >{{ $alltypes->name }}
                                                               </option>

                                                          @endforeach
                                                            </select>

                                                        @else
                                                        <select class="form-control select2 form-select" id="appendVehicleType"  onchange="getDriverResponiable(this)" name="vehicleType" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                            @foreach ($types as $alltypes)
                                                               <option value="{{ $alltypes->id }}" @if($alltypes->id ==$shiftView->vehicleType) selected @else @endif >{{ $alltypes->name }}
                                                               </option>

                                                          @endforeach
                                                            </select>

                                                        @endif
                                                        </div>
                                                        </div>
                                            </div>



                                              <div class="col-lg-3">
                                                  <div class="check_box">
                                                    <label class="form-label" for="exampleInputEmail1">Rego <span class="red">*</span></label>
                                                    <div class="form-group">


                                                         @if($shiftView->finishStatus =='5')
                                                           <select class="form-control select2 form-select" id="regoId"  onchange="getDriverResponiable(this)"  name="rego" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                            @foreach ($types as $alltypes)
                                                               <option value="{{ $alltypes->id }}" @if($alltypes->id ==$shiftView->vehicleType) selected @else @endif >{{ $alltypes->name }}
                                                               </option>

                                                          @endforeach
                                                            </select>

                                                        @else
                                                        @php
                                                        $rego = DB::table('vehicals')->get();
                                                        @endphp
                                                           <select class="form-control select2 form-select" name="rego" data-placeholder="Choose one">
                                                            <option value="">Select any one</option>
                                                               @foreach ($rego as $allrego)
                                                                <option value="{{ $allrego->id }}" @if($allrego->id == $shiftView->rego) selected @else @endif >{{ $allrego->rego }}
                                                               </option>
                                                              @endforeach
                                                           </select>

                                                        @endif
                                                   </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1"> Scanner ID <span class="red">*</span></label>
                                                    <input type="text" min="0" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  class="form-control" name="scannerName" id="exampleInputEmail1" value="{{ $shiftView->scanner_id }}"  @if($shiftView->finishStatus =='5') disabled @else @endif aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Parcels Taken  <span class="red">*</span></label>
                                                    <input type="num" min="0" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  class="form-control" name="parcelToken" id="exampleInputEmail1" value="{{ $shiftView->parcelsToken }}"  @if($shiftView->finishStatus =='5') disabled @else @endif aria-describedby="emailHelp" placeholder="">
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Mobile Date Start</label>
                                                    <input type="text" class="form-control" id="#basicDate" value="{{ $shiftView->shiftStartDate??'N/A' }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Mobile Date Finish</label>
                                                    <input type="text" class="form-control "
                                                    value="{{ \Carbon\Carbon::parse($shiftView->getFinishShifts->endDate ??'')->format('Y-m-d') }} {{ \Carbon\Carbon::parse($shiftView->getFinishShifts->endTime ??'')->format('H:i') }}"
                                                    aria-describedby="emailHelp" placeholder="" readonly>
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
                                                    <a href="{{ asset('assets/driver/parcel/finishParcel/' . $finishshifts->addPhoto) }}" target="_blank">
                                                        <img src="{{ asset('assets/driver/parcel/finishParcel/' . $finishshifts->addPhoto) }}" alt="Image" style="max-width: 53%;" />
                                                    </a>
                                                                                                                </div>
                                            </div>
                                        @endif

                                         </div>


                                        <div class="bottom_footer_dt">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="action_btns text-end">
                                                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                                                         <a href="{{ route('admin.shift.report') }}" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </form>

                                     <hr>
                                     <hr>

                                     <h2>
                                        <span><i class="ti-agenda"></i></span>
                                        <span> Shift Hr. Management</span>
                                    </h2>
                                    <form action="{{ route('admin.shift.report.edit', ['id'=>$shiftView->id]) }}" method="post">@csrf
                                        <input type="hidden" name="hrManagerment" value="2"/>


                                        <div class="row">


                                              <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Hours Day Shift </label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->dayHours ?? 0 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>

                                                  </div>

                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Hours Night Shift</label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->nightHours ?? 0 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>

                                                  </div>

                                                  @if ($driverRole->role_id!='33')

                                                   <div class="col-lg-3">
                                                       <div class="mb-3">
                                                           <label class="form-label" for="exampleInputEmail1">Total Saturday Hours</label>
                                                           <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->saturdayHours ?? 0 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                       </div>

                                                   </div>

                                                   <div class="col-lg-3">
                                                       <div class="mb-3">
                                                           <label class="form-label" for="exampleInputEmail1">Total Sunday Hours</label>
                                                           <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->sundayHours ?? 0 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                       </div>

                                                   </div>
                                                  @endif

                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Total Hours Weekend Shift</label>
                                                       <input type="text" class="form-control firstcls" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->weekendHours?? 0 }} "  aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>

                                                  </div>

                                                  @if ($driverRole->role_id!='33')

                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Amount Payable Day Shift</label>
                                                       @if($shiftView->getFinishShifts->dayHours ?? 0 !='0')
                                                        @php
                                                            $day = ($shiftView->getClientCharge->hourlyRatePayableDay + $extra_rate_per_hour ?? 0) * ($shiftView->getFinishShifts->dayHours ?? 0);
                                                        @endphp
                                                        @else
                                                        @php
                                                        $day = 0
                                                        @endphp
                                                        @endif
                                                       <input type="text" class="form-control secondcls" id="exampleInputEmail1" value="{{ round($day,2) }}" aria-describedby="emailHelp" placeholder="" readonly>




                                                   </div>

                                                  </div>



                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Amount Payable Night Shift</label>


                                                       @if($shiftView->getFinishShifts->nightHours ?? 0 !='0')
                                                        @php
                                                             $night = ($shiftView->getClientCharge->hourlyRatePayableNight + $extra_rate_per_hour  ?? 0) * ($shiftView->getFinishShifts->nightHours ?? 0);
                                                        @endphp
                                                        @else
                                                        @php
                                                        $night = 0
                                                        @endphp
                                                        @endif

                                                       <input type="text" class="form-control secondcls" id="exampleInputEmail1" value="{{ round($night,2) }}" aria-describedby="emailHelp" placeholder="" readonly>




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
                                                       $saturday = $shiftView->getClientCharge->hourlyRateChargeableSaturday * $shiftView->getFinishShifts->saturdayHours;
                                                   @endphp
                                                   @else
                                                   @php
                                                       $saturday=0;
                                                       @endphp
                                                   @endif



                                                   @if(!empty($shiftView->getFinishShifts->sundayHours))
                                                   @php
                                                   $sunday = $shiftView->getClientCharge->hourlyRateChargeableSunday * $shiftView->getFinishShifts->sundayHours ;
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
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->parcelsDelivered?? 0 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>

                                                  </div>

                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Odometer Start</label>
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->odometerStartReading?? 0 }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                   </div>

                                                  </div>
                                                  <div class="col-lg-3">
                                                   <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Odometer Finish</label>
                                                       <input type="text" class="form-control" id="exampleInputEmail1" value="{{ $shiftView->getFinishShifts->odometerEndReading?? 0}}" aria-describedby="emailHelp" placeholder="" readonly>
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

                                                       <label class="form-label" for="exampleInputEmail1">Date Start </label>

                                                       @if ($shiftView->shiftStartDate)
                                                       <input type="text" class="form-control datetime_picker" name="startDate"
                                                       value="{{ $shiftView->shiftStartDate }}"
                                                       aria-describedby="emailHelp" placeholder="">
                                                       @else

                                                       <input type="text"  class="form-control" name="startDate"
                                                       value=""
                                                       aria-describedby="emailHelp" placeholder="">

                                                       @endif


                                                   </div>
                                               </div>

                                               <div class="col-lg-3">
                                                   <div class="mb-3">

                                                       <label class="form-label" for="exampleInputEmail1">Date Finish</label>
                                                       @if ($finishshifts)
                                                       <input type="text" name="finishDate" class="form-control datetime_picker" id="#basicDate1" value="{{ $finishshifts->endDate??'N/A' }} {{ $finishshifts->endTime??'N/A' }}" aria-describedby="emailHelp">
                                                       @else
                                                       <input type="text"  class="form-control datetime_picker" id="#basicDate2" value="" aria-describedby="emailHelp">
                                                       @endif

                                                   </div>
                                               </div>




                                           </div>

                                           <script>
                                               // const currentDate = new Date().toISOString().slice(0, 16);
                                               // document.getElementById('myDatetimeInput').value = currentDate;

                                               const currentDate = new Date().toISOString().slice(0, 16);
                                               document.getElementById('dateFinish').value = currentDate;
                                           </script>








                                       <div class="bottom_footer_dt">
                                           <div class="row">
                                               <div class="col-lg-12">
                                                   <div class="action_btns text-end">
                                                       <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                                                       <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                                   </div>
                                               </div>
                                           </div>
                                       </div>

                                    </form>
                                    <hr>
                                    <hr>

                                    <h2>
                                        <span><i class="ti-clipboard"></i></span>
                                        <span>Monetize Information</span>
                                    </h2>

                                    @if ($driverRole->role_id!='33')
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
                                                        <input type="text"  step="0.1" class="form-control secondcls" id="first" onInput="edValueKeyPrs('a')" name="amountPayablePerService" @if($shiftView->finishStatus =='5') disabled @else @endif  value="{{ round($day,2) + round($night,2) + round($finalAmount,2) }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                        <input type="hidden" id="hiddenPrice" value="{{ round($day,2)+ round($night,2) + round($finalAmount,2) }}"/>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Payable</label>
                                                        <input type="text" step="0.1"  class="form-control" name="fuelLevyPayable" @if($shiftView->finishStatus =='5') disabled @else @endif id="second" onInput="edValueKeyPrs('a')" value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyPayable	??'' }}"  aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Extra Payable</label>
                                                        <input type="text" step="0.1" class="form-control" name="extraPayable" @if($shiftView->finishStatus =='5') disabled @else @endif  id="third" onInput="edValueKeyPrs('a')" value="{{ $shiftView->getShiftMonetizeInformation->extraPayable	??'' }}"  aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Total Payable </label>
                                                        <input type="text" step="0.1" value="{{ $finalpayamnnt }}" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  class="form-control secondcls" name="totalPayable" @if($shiftView->finishStatus =='5') disabled @else @endif  id="subtotal" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Amount Chargeable Per Service</label>
                                                        <input type="text" step="0.1" id="charge1" class="form-control" onInput="edValueKeyChargePrs('a')" name="amountChargeablePerService" @if($shiftView->finishStatus =='5') disabled @else @endif value="{{ round($saturday ?? 0,2)+ round($sunday ?? 0,2) + round($chargeDayShift ?? 0,2) + round($chargeNight ?? 0,2) }}" aria-describedby="emailHelp" placeholder="" readonly>
                                                        <input type="hidden" id="hiddenChargePrice" value="{{ round($saturday ?? 0,2)+ round($sunday ?? 0,2) + round($chargeDayShift ?? 0,2) + round($chargeNight ?? 0,2) }}"/>
                                                     </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable</label>
                                                        <input type="text" step="0.1" id="charge2"   class="form-control" onInput="edValueKeyChargePrs('a')" name="fuelLevyChargeable" @if($shiftView->finishStatus =='5') disabled @else @endif value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyChargeable	??'' }}"   aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable250</label>
                                                        <input type="text" step="0.1" id="charge3"   class="form-control" onInput="edValueKeyChargePrs('a')" name="fuelLevyChargeable250" @if($shiftView->finishStatus =='5') disabled @else @endif value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyChargeable250	??'' }}"  aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable400</label>
                                                        <input type="text" step="0.1" id="charge4"   class="form-control" onInput="edValueKeyChargePrs('a')" name="fuelLevyChargeable400" @if($shiftView->finishStatus =='5') disabled @else @endif  value="{{ $shiftView->getShiftMonetizeInformation->fuelLevyChargeable400	??'' }}"  aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Extra Chargeable </label>
                                                        <input type="text" step="0.1" id="charge5" onInput="edValueKeyChargePrs('a')"  class="form-control" name="extraChargeable" @if($shiftView->finishStatus =='5') disabled @else @endif value="{{ $shiftView->getShiftMonetizeInformation->extraChargeable	??'' }}" aria-describedby="emailHelp" placeholder="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                   
                                                <div class="mb-3">
                                                    <label class="form-label" for="exampleInputEmail1">Total Chargeable</label>
                                                    <input type="text" step="0.1"  id="charge6" onInput="edValueKeyChargePrs('a')"  class="form-control thirdcls" name="totalChargeable" @if($shiftView->finishStatus =='5') disabled @else @endif value="{{ round($shiftView->chageAmount??'',2 )}}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                                </div>
                                        </div>
                                        </div>

                                               <div class="col-lg-12">
                                                <div class="row">
                                                <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Comments</label>
                                                <textarea class="form-control mb-4" name="comments" @if($shiftView->finishStatus =='5') disabled @else @endif placeholder="Please Enter Your Comment " rows="4">{{ $shiftView->getShiftMonetizeInformation->comments	??'' }}</textarea>

                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                <label class="form-label" for="exampleInputEmail1">Approved Reason</label>
                                                <textarea class="form-control mb-4" name="approvedReason" @if($shiftView->finishStatus =='5') disabled @else @endif placeholder="Please Enter Your Comment" rows="4">{{ $shiftView->getShiftMonetizeInformation->approvedReason	??'' }}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <hr>

                                <div class="bottom_footer_dt">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="action_btns text-end">
                                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
                                                <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- main_bx_dt -->
                            </div>
                                </form>



                                @endif

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
    </div>



    <script>
        const numericInput1 = document.getElementById('odometer_start_reading');
        numericInput1.addEventListener('keydown', function(event)
           {
                        const key = event.key;
                        if (/^[a-zA-Z]$/.test(key)) {
                                    event.preventDefault();
                                }
            });

            const numericInput2 = document.getElementById('odometer_finish_reading');
            numericInput2.addEventListener('keydown', function(event)
           {
                        const key = event.key;
                        if (/^[a-zA-Z]$/.test(key)) {
                                    event.preventDefault();
                                }
            });
    </script>


    <script>
        function checkOdometerReading(event) {

            var startReading = parseFloat(document.getElementById('odometer_start_reading').value) || 0;
            var finishReading = parseFloat(document.getElementById('odometer_finish_reading').value + event.key) || 0;
            var addButton = document.querySelector('.btn.btn-primary');

            const key = event.key;
            if (/^[a-zA-Z]$/.test(key))
            {
            event.preventDefault();
            }

            var messageElement = document.getElementById('message');
            if (finishReading <= startReading) {
                messageElement.textContent = 'End Odometer End Reading must be greater than Start Reading.';
                messageElement.style.color = 'red';
                addButton.style.display = 'none';

            } else {
                messageElement.textContent = '';
                addButton.style.display = '';

            }
        }
    </script>


<script>

    const first = document.getElementById('first');
    const second = document.getElementById('second');
    const third = document.getElementById('third');
    const charge1 = document.getElementById('charge1');
    const charge2 = document.getElementById('charge2');
    const charge3 = document.getElementById('charge3');
    const charge4 = document.getElementById('charge4');
    const charge5 = document.getElementById('charge5');
    const charge6 = document.getElementById('charge6');

    first.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        second.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        third.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        charge1.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        charge2.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });


        charge3.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });


        charge4.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });


        charge5.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });

        charge6.addEventListener('keydown', function(event) {
    const key = event.key;
    if (/^[a-zA-Z]$/.test(key)) {
                event.preventDefault();
            }
        });
</script>

    <script>
        var firstHiddenPrice = parseFloat($('#hiddenPrice').val()) || 0;
        var paysecond = parseFloat($('#second').val()) || 0;
        var paythird = parseFloat($('#third').val()) || 0;
        var total=firstHiddenPrice-paysecond-paythird;
        // $('#first').val(total) || 0;
       // edValueKeyPrs();
        function edValueKeyPrs(qi)
        {
            var quantity1 = parseFloat($('#first').val()) || 0;
            var quantity2 = parseFloat($('#second').val()) || 0;
            var quantity3 = parseFloat($('#third').val()) || 0;
            var totalAmount = quantity1 + quantity2 + quantity3;
            $('#subtotal').val(totalAmount);
        }
    </script>




    <script>
        var hiddenPrice = parseFloat($('#hiddenChargePrice').val()) || 0;
        var charge22 = parseFloat($('#charge2').val()) || 0;
        var charge33 = parseFloat($('#charge3').val()) || 0;
        var charge44 = parseFloat($('#charge4').val()) || 0;
        var charge55 = parseFloat($('#charge5').val()) || 0;
        var charge66 = parseFloat($('#charge6').val()) || 0;
        var totalCharge=charge66-charge22-charge33-charge44-charge55;
      //  $('#charge1').val(totalCharge) || 0;

        function edValueKeyChargePrs(qi)
        {
            var charge1 = parseFloat($('#charge1').val()) || 0;
            var charge2 = parseFloat($('#charge2').val()) || 0;
            var charge3 = parseFloat($('#charge3').val()) || 0;
            var charge4 = parseFloat($('#charge4').val()) || 0;
            var charge5 = parseFloat($('#charge5').val()) || 0;
            var totalAmount = charge1 + charge2 + charge3 + charge4 + charge5;
            $('#charge6').val(totalAmount);

        }




    </script>




<script>

    function getDriverResponiable(select)

    {

        var clientId=select.value;



       $.ajaxSetup({



                headers: {



                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



                }



                });



     $.ajax({

                type:'POST',

                url:"{{ route('admin.getDriver.Responiable') }}",

                data:{vehicleTye:clientId},

                success:function(data){

                    if (data.success==200) {

                        // $('#regoId').val(data.regoType.rego);
                        $('#regoId').find('option:not(:first)').remove();
                        $('#regoId')[0].options.length = 0;

                        // var html2='';
                        // $.each(data.driverRsps,function(index,driver){
                        //     html2 +='<option value="">Choose one</option><option value="'+driver.id+'">'+driver.userName+'</option>';
                        //     });
                        //   $('#appendDriverResponiable').append(html2);


                          var html12='';
                          $.each(data.driverRego,function(index,driver){
                            html12 +='<option value="">Choose one</option><option value="'+driver.rego+'">'+driver.rego+'</option>';
                            });
                          $('#regoId').append(html12);


                        //
                    }

                    if (data.success==400) {
                        $('#regoId').find('option:not(:first)').remove();
                        $('#regoId')[0].options.length = 0;
                    }
                }
                });

            }

</script>






<script>



    function getdata(select)

    {

         if (!pagrLoaded) {

        var stateId=select.value;

       $.ajaxSetup({



                headers: {



                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')



                }



                });



     $.ajax({



                type:'POST',



                url:"{{ route('admin.gct') }}",



                data:{stateId:stateId},



                success:function(data){



                    if (data.success==200) {



                           $('#appendClient').find('option:not(:first)').remove();

                            $('#appendClient')[0].options.length = 0;



                        var html2='';



                        $.each(data.items,function(index,items){



                            html2 +='<option value="">Choose one</option><option value="'+items.id+'">'+items.name+'</option>';



                            });

                            // console.log(html2);

                          $('#appendClient').append(html2);



                    }

                    if (data.success==400) {



                            $('#appendClient').find('option:not(:first)').remove();

                            $('#appendClient')[0].options.length = 0;





                            }



                }

                });

            }

    }



</script>




<script>

    function getCostCenter(select)
    {

         if (!pagrLoaded) {
        var clientId=select.value;
       $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
     $.ajax({
                type:'POST',
                url:"{{ route('admin.gCc') }}",
                data:{clientId:clientId},
                success:function(data){
                    if (data.success==200)

                    {
                        $('#appendCostCenter').find('option:not(:first)').remove();

                        $('#appendCostCenter')[0].options.length = 0;

                        $('#appendVehicleType').find('option:not(:first)').remove();

                        $('#appendVehicleType')[0].options.length = 0;


                        $('#appendBase').find('option:not(:first)').remove();
                        $('#appendBase')[0].options.length = 0;



                        var html2='';

                        $.each(data.items,function(index,items){

                            html2 +='<option value="'+items.id+'">'+items.name+'</option>';

                            });

                          $('#appendCostCenter').append(html2);



                            var html3='';

                            $.each(data.getType,function(index,items){

                            html3 +='<option value="">Choose one</option><option value="'+items.get_client_type.id+'">'+items.get_client_type.name+'</option>';

                            });

                            $('#appendVehicleType').append(html3);



                              var html4='';

                                $.each(data.clientBase,function(index,items){

                                    html4 +='<option value="">Choose one</option><option value="'+items.id+'">'+items.base+'</option>';

                                    });

                                    $('#appendBase').append(html4);

                    }


                    if (data.success==400) {

                        $('#appendCostCenter').find('option:not(:first)').remove();
                        $('#appendCostCenter')[0].options.length = 0;

                        $('#appendBase').find('option:not(:first)').remove();
                        $('#appendBase')[0].options.length = 0;

                        $('#appendVehicleType').find('option:not(:first)').remove();
                        $('#appendVehicleType')[0].options.length = 0;



                    }

                }

                });

            }

    }

</script>



@endsection
