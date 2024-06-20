@extends('admin.layout')
@section('content')

<style>
   .light-mode .btn.text-danger {
    background: #e82646;
    width: 0px;
    margin: auto;
}


#clientAddressError
{
    color: #e82646;
}
.chargePay{
    border: 2px solid #207009 !important;
}

.chargeClr {
    border: 2px solid #ff3939 !important;
}

.dark-mode .chargeClr {
	border: none !important;
	outline: 2px solid red !important;
}
.dark-mode .chargePay {
	border: none !important;
    border: 2px solid #207009 !important;
}

.dark-mode .customClose{
    color: #fff;
}

.light-mode .customClose {

    color: #000 !important;
}

.customClose {
    font-size: 25px;
    padding: 0pc;
    color: #fff;
    position: absolute;
    display: flex;
    justify-content: center;
    background: transparent;
    border: none;
    right: 20px;
}
</style>

</style>

   <!-- delete Modal -->
   <div class="modal fade zoomIn" id="editRate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 62%;">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close customClose" data-bs-dismiss="modal"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>Monetize Info</h4>

            </div>

            <div class="modal-body">
                <div class="mt-2 text-center">
                    <form method="post" action="{{ route('client.clientRateEdit') }}"/>@csrf

                    <div class="row align-items-center">
                        <div class="col-lg-12">
                           <div class="title_head">
                              {{-- <h4>Monetize Info</h4> --}}
                           </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="check_box">
                                   <div class="form-group">
                                    <label class="form-label" for="exampleInputEmail1" style="margin-right: auto;
                                    text-align: left;">Vehicle Type</label>
                                        <select class="form-control" id="edittype" name="type" data-placeholder="Choose one" tabindex="-1" aria-hidden="true">
                                          <option value="">Selec Any one</option>
                                          @foreach ($types as $alltypes)
                                          <option value="{{ $alltypes->id}}">{{ $alltypes->name }}</option>
                                          @endforeach
                                        </select>
                                   </div>
                                </div>
                             </div>
                        </div>
                        <div class="row align-items-center">

                           <input type="hidden" name="clientId" value="{{ $clientId }}">
                           <input type="hidden" name="typeiD" id="typeiD">
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Day </label>
                                 <input type="number" class="form-control" name="hourlyRate" step="any" min="0"  id="hourlyRateChargeableDays" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Night</label>
                                 <input type="number" class="form-control" step="any" name="hourlyRateChargeable" min="0"  id="ourlyRateChargeableNight" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Saturday</label>
                                 <input type="number" class="form-control" step="any" name="HourlyRateChargeableSaturday" min="0"  id="hourlyRateChargeableSaturday" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Sunday</label>
                                 <input type="number" class="form-control" step="any" name="HourlyRateChargeableSunday" min="0"  id="hourlyRateChargeableSunday" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Day</label>
                                 <input type="number" class="form-control" step="any" name="HourlyRatePayableDay" min="0"  id="hourlyRatePayableDay" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Night</label>
                                 <input type="number" class="form-control" step="any" id="hourlyRatePayableNight" name="hourlyRatePayableNight1" id="exampleInputEmail1" min="0"  aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Saturday</label>
                                 <input type="number" class="form-control" step="any" id="hourlyRatePayableSaturday" name="HourlyRatePayableSaturday" min="0"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-3">
                              <div class="mb-3">
                                 <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Sunday</label>
                                 <input type="number" class="form-control" step="any" id="hourlyRatePayableSunday" name="HourlyRatePayableSunday" min="0"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="search_btn text-end">
                                 <button type="submit" class="theme_btn btn btn-primary" fdprocessedid="cgqwgp">+ Add Rate</button>
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
<!--end modal -->

