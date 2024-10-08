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
<h1 class="page-title">Shift Add</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item " aria-current="page">Shift</li>
            <li class="breadcrumb-item active" aria-current="page">Shift Add</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->
 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
      <div class="row">
        <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="top_section_title">
                                           <h5>Add Driver Shift</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="wizard1s">
                                            <section>
                                                <form action="{{ route('admin.shift.add') }}" method="post"> @csrf
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="check_box">
                                                                    <label class="form-label" for="exampleInputEmail1">State <span class="red">*</span></label>
                                                                    <div class="form-group">
                                                                    <select class="form-control select2 form-select" onchange="getdata(this)" name="state" id="stateName" data-placeholder="Choose one" required>
                                                                        <option value="">Choose one</option>
                                                                        @foreach ($states as $allstates)
                                                                               <option value="{{ $allstates->id }}">{{ $allstates->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="check_box">
                                                                    <label class="form-label" for="exampleInputEmail1">Client <span class="red">*</span></label>
                                                                    <div class="form-group">
                                                                        <select class="form-control select2 form-select" name="client" id="appendClient" onchange="getCostCenter(this)" data-placeholder="Choose one" required>
                                                                             <option value="">Choose one</option>
                                                                            {{-- @forelse ($client as $allclient)
                                                                            <option value="{{ $allclient->id }}">{{ $allclient->name }}</option>
                                                                            @empty
                                                                            @endforelse --}}
                                                                        </select>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="check_box">
                                                                    <label class="form-label" for="exampleInputEmail1">Cost Centre <span class="red">*</span></label>
                                                                    <div class="form-group">
                                                                    <select class="form-control select2 form-select" name="costCenter" onchange="getCenterBase(this)" id="appendCostCenter"required>
                                                                    </select>
                                                                 </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="check_box">
                                                                    <label class="form-label" for="exampleInputEmail1">Vehicle Type <span class="red">*</span></label>
                                                                    <div class="form-group">
                                                                      <select class="form-control select2 form-select" name="vehicleType"  id="appendVehicleType"  onchange="getDriverResponiable(this)" data-placeholder="Choose one" required>
                                                                        </select>
                                                                 </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="check_box">
                                                                    <label class="form-label" for="exampleInputEmail1">Base <span class="red">*</span></label>
                                                                    <div class="form-group">
                                                                        <select class="form-control select2 form-select" name="base" id="appendBase" data-placeholder="Choose one" required>
                                                                             <option value="">Choose one</option>
                                                                        </select>
                                                                 </div>
                                                               </div>
                                                            </div>
                                                            <script>
                                                                function getCenterBase(select)
                                                                {
                                                                    var clientId = select.value;
                                                                    $.ajaxSetup({
                                                                            headers: {
                                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                                            }
                                                                            });
                                                                 $.ajax({
                                                                            type:'POST',
                                                                            url:"{{ route('admin.getClientBase') }}",
                                                                            data:{costCenterId:clientId},
                                                                            success:function(data){
                                                                                if (data.success==200) {
                                                                                    $('#appendBase').empty();
                                                                                    $('#appendBase').find('option:not(:first)').remove();
                                                                                   $('#appendBase')[0].options.length = 0;
                                                                                        var html4='';
                                                                                            $.each(data.clientBase,function(index,items){
                                                                                                html4 +='<option value="">Choose one</option><option value="'+items.id+'">'+items.base+'</option>';
                                                                                                });
                                                                                                $('#appendBase').append(html4);
                                                                            }
                                                                        }
                                                                        });
                                                               }
                                                               </script>
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
                                                                <label class="form-label" for="exampleInputEmail1">Driver <span class="red">*</span></label>
                                                                <div class="form-group">
                                                                    <select class="form-control select2 form-select" name="driverId" data-placeholder="Choose one" required>
                                                                            <option value="">Select Any One</option>
                                                                                @forelse ($driverAdd as $AdddriverAdd)
                                                                                   <option value="{{ $AdddriverAdd->id }}">{{ $AdddriverAdd->userName??'' }} {{ $AdddriverAdd->surname??'' }} ({{ $AdddriverAdd->email??'' }})</option>
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
                                                            <label class="form-label" for="exampleInputEmail1">REGO <span class="red">*</span></label>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="inputtypeRego1" id="search" oninput="searchDropdown()">
                                                                    <select class="form-control  form-select" name="inputtypeRego2" id="dropdown" style="display:none;" data-placeholder="Choose one" oninput="hideInputType()">
                                                                        <option value="" selected>Select Any One</option>
                                                                        @forelse ($regoAll as $allregoAll)
                                                                        <option value="{{ $allregoAll->rego }}">{{ $allregoAll->rego }}</option>
                                                                        @empty
                                                                        @endforelse
                                                                        <!-- Add more options as needed -->
                                                                    </select>
                                                                <input type="text" id="result"  style="display:none;" readonly>
                                                                <div id="regoMessage"></div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Odometer  <span class="red">*</span></label>
                                                            <input type="text" min="0" class="form-control" name="odometer" id="odr" aria-describedby="emailHelp" oninput="checkRego()" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <script>
                                                            function checkRego() {
                                                        var search=$('#search').val();
                                                        var dropdown=$('#dropdown').val();
                                                        var messageElement = document.getElementById('regoMessage');
                                                        if(search || dropdown )
                                                        {
                                                            messageElement.style.display = 'none';
                                                        }
                                                        else
                                                        {
                                                            messageElement.style.color = 'red';
                                                            messageElement.textContent = 'Please Select Rego';
                                                        }
                                                        }
                                                        </script>
                                                    <script>
                                                         const odr = document.getElementById('odr')
                                                         odr.addEventListener('keydown', function(event) {
                                                                const key = event.key;
                                                                if (/^[a-zA-Z]$/.test(key)) {
                                                                            event.preventDefault();
                                                                        }
                                                                    });
                                                                    </script>
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Scanner ID <span class="red">*</span></label>
                                                            <input type="text" class="form-control" name="scanner_id" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Parcels Taken  <span class="red">*</span></label>
                                                            <input type="number" min="0" class="form-control" name="parcelsToken" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Date Start</label>
                                                            <input type="text" class="form-control" id="#basicDate" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Date Finish </label>
                                                            <input type="text" class="form-control" id="#basicDate1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <div class="bottom_footer_dt">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="action_btns text-end">
                                                                <button type="submit" value="Submit" class="btn btn-primary" fdprocessedid="cxhrte"><i class="bi bi-save"></i>Add Shift</button>
                                                               <!-- <a href="client.php" class="theme_btn btn-primary btn"><i class="uil-list-ul"></i> List</a> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </section>
                                            {{-- <h3>Shift Hr. Management</h3>
                                            <section>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Total Hours Day Shift  </label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Total Hours Night Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Total Hours Weekend Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Payable Day Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Payable Night Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Payable Weekend Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Chargeable Day Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Chargeable Night Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Amount Chargeable Weekend Shift</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Parcel Taken</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Parcel Delivered</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Outstanding Parcels</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Odometer Start</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Odometer Finish</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="exampleInputEmail1">Traveled KM</label>
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                                </div>
                                                            </div>
                                                        </div>
                                            </section>
                                            <h3>Monetize Information</h3>
                                            <section>
                                                <div class="row">
                                                            <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Amount Payable Per Service</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Amount Chargeable Per Service</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Fuel Levy Payable</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable250</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Fuel Levy Chargeable400</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Extra Payable</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Extra Chargeable</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Total Payable</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label class="form-label" for="exampleInputEmail1">Total Chargeable</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                        <div class="col-lg-6">
                                                        <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Comments</label>
                                                        <textarea class="form-control mb-4" placeholder="Textarea" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                        <label class="form-label" for="exampleInputEmail1">Approved Reason</label>
                                                        <textarea class="form-control mb-4" placeholder="Textarea" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                </div>
                                            </section> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
     </div>
</div>
</div>
</div>
<script>
    function getdata(select)
    {
        var stateId = $("#stateName :selected").map((_, e) => e.value).get();
     $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
     $.ajax({
                type:'POST',
                url:"{{ route('admin.getClient') }}",
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
</script>
<script>
    function getCostCenter(select)
    {
        var clientId = $("#appendClient :selected").map((_, e) => e.value).get();
        // var clientId=select.value;
       $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
     $.ajax({
                type:'POST',
                url:"{{ route('admin.getCostCenter') }}",
                data:{clientId:clientId},
                success:function(data){
                    if (data.success==200) {
                        $('#appendCostCenter').find('option:not(:first)').remove();
                        $('#appendCostCenter')[0].options.length = 0;
                        $('#appendVehicleType').find('option:not(:first)').remove();
                        $('#appendVehicleType')[0].options.length = 0;
                        var html2='<option value="">Select Any One</option>';
                        $.each(data.items,function(index,items){
                            html2 +='<option value="'+items.id+'">'+items.name+'</option>';
                            });
                          $('#appendCostCenter').append(html2);
                        var html3='';
                        $.each(data.getType,function(index,items){
                            html3 +='<option value="">Choose one</option><option value="'+items.get_client_type.id+'">'+items.get_client_type.name+'</option>';
                            });
                            $('#appendVehicleType').append(html3);
                    }
                    if (data.success==400) {
                        $('#appendCostCenter').find('option:not(:first)').remove();
                        $('#appendCostCenter')[0].options.length = 0;
                        $('#appendVehicleType').find('option:not(:first)').remove();
                        $('#appendVehicleType')[0].options.length = 0;
                    }
                }
                });
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
                        $('#appendDriverResponiable').find('option:not(:first)').remove();
                        $('#appendDriverResponiable')[0].options.length = 0;
                        var html2='';
                        $.each(data.driverRsps,function(index,driver){
                            html2 +='<option value="">Choose one</option><option value="'+driver.id+'">'+driver.userName+' '+driver.surname+'  ('+driver.email+')</option>';
                            });
                          $('#appendDriverResponiable').append(html2);
                          var html12='';
                          $.each(data.driverRego,function(index,driver){
                            html12 +='<option value="">Choose one</option><option value="'+driver.id+'">'+driver.rego+'</option>';
                            });
                          $('#regoId').append(html12);
                        //
                    }
                    if (data.success==400) {
                        $('#appendDriverResponiable').find('option:not(:first)').remove();
                        $('#appendDriverResponiable')[0].options.length = 0;
                    }
                }
                });
            }
</script>
<script>
function hideInputType() {
    $('#search').hide();
}
function searchDropdown() {
        var searchInput = document.getElementById('search').value.toLowerCase();
        var dropdown = document.getElementById('dropdown');
        // Determine if the dropdown should be visible
        var dropdownVisible = false;
        // Loop through dropdown options
        for (var i = 0; i < dropdown.options.length; i++) {
            var optionValue = dropdown.options[i].value.toLowerCase();
            // Check if the search input matches any dropdown option
            if (optionValue.includes(searchInput)) {
                dropdownVisible = true;
                dropdown.selectedIndex = i;
                break; // No need to continue checking once a match is found
            }
        }
        // Toggle the display property based on visibility
        dropdown.style.display = dropdownVisible ? 'block' : 'none';
        var messageElement = document.getElementById('regoMessage');
        messageElement.style.display = 'none';
        // If no match found, hide the input field as well
        // if (!dropdownVisible) {
        //     $('#search').hide();
        // } else {
        //     $('#search').show();
        // }
        // If no match found, reset the dropdown
        if (!dropdownVisible) {
            dropdown.selectedIndex = -1;
        }
    }
    </script>
</script>
@endsection
