$(function(e) {
    'use strict';

    // DATATABLE 1
    $('#datatable1').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        }
    });

    // DATATABLE 2
    $('#datatable2').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true
    });
     // DATATABLE 3
    $('#datatable3').DataTable({});
     // DATATABLE 4
     $('#datatable4').DataTable({});
    // SELECT2
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity
    });
});