<!--app-content open-->
<div class="main-content app-content mt-0">
   <!-- PAGE-HEADER -->
   <div class="page-header">
      <h1 class="page-title">Client Sub Menu</h1>
      <div>
         <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('clients') }}">Clients</a></li>
            <li class="breadcrumb-item active" aria-current="page">Client Edit</li>
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
                     <ul class="nav nav-tabs">

                        <li class="nav-item">
                           <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                           <span><i class="ti-light-bulb"></i></span>
                           <span> Basic Information</span>
                           </a>
                        </li>


                        <li class="nav-item">
                           <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link ">
                           <span><i class="ti-agenda"></i></span>
                           <span> Address</span>
                           </a>
                        </li>


                        <li class="nav-item">
                           <a href="#messages" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                           <span><i class="fe fe-dollar-sign"></i></span>
                           <span>Rate </span>
                           </a>
                        </li>


                        <li class="nav-item">
                           <a href="#document" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                           <span><i class="ti-id-badge"></i></span>
                           <span>Cost Centers</span>
                           </a>
                        </li>

                        <li class="nav-item">
                            <a href="#clientBase" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            <span><i class="fe fe-dollar-sign"></i></span>
                            <span>Base</span>
                            </a>
                         </li>


                     </ul>
                  </div>
                  <div class="card-body">

                     <div class="tab-content  text-muted">


                        <div class="tab-pane show active" id="home">
                           <form action="{{ route('client.edit', ['id' => $clientId]) }}" method="post">
                              @csrf
                              <input type="hidden" name="addressValue" value="1"/>
                              <div class="main_bx_dt__">
                                 <div class="top_dt_sec">
                                    <div class="row">
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Name <span class="red">*</span></label>
                                             <input type="text" class="form-control" name="name" value="{{ $Editclient->name??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Short Name <span class="red">*</span></label>
                                             <input type="text" class="form-control"  name="shortName" value="{{ $Editclient->shortName??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">ACN</label>
                                             <input type="text" class="form-control" name="acn" value="{{ $Editclient->acn??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">ABN</label>
                                             <input type="text" class="form-control" name="abn" value="{{ $Editclient->abn??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                          </div>
                                       </div>

                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">State<span class="red">*</span></label>
                                             <div class="form-group">
                                                <select class="form-control select2 form-select" name="state" data-placeholder="Choose one" required>
                                                      <option value=""></option>
                                                    @foreach ($getStates as $algetStates)
                                                        <option value="{{ $algetStates->id }}" {{ $Editclient->state == $algetStates->id ? 'selected="selected"' : '' }}>{{ $algetStates->name ?? ''  }}</option>
                                                        @endforeach

                                                </select>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Phone Principal <span class="red">*</span></label>
                                             <input type="text" class="form-control" name="phonePrinciple" value="{{ $Editclient->phonePrinciple??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Mobile Phone <span class="red">*</span></label>
                                             <input type="text" class="form-control" name="mobilePhone" value="{{ $Editclient->mobilePhone??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Phone Aux</label>
                                             <input type="text" class="form-control" name="phoneAux" value="{{ $Editclient->phomneAux??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Fax Phone</label>
                                             <input type="text" class="form-control" name="faqPhone" value="{{ $Editclient->faxPhone??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                          </div>
                                       </div>
                                       <div class="col-lg-3">
                                          <div class="mb-3">
                                             <label class="form-label" for="exampleInputEmail1">Website</label>
                                             <input type="text" class="form-control" name="webSite" value="{{ $Editclient->website??'' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="mb-3">

                                             <label class="form-label" for="exampleInputEmail1">Notes</label>
                                             <textarea class="form-control mb-4" name="Notes" placeholder="Textarea" rows="4">{{ trim($Editclient->notes??'') }}</textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="bottom_footer_dt">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="action_btns text-end">
                                            <button type="submit" value="Submit" class="btn btn-primary"><i class="bi bi-save"></i> Save And Next</button>
                                        </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>


                        <div class="tab-pane" id="profile">
                           <div class="main_bx_dt__">
                              <div class="top_dt_sec">

                                 <form id="saveClient">
                                    <input type="hidden" name="addressValue" id="addressValue2" value="2"/>
                                    <input type="hidden" name="clientId"  value="{{ $clientId }}"/>
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="row">
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Zip Code</label>
                                                   <input type="text" class="form-control" name="zipCode" id="clientAddressCode" aria-describedby="emailHelp" placeholder="">
                                                   <span id="clientAddressError" style="display: none">Please Add Zip Code</span>

                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Unit</label>
                                                   <input type="text" class="form-control" name="unit" id="unitErrorId" aria-describedby="emailHelp" placeholder="">
                                                   <span id="clientAddressErrorUnit" style="display: none;color:red">Please Add Unit</span>
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Address Number</label>
                                                   <input type="text" class="form-control" name="address" id="exampleInputAddress" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Street Address</label>
                                                   <input type="text" class="form-control" name="street" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Suburb</label>
                                                   <input type="text" class="form-control" name="suburd" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">City</label>
                                                   <input type="text" class="form-control" name="city" id="cityError" aria-describedby="emailHelp" placeholder="">
                                                   <span id="clientAddressErrorCity" style="display: none;color:red">Please Add City</span>
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">State</label>
                                                   <input type="text" class="form-control" name="addressstate" id="stateError" aria-describedby="emailHelp" placeholder="">
                                                   <span id="clientAddressErrorState" style="display: none;color:red">Please Add State</span>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="add_address text-end">
                                             <button type="submit" class="btheme_btn btn btn-primary" id="add_comment_btn">+ Add Address</button>
                                        </div>
                                    </div>
                                 </form>


                                 <div class="col-lg-12 mt-4">
                                 <div class="table-responsive">
                                 <table  class="table table-bordered text-nowrap mb-0">
                                 <thead class="border-top">
                                 <tr>
                                 <th>#</th>
                                 <th class="bg-transparent border-bottom-0">Zip Code</th>
                                 <th class="bg-transparent border-bottom-0">Unit</th>
                                 <th class="bg-transparent border-bottom-0">Address Number</th>
                                 <th class="bg-transparent border-bottom-0">Street Address</th>
                                 <th class="bg-transparent border-bottom-0">Suburb</th>
                                 <th class="bg-transparent border-bottom-0">City</th>
                                 <th class="bg-transparent border-bottom-0">State</th>
                                 <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                 </tr>
                                 </thead>

                                 <tbody  id="clientData">
                                    @foreach ($Editclient->getaddress as $key=>$alladdress)
                                        <tr class="border-bottom">
                                            <td>
                                            {{$key+1}}
                                            </td>
                                            <td>{{$alladdress->zipCode  }}</td>
                                            <td>{{$alladdress->unit  }}</td>
                                            <td>{{$alladdress->addressNumber  }}</td>
                                            <td>{{$alladdress->streetAddress  }}</td>
                                            <td>{{$alladdress->suburb  }}</td>
                                            <td>{{$alladdress->city  }}</td>
                                            <td>{{$alladdress->state  }}</td>
                                            <td><a onclick="removeAddress(this,'{{$alladdress->id}}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                 </tbody>
                                 </table>
                                 </div>
                                 </div>
                                 </div>
                              </div>
                           </div>
                           <!-- main_bx_dt -->
                        </div>

                        <div class="tab-pane email_template" id="messages">
                           <div class="main_bx_dt__">
                              <div class="top_dt_sec">
                                 <form id="saveRate" method="post">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="row align-items-center">
                                             <div class="col-lg-12">
                                                <div class="title_head">
                                                   <h4>Monetize Info</h4>
                                                </div>
                                             </div>
                                             <input type="hidden" name="addressValue"  value="3"/>
                                             <input type="hidden" name="clientId"  value="{{ $clientId }}"/>
                                             <div class="col-lg-12">
                                                <div class="row">
                                                <div class="col-lg-3">
                                                <div class="check_box">
                                                   <label class="form-label" for="exampleInputEmail1">Vehicle Type</label>
                                                   <div class="form-group">
                                                      <select class="form-control select2 form-select" id="VehicleType" name="type" data-placeholder="Choose one">
                                                        <option value=""></option>
                                                         @foreach ($types as $alltypes)
                                                         <option value="{{ $alltypes->id}}">{{ $alltypes->name }}</option>
                                                         @endforeach
                                                      </select>
                                                   </div>
                                                   <span id="VehicleTypeError" class="text-danger" hidden>Please select any one type.</span>

                                                </div>
                                             </div>
                                                </div>
                                             </div>
                                             


                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Day </label>
                                                   <input type="number" class="form-control chargeClr" name="hourlyRate" min="0" step="any" id="hourlyRateChargeableDays" aria-describedby="emailHelp" placeholder="">

                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Night</label>
                                                   <input type="number" class="form-control chargeClr" name="hourlyRateChargeable" min="0" id="ourlyRateChargeableNight" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Saturday</label>
                                                   <input type="number" class="form-control chargeClr" name="HourlyRateChargeableSaturday" min="0" id="hourlyRateChargeableSaturday" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Chargeable Sunday</label>
                                                   <input type="number" class="form-control chargeClr" name="HourlyRateChargeableSunday" min="0" id="hourlyRateChargeableSunday" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Day</label>
                                                   <input type="number" class="form-control chargePay" name="HourlyRatePayableDay" min="0" id="hourlyRatePayableDay" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Night</label>
                                                   <input type="number" class="form-control chargePay" name="HourlyRatePayableNight" id="hourlyRateChargeable" min="0" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>


                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Saturday</label>
                                                   <input type="number" class="form-control chargePay" name="HourlyRatePayableSaturday" min="0" id="HourlyRatePayableSaturday" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-3">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Hourly Rate Payable Sunday</label>
                                                   <input type="number" class="form-control chargePay" name="HourlyRatePayableSunday" min="0" id="HourlyRatePayableSunday" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>
                                             <div class="col-lg-12">
                                                <div class="search_btn text-end">
                                                   <button type="submit" class="theme_btn btn btn-primary" fdprocessedid="cgqwgp">+ Add Rate</button>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                 </form>


                                 <div class="col-lg-12 mt-5">
                                 <div class="table-responsive">


                                 <table  class="table table-bordered text-nowrap mb-0">
                                        <thead class="border-top">
                                        <tr>
                                        <th class="bg-transparent border-bottom-0">Id</th>
                                        <th class="bg-transparent border-bottom-0">Vehicle Type</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Day</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Night</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Saturday</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Chargeable Sunday</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Day</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Night</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Saturday</th>
                                        <th class="bg-transparent border-bottom-0">Hourly Rate Payable Sunday
                                        </th>
                                        <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                        </tr>
                                        </thead>

                                        <tbody id="clientRate">
                                                @forelse ($Editclient->getrates as $key=>$allEditclient)
                                                    <tr class="border-bottom">
                                                        <td>
                                                        {{ $key+1 }}
                                                        </td>
                                                        <td>{{ $allEditclient->getType->name??'N/A'}}</td>
                                                        <td>{{ $allEditclient->hourlyRateChargeableDays}}</td>
                                                        <td>{{ $allEditclient->ourlyRateChargeableNight	}}</td>
                                                        <td>{{ $allEditclient->hourlyRateChargeableSaturday}}</td>
                                                        <td>{{ $allEditclient->hourlyRateChargeableSunday}}</td>
                                                        <td>{{ $allEditclient->hourlyRatePayableDay}}</td>
                                                        <td>{{ $allEditclient->hourlyRatePayableNight}}</td>
                                                        <td>{{ $allEditclient->hourlyRatePayableSaturday}}</td>
                                                        <td>{{ $allEditclient->hourlyRatePayableSunday}}</td>

                                                        <td>
                                                            <div class="g-2">
                                                                <a onclick="editRate('{{ $allEditclient->getType->id??'N/A'}}','{{ $allEditclient->hourlyRateChargeableDays??'N/A'}}','{{ $allEditclient->ourlyRateChargeableNight??'N/A'}}','{{ $allEditclient->hourlyRateChargeableSaturday??'N/A'}}','{{ $allEditclient->hourlyRateChargeableSunday??'N/A'}}','{{ $allEditclient->hourlyRatePayableDay??'N/A'}}','{{ $allEditclient->hourlyRatePayableNight??'N/A'}}','{{ $allEditclient->hourlyRatePayableSaturday??'N/A'}}','{{ $allEditclient->hourlyRatePayableSunday??'N/A'}}')" class="btn text-primary btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>
                                                                <a onclick="removeRate(this,'{{$allEditclient->id}}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                            </div>
                                                        </td>


                                                    </tr>
                                                @empty
                                                @endforelse
                                        </tbody>
                                 </table>


                                 </div>
                                 </div>
                                 </div>
                              </div>
                              <div class="bottom_footer_dt">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="action_btns text-end">
                                          {{-- <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a> --}}
                                          <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- main_bx_dt -->
                        </div>


                        <div class="tab-pane email_template" id="document">
                           <div class="main_bx_dt__">
                              <div class="top_dt_sec">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <form id="costCenter" method="post">
                                          <input type="hidden" name="addressValue" value="4"/>
                                          <input type="hidden" name="clientId"  value="{{ $clientId }}"/>
                                          <div class="row align-items-center">


                                             <div class="col-lg-6">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Client <span class="red">*</span></label>
                                                       <select class="form-control select2 form-select" name="selectClient" data-placeholder="Choose one" disabled="true">
                                                     <option value="">Choose one</option>
                                                      @foreach ($selectClient as $allClient)
                                                      <option value="{{ $allClient->id }}" {{ $allClient->id == $clientId ? 'selected="selected"' : '' }}>{{ $allClient->name }}</option>
                                                      @endforeach
                                                   </select>
                                                </div>
                                             </div>

                                             <div class="col-lg-6">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Name <span class="red">*</span></label>
                                                   <input type="text" class="form-control" name="name" id="costCenterName" aria-describedby="emailHelp" placeholder="">
                                                   <span id="clientCenterNameError" class="text-danger" hidden>This field is required.</span>

                                                   <span id="costCenterError"  class="text-danger" hidden>This cost center is already exist</span>

                                                </div>
                                             </div>



                                              {{-- <div class="col-lg-6">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Location</label>
                                                   <input type="text" class="form-control" name="location" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div> --}}

                                             <div class="col-lg-12 mb-5">
                                                <div class="search_btn text-end">
                                                   <button type="submit" class="theme_btn btn btn-primary" fdprocessedid="cgqwgp">+ Add Cost </button>
                                                </div>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>

                                 <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table  class="table table-bordered text-nowrap mb-0">
                                            <thead class="border-top">
                                             <tr>
                                                <th class="bg-transparent border-bottom-0">Id</th>
                                                <th class="bg-transparent border-bottom-0">Cost Centers</th>
                                                {{-- <th class="bg-transparent border-bottom-0">Location</th> --}}
                                                <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                             </tr>
                                          </thead>

                                          <tbody id="costCenterAppend">
                                             @foreach ($Editclient->getCenter as $key=>$allgetCenter)
                                                <tr class="border-bottom">
                                                    <td>
                                                    {{ $key+1 }}
                                                    </td>
                                                    <td>{{ $allgetCenter->name}}</td>
                                                    {{-- <td>{{ $allgetCenter->location??'N/A'}}</td> --}}
                                                    <td>
                                                        <a onclick="removCenters(this,'{{$allgetCenter->id}}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                    </td>
                                                </tr>
                                             {{-- @empty --}}
                                            @endforeach
                                          </tbody>



                                       </table>
                                    </div>
                                 </div>





                              </div>
                           </div>

                           {{-- <div class="bottom_footer_dt">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="action_btns text-end">
                                       <a href="#" class="btn btn-primary"><i class="bi bi-save"></i> Save</a>
                                       <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                    </div>
                                 </div>
                              </div>
                           </div> --}}
                        </div>
                        <!-- main_bx_dt -->

                        <div class="tab-pane " id="clientBase">
                            <div class="main_bx_dt__">
                                <div class="top_dt_sec">
                                   <div class="row">
                                      <div class="col-lg-12">
                                         <form id="clientBaseForm" method="post">
                                            <input type="hidden" name="addressValue" value="6"/>
                                            <input type="hidden" name="clientId"  value="{{ $clientId }}"/>
                                            <div class="row align-items-center">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                       <label class="form-label" for="exampleInputEmail1">Cost Center <span class="red">*</span></label>
                                                       <select class="form-control select2 form-select" name="clientCenterName" id="costCenterNameAppendData" required>
                                                        <option value="">Select Any One</option>
                                                        @forelse ($ClientcenterName as $allClientcenterName)
                                                        <option value="{{ $allClientcenterName->name }}">{{ $allClientcenterName->name }}</option>
                                                        @empty

                                                        @endforelse

                                                       </select>
                                                    </div>
                                                 </div>

                                                <div class="col-lg-6">
                                                  <div class="mb-3">
                                                     <label class="form-label" for="exampleInputEmail1">Base <span class="red">*</span></label>
                                                     <input type="text" class="form-control" name="clientBase" id="clientBaseAdd" aria-describedby="emailHelp" placeholder="">
                                                     <span id="clientBaseError" class="text-danger" hidden>This field is required.</span>
                                                     <span id="cleintBaseEr"  class="text-danger" hidden>This Base is already exist</span>

                                                  </div>
                                               </div>




                                              <div class="col-lg-6">
                                                <div class="mb-3">
                                                   <label class="form-label" for="exampleInputEmail1">Location</label>
                                                   <input type="text" class="form-control" name="baseLocation" id="baseLocation" aria-describedby="emailHelp" placeholder="">
                                                </div>
                                             </div>


                                               <br>
                                               <div class="search_btn text-end">

                                                <button type="submit" class="theme_btn btn btn-primary" fdprocessedid="cgqwgp">+ Add Base </button>
                                             </div>
                                             <br>

                                             <br><br>
                                            </div>
                                         </form>
                                      </div>
                                   </div>

                                   <div class="col-lg-12">
                                      <div class="table-responsive">
                                        <table  class="table table-bordered text-nowrap mb-0">
                                            <thead class="border-top">
                                               <tr>
                                                  <th class="bg-transparent border-bottom-0">Id</th>
                                                  <th class="bg-transparent border-bottom-0">Client Base</th>
                                                  <th class="bg-transparent border-bottom-0">Cost Center</th>
                                                  <th class="bg-transparent border-bottom-0">Location</th>
                                                  <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                               </tr>
                                            </thead>

                                            <tbody id="clientBaseAppend">
                                               @foreach ($clientbase as $key=>$allclientbase)
                                               <tr class="border-bottom">
                                                  <td>
                                                     {{ $key+1 }}
                                                  </td>
                                                  <td>{{ $allclientbase->base}}</td>
                                                  <td>{{ $allclientbase->cost_center_name}}</td>
                                                  <td>{{ $allclientbase->location}}</td>
                                                  <td>
                                                      <a onclick="removeBase(this,'{{$allclientbase->id}}')" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                  </td>
                                               </tr>
                                               @endforeach
                                            </tbody>
                                         </table>
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
      </div>
   </div>
