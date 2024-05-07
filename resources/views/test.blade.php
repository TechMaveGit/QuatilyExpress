<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-12">
            <input class="form-control" id="custom_filter_1">
            <input class="form-control" id="custom_filter_2">
            <table id="basic-datatable" class="table table-bordered   nowrap w-100">
                <thead>
                       <th>Id</th>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Created At</th>
                       <th>Options</th>
                </thead>
                <tbody>

                </tbody>
           </table>
    </div>
        </div>
    </div>
</body>
<script>


$(document).ready(function () {

    

    // $(document).ready(function() {
    //     $('#basic-datatable').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "ajax": {
    //             "url": "{{ route('admin.shift.ajaxIndex') }}",
    //             "type": "GET",
    //             "data": function (d) {
    //                 // Pass any additional parameters needed for server-side processing
    //                 // For example, you can pass search query, page number, etc.
    //                 d.page = d.start / d.length + 1; // Calculate current page number
    //                 // Add more parameters as needed
    //             }
    //         },
    //         "columns": [
    //             { "data": "base" },
    //             { "data": "vehicleType" },
    //             { "data": "get_state_name.name" },
    //             { "data": "chageAmount" }
    //             // Add more column definitions as needed
    //         ]
    //     });
    // });


// Initialize DataTables with server-side processing
// var dataTable = $('#basic-datatable').DataTable({
//     "processing": true,
//     "serverSide": true,
//     "ajax": {
//         "url": "{{ route('admin.shift.ajaxIndex') }}",
//         "type": "POST",
//         "data": function (d) {
//             d._token = '{{ csrf_token() }}'; // Add CSRF token
//         }
//     },
//     "columns": [
//         { "data": "base" },
//         { "data": "vehicleType" },
//         { "data": "getStateName_name" },
//         { "data": "chageAmount" },
//         // Add more column definitions as needed
//     ]
// });

// // Bind event listeners to input fields for automatic filtering
// $('#custom_filter_1, #custom_filter_2').on('keyup change', function () {
//     var filter1Value = $('#custom_filter_1').val();
//     var filter2Value = $('#custom_filter_2').val();
//     console.log('Filter 1:', filter1Value);
//     console.log('Filter 2:', filter2Value);

//     // Trigger DataTables Ajax request with updated filter values
//     dataTable.ajax.reload();
// });


});
</script>
</html>