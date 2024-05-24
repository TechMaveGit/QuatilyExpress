@extends('admin.layout')
@section('content')


<div class="main-content app-content mt-0">
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Set Route Map</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Shift</li>
                <li class="breadcrumb-item active" aria-current="page">Set Route Map</li>

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
                                <h5>Add Routes</h5>
                            </div>
                        </div>


                 <form action="{{ route('admin.shift.route.map',['id'=>$id]) }}" method="post">@csrf
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-lg-4">
                                    <div class="wrapper__">
                                        <div class="search-input">
                                            <a href="" target="_blank" hidden></a>
                                            <input type="text" placeholder="Type to search..">
                                            <div class="autocom-box">
                                                <!-- here list are inserted from javascript -->
                                            </div>
                                            <!-- <div class="icon"><i class="fas fa-search"></i></div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="search_btn_">
                                        <a href="#" class="btn btn-primary srch_btn">+ Add Route</a>

                                    </div>
                                </div>

                                <div class="col-lg-12 mt-5">
                                    <div class="location_list">




                                    <ul class="sort_menu">
                                        @foreach ($parcels as $row)
                                        <li class="draggable" draggable="true" data-id="{{$row->id}}">
                                            <span class="handle"></span> {{$row->location}}</li>
                                        @endforeach
                                    </ul>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="bottom_footer_dt">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="action_btns text-end">
                                        <button type="submit" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fe fe-map"></i> Route Optimization</button>
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
</div>


<script>
    // $(document).ready(function(){

    // 	function updateToDatabase(idString){
    // 	   $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

    // 	   $.ajax({
    //           url:'{{url('/menu/update-order')}}',
    //           method:'POST',
    //           data:{ids:idString},
    //           success:function(){
    //              alert('Successfully updated')
    //           }
    //        })
    // 	}

    //     var target = $('.sort_menu');
    //     target.sortable({
    //         handle: '.handle',
    //         placeholder: 'highlight',
    //         axis: "y",
    //         update: function (e, ui){
    //            var sortData = target.sortable('toArray',{ attribute: 'data-id'})
    //            updateToDatabase(sortData.join(','))
    //         }
    //     })

    // })
</script>




@endsection