</div>
</div>

<script>
   $('#saveClient').on('submit',function(e) {


          var zipCode = $.trim($('#clientAddressCode').val());
          var cityError = $.trim($('#cityError').val());
          var stateError = $.trim($('#stateError').val());
          var unitError = $.trim($('#unitErrorId').val());

            if (zipCode  === '') {
                $("#clientAddressError").show();
                return false;
            }
            else{
                $("#clientAddressError").hide();
            }
            if (unitError  === '') {
                $("#clientAddressErrorUnit").show();
                return false;
            }
            else{
                $("#clientAddressErrorUnit").hide();
            }
            if (cityError  === '') {
                $("#clientAddressErrorCity").show();
                return false;
            }
            else{
                $("#clientAddressErrorCity").hide();
            }
            if (stateError  === '') {
                $("#clientAddressErrorState").show();
                return false;
            }
            else{
                $("#clientAddressErrorState").hide();
            }




           e.preventDefault();
           var addressValue = $('#addressValue2').val();
           var zipCode  = $("input[name=zipCode]").val();
           var unit     = $("input[name=unit]").val();
           var address  = $("input[name=address]").val();
           var street   = $("input[name=street]").val();
           var suburd   = $("input[name=suburd]").val();
           var city     = $("input[name=city]").val();
           var state    = $("input[name=addressstate]").val();
           var clientId = $("input[name=clientId]").val();
           var rowCount = $("#clientData tr").length;
           var countData=rowCount+1;


               $.ajax({
                           type:'POST',
                           url:'{{ route('client.edit', ['id' => 2]) }}',
                           headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
                           data:{clientId:clientId,addressValue:addressValue,zipCode:zipCode,unit:unit,address:address,street:street,suburd:suburd,city:city,state:state},
                           success:function(data){
                               if (data.success==200) {
                                                       swal({
                                                               type:'success',
                                                               title: 'Added!',
                                                               text: 'Client Added Successfully',
                                                               timer: 1000
                                                           });
                                                   var rowHtml2 = `<tr>
                                                                        <td>${countData}</td>
                                                                        <td>${data.data.zipCode??'N/A'}</td>
                                                                        <td>${data.data.unit??'N/A'}</td>
                                                                        <td>${data.data.addressNumber??'N/A'}</td>
                                                                        <td>${data.data.streetAddress??'N/A'}</td>
                                                                        <td>${data.data.suburb??'N/A'}</td>
                                                                        <td>${data.data.city??'N/A'}</td>
                                                                        <td>${data.data.state??'N/A'}</td>
                                                                        <td><a onclick="removeAddress(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                                    </tr>`;

                                                   $("#clientData").append(rowHtml2);
                                                   $("#saveClient")[0].reset();

                                                   }
                           }
                       });

                     });


