<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>My Store @yield('title')</title>

    <!-- vendor css -->
    <link href="{{ asset('/backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">

    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{asset("/backend/css/starlight.css")}}">
</head>

<body>

<!-- ########## START: LEFT PANEL ########## -->
@include('backend.layout.sidebar')
<!-- ########## END: LEFT PANEL ########## -->

<!-- ########## START: HEAD PANEL ########## -->
@include('backend.layout.header')
<!-- ########## END: HEAD PANEL ########## -->

<!-- ########## START: RIGHT PANEL ########## -->
@include('backend.layout.sideRight')
<!-- ########## END: RIGHT PANEL ########## --->

<!-- ########## START: MAIN PANEL ########## -->
@yield('content')
<!-- ########## END: MAIN PANEL ########## -->


<!-- jQuery -->
<script src="{{asset('/backend/lib/jquery/jquery.js')}}"></script>

<!-- Popper.js -->
<script src="{{asset('/backend/lib/popper.js/popper.js')}}"></script>

<!-- Bootstrap -->
<script src="{{asset('/backend/lib/bootstrap/bootstrap.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('/backend/lib/select2/js/select2.min.js')}}"></script>

<!-- jQuery UI -->
<script src="{{asset('/backend/lib/jquery-ui/jquery-ui.js')}}"></script>

<!-- Perfect Scrollbar -->
<script src="{{asset('/backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>

<!-- Sparkline -->
<script src="{{asset('/backend/lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>

<!-- d3 and Rickshaw -->
<script src="{{asset('/backend/lib/d3/d3.js')}}"></script>
<script src="{{asset('/backend/lib/rickshaw/rickshaw.min.js')}}"></script>

<!-- Chart.js -->
<script src="{{asset('/backend/lib/chart.js/Chart.js')}}"></script>

<!-- Flot Charts -->
<script src="{{asset('/backend/lib/Flot/jquery.flot.js')}}"></script>
<script src="{{asset('/backend/lib/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{asset('/backend/lib/Flot/jquery.flot.resize.js')}}"></script>
<script src="{{asset('/backend/lib/flot-spline/jquery.flot.spline.js')}}"></script>

<!-- Starlight Core JS -->
<script src="{{asset('/backend/js/starlight.js')}}"></script>
<script src="{{asset('/backend/js/ResizeSensor.js')}}"></script>
<script src="{{asset('/backend/js/dashboard.js')}}"></script>

<!-- SweetAlert (خليه لو فعلاً محتاجه) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('js')

</body>
</html>
