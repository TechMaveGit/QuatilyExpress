@extends('admin.layout')
@section('content')

<!--app-content open-->
 <div class="main-content app-content mt-0">
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">Administration</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Administration</li>
            <li class="breadcrumb-item active" aria-current="page">Assign Role</li>

        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->

 <div class="side-app">
    <!-- CONTAINER -->
    <div class="main-container container-fluid">
        <div class="row">
        <div class="col-lg-12">


            <form action="{{route('administration.userAccessAssign')}}" method="post"> @csrf
                    <div class="card">
                        <div class="card-header card_h">
                                <div class="top_section_title">
                                    <h5>Assign Role</h5>
                                </div>
                            </div>
                        <div class="card-body">

                            <div class="row">

                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">User name</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" onchange="getUserDetail(this)"    name="first_name" data-placeholder="Choose one">
                                            <option value="">Select Any One</option>

                                            @foreach ($person as $allperson)
                                            <option value="{{$allperson->userName}}">{{$allperson->userName}}</option>
                                            @endforeach

                                               </select>
                                       </div>
                                    </div>
                                </div>





                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Last name</label>
                                        <div class="form-group">
                                             <select class="form-control select2 form-select"  id="appendUserName" name="last_name" data-placeholder="Choose one" autocomplete="off"/>

                                               </select>
                                       </div>
                                    </div>
                                </div>






                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Email</label>
                                        <div class="form-group">
                                               <select class="form-control select2 form-select"  id="appendUserDetail" name="email" data-placeholder="Choose one">

                                               </select>
                                       </div>
                                      
                                       @if($errors->has('email'))
    <div class="error" style="color: red;">{{ $errors->first('email') }}</div>
@endif
                                       
                                    
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Password</label>
                                        <div class="form-group">

                                         <input type="password" class="form-control" name="password"/>
                                       </div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Select Role</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="roles" data-placeholder="Choose one">
                                            @foreach ($roles as $allrole)
                                            <option value="{{$allrole->id}}">{{$allrole->name}}</option>
                                            @endforeach

                                               </select>
                                       </div>
                                    </div>
                                </div>



                                <div class="col-lg-4">
                                    <div class="check_box">
                                        <label class="form-label">Status</label>
                                        <div class="form-group">
                                           <select class="form-control select2 form-select" name="status" data-placeholder="Choose one" required>
                                                   <option value="">Select Status</option>
                                                   <option value="1"  {{ old('status') == 1 ? 'selected="selected"' : '' }}>Active</option>
                                                   <option value="2"  {{ old('status') == 2 ? 'selected="selected"' : '' }}>Inactive</option>

                                               </select>
                                       </div>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="bottom_footer_dt">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="action_btns text-end">
                                        <button type="submit" class="theme_btn btn btn-primary"><i class="ti-save"></i> Save </button>
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



<script>
    function getUserDetail(select)
    {
        var clientId=select.value;
       $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
     $.ajax({
                type:'POST',
                url:"{{ route('admin.getUserDetail') }}",
                data:{clientId:clientId},
                success:function(data){

                    $('#appendUserDetail').empty();
                    $('#appendUserName').empty();

                    if (data.success==200) {
                             var html2='';
                                $.each(data.userName,function(index,items){
                                    html2 +='<option value="'+items.email+'">'+items.email+'</option>';
                                    });
                                $('#appendUserDetail').append(html2);

                                var html2='';
                                $.each(data.userName,function(index,items){
                                    html2 +='<option value="'+items.surname+'">'+items.surname+'</option>';
                                    });
                                $('#appendUserName').append(html2);
                    }
                }
                });
            }
</script>

@endsection