function removeAddress(that,clientId) {
   var label="Address";
        swal({
                title: "Are you sure?",
                text: "Do you want to Delete!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('client.delete')}}",
                        data: {
                            "clientId": clientId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Deleted!',
                                    text: 'Address Deleted',
                                    timer: 1000
                                });

                                if(that){
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }
                        },
                            error: function(data) {
                        }
                    });
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }
</script>




<script>
   $('#saveRate').on('submit',function(e) {


       var clientCenterName= document.getElementById('VehicleType').value;
       if(clientCenterName == ''){
                $("#VehicleTypeError").attr('hidden',false);
                return false;
            }
            else{
                $("#VehicleTypeError").attr('hidden',true);
            }



       e.preventDefault();
           var rowCount = $("#clientRate tr").length;
           var countData=rowCount+1;
       var formData = new FormData(this);
       $.ajax({
           type: "POST",
           url: "{{ route('client.edit', ['id' => 3]) }}",
           headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data) {
               if (data.success==200) {
                                           swal({
                                                   type:'success',
                                                   title: 'Added!',
                                                   text: 'Client Rate Added Successfully',
                                                   timer: 1000
                                               });
                                       var rowHtml2 = `<tr>
                                                   <td>${countData}</td>
                                                   <td>${data.data.typeName}</td>
                                                   <td>${data.data.hourlyRateChargeableDays}</td>
                                                   <td>${data.data.ourlyRateChargeableNight}</td>
                                                   <td>${data.data.hourlyRateChargeableSaturday}</td>
                                                   <td>${data.data.hourlyRateChargeableSunday}</td>
                                                   <td>${data.data.hourlyRatePayableDay}</td>
                                                   <td>${data.data.hourlyRatePayableNight}</td>
                                                   <td>${data.data.hourlyRatePayableSaturday}</td>
                                                   <td>${data.data.hourlyRatePayableSunday}</td>

                                                   <td><a onclick="removeRate(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>

                                               </tr>`;

                                         $("#clientRate").append(rowHtml2);
                                         $("#saveRate")[0].reset();
                                       }

                // if (data.success==300) {
                                           swal({
                                                   type:'success',
                                                   title: 'Added!',
                                                   text: 'Client Rate Updated Successfully',
                                                   timer: 1000
                                               });

                                               setTimeout(function() {
                                                                location.reload();
                                                            }, 100);


                                         $("#saveRate")[0].reset();
                                     //  }

           },
       });

   })
