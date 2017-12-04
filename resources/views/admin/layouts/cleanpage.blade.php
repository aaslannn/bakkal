<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/js/html5shiv.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/respond.min.js') }}" type="text/javascript"></script>
    <![endif]-->
    <!-- global css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/styles/black.css') }}" rel="stylesheet" type="text/css" id="colorscheme" />
    <link href="{{ asset('assets/css/panel.css') }}" rel="stylesheet" type="text/css"/>
    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
</head>

<body>
    <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Notifications -->
            @include('notifications')

            <!-- Content -->
            @yield('content')
    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- end of global js -->
    <!-- begin page level js -->
    @yield('footer_scripts')
    <!-- end page level js -->
</body>
</html>
