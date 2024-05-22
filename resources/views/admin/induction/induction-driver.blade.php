@extends('admin.layout')
@section('content')

<?php
   $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
   $arr = [];
   foreach($D as $v)
   {
     $arr[] = $v['permission_id'];
   }
   ?>


<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Driver</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')  }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Induction</li>
            <li class="breadcrumb-item active" aria-current="page">Driver</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
    <div class="row">
        <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card_h">
                                <div class="top_section_title">
                                    <h5>Filter</h5>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                              <form action="{{ route('driver') }}" method="post"/> @csrf
                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label" for="exampleInputEmail1">Status</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="driverInspections" data-placeholder="Choose one" style="adding-top: 8px ">
                                                   <option value="">Select Any One </option>
                                                   <option value="0" {{ $driverInspections == '0' ? 'selected="selected"' : '' }}>To Do </option>
                                                   <option value="1" {{ $driverInspections == '1' ? 'selected="selected"' : '' }}>Done</option>
                                               </select>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                 <div class="search_btn">
                                 <button type="submit" class="btn btn-primary srch_btn">Search</button>
                                 <a href="{{ route('driver') }}" class="btn btn-primary srch_btn">Reset</a>
                                 </div>
                                </div>

                            </form>




                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header">
                    <div class="top_section_title">
                       <h5>All Drivers Document</h5>
                       <!-- <a href="induction-add.php" class="btn btn-primary">+ Add New Induction</a> -->
                    </div>

                </div>
                        <div class="card-body">
                        <div class="table-responsive">
                        <table id="custom_table"  class="table table-bordered text-nowrap mb-0">

                            <thead class="border-top">
                                <tr>

                                    <th class="bg-transparent border-bottom-0">S.No</th>
                                    <th class="bg-transparent border-bottom-0">Driver</th>
                                    <th class="bg-transparent border-bottom-0">Email</th>

                                    {{-- <th class="bg-transparent border-bottom-0">Induction</th> --}}
                                    <th>Status</th>
                                    <th class="bg-transparent border-bottom-0" style="width: 5%;">Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($driver as $alldriver)
                                    <tr class="border-bottom">
                                        <td class="td sorting_1">{{ $loop->iteration  }}</td>
                                        <td class="td sorting_1">{{ $alldriver->userName }} {{ $alldriver->surname }}</td>
                                        <td class="td">{{ $alldriver->email	 }}</td>
                                        {{-- <td class="td">{{ $alldriver->userName }}</td> --}}
                                        <td>
                                            @if($alldriver->driverInspections=='0')
                                            <span class="btn btn-primary-light status_">To Do</span>
                                            @else
                                            <span class="btn btn-primary-light status_">Do</span>
                                            @endif

                                        </td>

                                        @if(in_array("45", $arr))
                                        <td>
                                            <div class="g-2">
                                            <a class="btn text-info btn-sm" href="{{ route('driver.induction', ['id'=>$alldriver->id]) }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="View"><span
                                                        class="fe fe-eye fs-14"></span></a>

                                            </div>
                                        </td>
                                        @endif
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
@endsection