</script>



<script>
function removeRate(that,clientId) {
    var label="Rate";
        swal({
                title: "Are you sure?",
                text: "Do you want to Delete!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Delete it!",
                cancelButtonText: "No, Cancel It",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('client.rate')}}",
                        data: {
                            "clientId": clientId,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: 'json',
                        success: function(result) {
                                swal({
                                    type:'success',
                                    title: 'Deleted!',
                                    text: 'Rate Deleted',
                                    timer: 1000
                                });

                                if(that){
                                    //delete specific row
                                    $(that).parent().parent().remove();
                                }

                        },

                            error: function(data) {
                            console.log("error");
                            console.log(result);
                        }
                    });
                } else {
                    swal("Cancelled", label+" safe :)", "error");
                }
            });
    }
</script>


<script>
    function removCenters(that,clientId) {
        var label="Cost Center";
            swal({
                    title: "Are you sure?",
                    text: "Do you want to Delete!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Delete it!",
                    cancelButtonText: "No, Cancel It",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            url: "{{route('client.centers')}}",
                            data: {
                                "clientId": clientId,
                                "_token": "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function(result) {
                                    swal({
                                        type:'success',
                                        title: 'Deleted!',
                                        text: 'Cost Center Deleted',
                                        timer: 1000
                                    });

                                    if(that){
                                        $(that).parent().parent().remove();
                                    }

                            },

                                error: function(data) {
                                console.log("error");
                                console.log(result);
                            }
                        });
                    } else {
                        swal("Cancelled", label+" safe :)", "error");
                    }
                });
        }
    </script>



