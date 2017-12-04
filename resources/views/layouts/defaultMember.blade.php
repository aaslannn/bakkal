<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
    	@section('title')
        - {{ $siteSettings->meta_baslik }}
        @show
    </title>
    <meta name="description" content="{{ $siteSettings->meta_aciklama }}">
    <meta name="keywords" content="{{ $siteSettings->meta_keywords }}">
    <!--global css starts-->
    <link href="{{ Theme::url('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/roboto.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/main.css') }}" rel="stylesheet">

    <!--end of global css-->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
</head>

<body class="LoginBody">
    <!-- Header Start -->
    <header class="SignInSiteHeader">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4"><a href="{{{ route('home') }}}" class="Logo">{!! \App\Library\Common::getLogo() !!}</a></div>
                <div class="col-md-8">
                    <nav class="SignInMenu pull-right">
                        <?php $segment = \Illuminate\Support\Facades\Request::segment(1); ?>
                        @if(\Illuminate\Support\Facades\Request::segment(1) == 'giris' || \Illuminate\Support\Facades\Request::segment(2) == 'kayit')
                           <a href="{{{ url('/giris') }}}" class="SignUp">{!!Lang::get('frontend/general.existmember')!!}</a>
                        @else
                           <a href="{{{ url('/kayit') }}}" class="SignUp">{!!Lang::get('frontend/general.notamemberyet')!!}</a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Content -->
    @yield('content')

    <!-- Footer Section Start -->
    <footer class="LoginSiteFooter">
        <div class="container text-center">
            <nav>
                <a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}}</a>
                <a href="{{{ url('/hakkimizda') }}}">{{Lang::get('frontend/general.about-us')}}</a>
                <a href="{{{ url('/iletisim') }}}">{{Lang::get('frontend/general.contact')}}</a>
                <a href="{{{ url('/yardim') }}}">{{Lang::get('frontend/general.help')}}</a>
            </nav>
            <p class="Copyright">Copyright 2015.</p>
        </div>
    </footer>
    <!-- //Footer Section End -->


    <!--global js starts-->
    <script src="{{ asset('assets/js/frontend/jQuery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/config.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/checkpagehelper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/hs.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/remainder.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/raitinghelper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/script.js') }}" type="text/javascript"></script>
    <!--global js end-->
    <!-- begin page level js -->
    @yield('footer_scripts')
    <!-- end page level js -->

    <!--site ajaxloader start-->
    <div class="AjaxLoader hide">
        <div class="LoaderBox">
            <div class="fa fa-spinner fa-spin"></div><span>Suspendisse ac imperdiet nunc.</span>
            <div class="LoaderFooter text-right"><a class="ColorRed">{{Lang::get('frontend/general.cancel')}}</a><a>{{Lang::get('frontend/general.ok')}}</a></div>
        </div>
    </div>
    <!--site ajaxloader end-->
</body>

</html>
