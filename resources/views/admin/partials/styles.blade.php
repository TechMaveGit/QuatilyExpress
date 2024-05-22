<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/newimages/imgpsh_fullsize_anim (1).png')}}">

    <meta name="csrf-token" content="{{ csrf_token() }}" />



 <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA85KpTqFdcQZH6x7tnzu6tjQRlqyzAn-s&libraries=places" defer></script>


    <!-- TITLE -->
    <title>Quality Express</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">


    <link id="style" href="{{ asset('/assets/sweet-alert/sweetalert.css')}}" rel="stylesheet">

    <!-- STYLE CSS -->
     <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
  <!-- Froala Editor Stylesheet-->
  <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet' type='text/css'>
	<!-- Plugins CSS -->
    <link href="{{ asset('assets/css/plugins.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/Common/css/CountrySelect.css')}}" rel="stylesheet">

    <!--- FONT-ICONS CSS -->
    <link href="{{ asset('assets/css/icons.css')}}" rel="stylesheet">
    <!-- flat picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
  <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">
    <!-- INTERNAL Switcher css -->
    {{-- <link href="{{ asset('assets/switcher/css/switcher.css')}}" rel="stylesheet"> --}}

    <link href="{{ asset('assets/switcher/demo.css')}}" rel="stylesheet">
    <!--custom css-->

    <link href="{{ asset('assets/css/custom.css?v=1.0')}}" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
   <link href="{{ asset('assets/css/toastr.min.css')}}" rel="stylesheet">
 <!-- CHARTJS JS -->


 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>


 <script src="{{ asset('assets/plugins/chart/Chart.bundle.js')}}"></script>



 <script src="{{ asset('assets/js/chart.js')}}"></script>
 <script src="{{ asset('assets/js/charts.js')}}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 <script>

    var pagrLoaded = false;
    $(document).ready(function(){
        pagrLoaded = true;
        setTimeout(() => {
            pagrLoaded = false;
        }, 1000);
    });
    </script>
@livewireStyles

<style>
    .dataTables_empty{
        display: none;
    }
    .dark-mode .form-check-input {
    background: #41415c;
    border-color: #ecb403;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #515151;
    border-bottom: 1px solid #5d5c5c;
}
.light-mode .select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #f4f4f4;
    border-bottom: 1px solid #e3e1e1;
}
.light-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: var(--primary-bg-color);
    color: #70748c;
}
    </style>

</head>