<script>
    $('#clientBaseForm').on('submit',function(e) {
        e.preventDefault();

            var clientBase= $("#clientBaseAdd").val();

            var costCenterNameAppendData= $("#costCenterNameAppendData").val();

            if(clientBase.trim() == ''){
                $("#clientBaseError").attr('hidden',false);
                return false;
            }
            else{
                $("#clientBaseError").attr('hidden',true);
            }

            if(costCenterNameAppendData.trim() == ''){
                $("#clientBaseError").attr('hidden',false);
                return false;
            }
            else{
                $("#clientBaseError").attr('hidden',true);
            }


            var rowCount = $("#clientBaseAppend tr").length;
            var countData=rowCount+1;
            var formData = new FormData(this);
            $.ajax({
            type: "POST",
            url: "{{ route('client.edit', ['id' => 6]) }}",
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
               if (data.success==200) {
                                           swal({
                                                   type:'success',
                                                   title: 'Added!',
                                                   text: 'Client Base Added Successfully',
                                                   timer: 1000
                                               });
                                       var rowHtml2 = `<tr>
                                                   <td>${countData}</td>
                                                   <td>${data.data.base}</td>
                                                   <td>${data.data.cost_center_name}</td>
                                                   <td>${data.data.location}</td>
                                                   <td><a onclick="removeBase(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>

                                               </tr>`;

                                         $("#clientBaseAppend").append(rowHtml2);

                                        var html2='';
                                         $.each(data.allClientcenter,function(index,items){
                                                    html2 +='<option value="'+items.id+'">'+items.name+'</option>';
                                                    });
                                          $("#costCenterName").append(html2);
                                         $("#clientBaseForm")[0].reset();
                                         $('#costCenterNameAppendData').val('').trigger('change');
                                         $("#cleintBaseEr").attr('hidden',true);
                                       }

                                       if (data.success==400) {
                                        $("#cleintBaseEr").attr('hidden',false);
                                                 //  return false;
                                       }
            },
        });

    })
 </script>


<script>
   function removeBase(that,clientId) {
    var label="Base";
           swal({
                   title: "Are you sure?",
                   text: "Do you want to Delete!",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonClass: "btn-danger",
                   confirmButtonText: "Yes, Delete it!",
                   cancelButtonText: "No, Cancel It",
                   closeOnConfirm: false,
                   closeOnCancel: false
               },
               function(isConfirm) {
                   if (isConfirm) {
                       $.ajax({
                           type: "POST",
                           url: "{{route('client.base.delete')}}",
                           data: {
                               "clientId": clientId,
                               "_token": "{{ csrf_token() }}"
                           },
                           dataType: 'json',
                           success: function(result) {
                                   swal({
                                       type:'success',
                                       title: 'Deleted!',
                                       text: 'Client Base Deleted',
                                       timer: 1000
                                   });

                                   if(that){
                                       //delete specific row
                                       $(that).parent().parent().remove();
                                   }

                           },

                               error: function(data) {
                               console.log("error");
                               console.log(result);
                           }
                       });
                   } else {
                       swal("Cancelled", label+" safe :)", "error");
                   }
               });
       }
   </script>




<script>
   $('#costCenter').on('submit',function(e) {
       e.preventDefault();

       var clientCenterName= $("#costCenterName").val();
       if(clientCenterName.trim() == ''){
                $("#clientCenterNameError").attr('hidden',false);
                return false;
            }


           var rowCount = $("#costCenterAppend tr").length;
           var countData=rowCount+1;
       var formData = new FormData(this);
       $.ajax({
           type: "POST",
           url: "{{ route('client.edit', ['id' => 4]) }}",
           headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
           data: formData,
           cache: false,
           contentType: false,
           processData: false,
           success: function(data) {
               if (data.success==200) {
                                       swal({
                                                   type:'success',
                                                   title: 'Added!',
                                                   text: 'Client Cost Centers Added Successfully',
                                                   timer: 1000
                                               });
                                                   var rowHtml2 = `<tr>
                                                                   <td>${countData}</td>
                                                                   <td>${data.data.name}</td>
                                                                   <td>
                                                                           <div class="g-2">
                                                                               <a onclick="removCenters(this,${data.data.id})" class="btn text-danger btn-sm" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>
                                                                           </div>
                                                                       </td>
                                                               </tr>`;
                                         $("#costCenterAppend").append(rowHtml2);

                                         var html2 =`<option value="${data.data.name}">${data.data.name}</option>`;
                                        $("#costCenterNameAppendData").append(html2);
                                         $("#costCenter")[0].reset();
                                         $("#costCenterError").attr('hidden',true);
                                       }

                                       if (data.success==400) {
                                        $("#costCenterError").attr('hidden',false);
                                                 //  return false;
                                       }

           },
       });

   })
</script>




<script>
   function removCenters(that,clientId)
     {
        var label="Cost Center";
           swal({
                   title: "Are you sure?",
                   text: "Do you want to Delete!",
                   type: "warning",
                   showCancelButton: true,
                   confirmButtonClass: "btn-danger",
                   confirmButtonText: "Yes, Delete it!",
                   cancelButtonText: "No, Cancel It",
                   closeOnConfirm: false,
                   closeOnCancel: false
               },
               function(isConfirm) {
                   if (isConfirm) {
                       $.ajax({
                           type: "POST",
                           url: "{{route('client.centers')}}",
                           data: {
                               "clientId": clientId,
                               "_token": "{{ csrf_token() }}"
                           },
                           dataType: 'json',
                           success: function(result) {
                                   swal({
                                       type:'success',
                                       title: 'Deleted!',
                                       text: 'Cost Center Deleted',
                                       timer: 1000
                                   });

                                   if(that){
                                       $(that).parent().parent().remove();
                                   }

                           },

                               error: function(data) {
                               console.log("error");
                               console.log(result);
                           }
                       });
                   } else {
                       swal("Cancelled", label+" safe :)", "error");
                   }
               });
       }
   </script>

<script>
    function editRate(getType,hourlyRateChargeableDays,ourlyRateChargeableNight,hourlyRateChargeableSaturday,hourlyRateChargeableSunday,hourlyRatePayableDay,hourlyRatePayableNight,hourlyRatePayableSaturday,hourlyRatePayableSunday)
    {
        $('#editRate').modal('show');
        $('#edittype').val(getType).trigger('change');
        $('#typeiD').val(getType);
        $('#hourlyRateChargeableDays').val(hourlyRateChargeableDays);
        $('#ourlyRateChargeableNight').val(ourlyRateChargeableNight);
        $('#hourlyRateChargeableSaturday').val(hourlyRateChargeableSaturday);
        $('#hourlyRateChargeableSunday').val(hourlyRateChargeableSunday);
        $('#hourlyRatePayableDay').val(hourlyRatePayableDay);
        $('#hourlyRatePayableNight').val(hourlyRatePayableNight);
        $('#hourlyRatePayableSaturday').val(hourlyRatePayableSaturday);
        $('#hourlyRatePayableSunday').val(hourlyRatePayableSunday);
    }

</script>


<script>
    const numericInput1 = document.getElementById('hourlyRateChargeableDays');
    const numericInput2 = document.getElementById('ourlyRateChargeableNight');
    const numericInput3 = document.getElementById('hourlyRateChargeableSaturday');
    const numericInput4 = document.getElementById('hourlyRateChargeableSunday');
    const numericInput5 = document.getElementById('hourlyRatePayableDay');
    const numericInput6 = document.getElementById('hourlyRateChargeable');
    const numericInput7 = document.getElementById('HourlyRatePayableNight');
    const numericInput8 = document.getElementById('HourlyRatePayableSaturday');
    const numericInput9 = document.getElementById('HourlyRatePayableSunday');

    numericInput1.addEventListener('keydown', function(event) {
        const key = event.key;
    // Check if the pressed key is a letter
    if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput2.addEventListener('keydown', function(event) {
        const key = event.key;
    // Check if the pressed key is a letter
    if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });
    numericInput3.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput4.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput5.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput6.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput7.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput8.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });

    numericInput9.addEventListener('keydown', function(event) {
     if (/^[a-zA-Z]$/.test(key)) {
        // Prevent the default behavior for letter keys
                event.preventDefault();
            }
        });
        </script>


@endsection
