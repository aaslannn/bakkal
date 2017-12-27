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
    <link rel="shortcut icon" type="img/png" href="{{{ url('/').'/uploads/'.$siteSettings->favicon }}}">
    {!! $siteSettings->google_meta !!}
    <!--global css starts-->
    <link href="{{ Theme::url('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/roboto.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/main.css') }}" rel="stylesheet">
    <link href="{{ Theme::url('css/custom.css') }}" rel="stylesheet">

    <!--end of global css-->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
</head>

<body>
    <!-- Header Start -->
    <header class="SiteHeader">
        <div class="container">
            <div class="TopBar">
                <nav>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{{ route('home') }}}" class="Logo">{!! \App\Library\Common::getLogo() !!}</a>
                        </div>
                        <div class="col-md-9">
                            <div class="HeaderMenu text-right mb-15">
                                <a href="{{{ route('home') }}}">{{Lang::get('frontend/general.home')}}</a>
                                <a href="{{{ url('/about-us') }}}">{{Lang::get('frontend/general.about-us')}}</a>
                                <a href="{{{ url('/contact') }}}">{{Lang::get('frontend/general.contact')}}</a>
                                <a href="{{{ url('/help') }}}">{{Lang::get('frontend/general.help')}}</a>

                                @if($siteSettings->catalog != '')
                                    <a href="{{{ url('/').'/uploads/'.$siteSettings->catalog }}}" target="_blank"><i class="fa fa-file-pdf-o mr-5"></i><span>{{ Lang::get('frontend/general.catalog') }}</span></a>
                                @endif

                                <?php $langs = \App\Language::whereDurum(1)->get(); ?>
                                @if ($langs->count() > 1)
                                <div class="btn-group"><a data-toggle="dropdown" class="dropdown-toggle">
                                    {{ \App\Library\Common::getLocaleLangName(LaravelLocalization::getCurrentLocale()) }}<i class="fa fa-chevron-down ml-5"></i></a>
                                    <ul class="dropdown-menu pull-right">
                                        @foreach($langs as $lang)
                                            <li>
                                                <a rel="alternate" hreflang="{{$lang->kisaltma}}" href="{{LaravelLocalization::getLocalizedURL($lang->kisaltma) }}">
                                                    {{{ $lang->dil }}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div class="BottomBar">
                                <div class="row">
                                    <div class="col-md-7">
                                        <form name="quickSearch" method="GET" action="{{{ url('/results') }}}">
                                            <div class="Search">
                                                <div>
                                                    <input type="text" name="q" placeholder="{{Lang::get('frontend/general.searching-product')}}" class="form-control">
                                                    <select class="form-control" name="catId">
                                                        <option value="">{{Lang::get('frontend/general.choose-category')}}</option>
                                                        @foreach(\App\Library\Common::getCategoriesbyParent(0) as $cats)
                                                            <option value="{{ $cats->id }}">{{ $cats->{'title_'.$defLocale} }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn BackgroundOrange">{{Lang::get('frontend/general.search')}}</button>

                                                </div><i class="fa fa-search"></i>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-3">
                                        @if(Auth::customer()->check())
                                            <?php $cust = Auth::customer()->get(); ?>

                                            <div class="PrivateUser">
                                                <div class="btn-group block"><a data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-user"></i>
                                                        <div><span>{{  $cust->first_name }} {{ $cust->last_name }}</span></div><i class="fa fa-chevron-down"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{{ url('/uye/profil') }}}">{{Lang::get('frontend/general.member-info')}}</a></li>
                                                        <li><a href="{{{ url('/sepet') }}}">{{Lang::get('frontend/general.my-cart')}}</a></li>
                                                        <li><a href="{{{ url('/uye/siparisler') }}}">{{Lang::get('frontend/general.my-orders')}}</a></li>
                                                        <li><a href="{{{ url('/uye/favoriler') }}}">{{Lang::get('frontend/general.favorite-products')}}</a></li>
                                                        <li><a href="{{{ url('/uye/adresler') }}}">{{Lang::get('frontend/general.address-book')}}</a></li>
                                                        <li><a class="Exit" href="{{{ url('/cikis') }}}">{{Lang::get('frontend/general.logout')}}</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="PublicUser">
                                                <div class="btn-group"><a class="btn" href="{{{ url('/giris') }}}">{{Lang::get('frontend/general.sign-in')}}</a><a class="btn" href="{{{ url('/kayit') }}}">{{Lang::get('frontend/general.sign-up')}}</a></div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <a class="BtnSuccess MyCart block" href="{{{ url('/sepet') }}}">
                                            <i class="fa fa-shopping-cart"></i><div class="badge">{{ Cart::count() }}</div><span>{{Lang::get('frontend/general.my-cart')}}</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

        </div>
    </header>
    <nav class="MainMenu">
        <div class="container">
            <div class="row">
                <?php $catCount = \App\Library\Common::getAltCatCount(0) ?>
                @if($catCount > 5)
                    <div class="col-md-3">
                        <div class="btn-group CategoryList">
                            <div class="CategoryMenuCover"></div><a data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-bars"></i><span>{{Lang::get('frontend/general.all-cats')}}</span><i class="fa fa-chevron-down"></i></a>
                            <ul class="dropdown-menu">
                                @foreach(\App\Library\Common::getCategoriesbyParent(0) as $cats)
                                        @if(\App\Library\Common::getAltCatCount($cats->id) > 0)
                                        <li><a>{{ $cats->{'title_'.$defLocale} }} <i class="fa fa-chevron-right pull-right"></i></a>
                                        <div class="CategoryListSubMenu">
                                            <div>
                                                <div class="row">
                                                    @foreach(\App\Library\Common::getCategoriesbyParent($cats->id) as $cats2)
                                                        <div class="col-md-4">
                                                            <div class="CategoryGroup"><a class="CategoryTitle" href="/urunler/{{ $cats2->sefurl }}"> {{ $cats2->{'title_'.$defLocale} }}</a>
                                                                <div>
                                                                @foreach(\App\Library\Common::getCategoriesbyParent($cats2->id) as $cats3)
                                                                    <a href="/urunler/{{ $cats3->sefurl }}">{{ $cats3->{'title_'.$defLocale} }}</a>,
                                                                @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                        </li>
                                        @else
                                        <li><a href="/urunler/{{ $cats->sefurl }}">{{ $cats->{'title_'.$defLocale} }} <i class="fa fa-chevron-right pull-right"></i></a></li>
                                        @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9 ProductMenu">
                        <nav>
                            <div class="btn-group">
                                @foreach(\App\Library\Common::getCategoriesbyParent(0,5) as $cats)
                                    @if(\App\Library\Common::getAltCatCount($cats->id) > 0)
                                        <div class="btn-group">
                                            <a class="dropdown"><span>{{ $cats->{'title_'.$defLocale} }}</span><i class="fa fa-chevron-down ml-10"></i></a>
                                            <div>
                                                <div class="row">
                                                    @foreach(\App\Library\Common::getCategoriesbyParent($cats->id) as $cats2)
                                                        <div class="col-md-4">
                                                            <div class="CategoryGroup"><a class="CategoryTitle" href="/urunler/{{ $cats2->sefurl }}"> {{ $cats2->{'title_'.$defLocale} }}</a>
                                                                <div>
                                                                    @foreach(\App\Library\Common::getCategoriesbyParent($cats2->id) as $cats3)
                                                                        <a href="/urunler/{{ $cats3->sefurl }}">{{ $cats3->{'title_'.$defLocale} }}</a> ,
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="btn-group"><a href="/urunler/{{ $cats->sefurl }}">{{ $cats->{'title_'.$defLocale} }}</a></div>
                                    @endif
                                @endforeach
                            </div>
                        </nav>
                    </div>
                @else
                        <div class="col-md-12 ProductMenu">
                            <nav>
                                <div class="btn-group">
                                    @foreach(\App\Library\Common::getCategoriesbyParent(0,5) as $cats)
                                        @if(\App\Library\Common::getAltCatCount($cats->id) > 0)
                                            <div class="btn-group">
                                                <a class="dropdown"><span>{{ $cats->{'title_'.$defLocale} }}</span><i class="fa fa-chevron-down ml-10"></i></a>
                                                <div>
                                                    <div class="row">
                                                        @foreach(\App\Library\Common::getCategoriesbyParent($cats->id) as $cats2)
                                                            <div class="col-md-4">
                                                                <div class="CategoryGroup"><a class="CategoryTitle" href="/urunler/{{ $cats2->sefurl }}"> {{ $cats2->{'title_'.$defLocale} }}</a>
                                                                    <div>
                                                                        @foreach(\App\Library\Common::getCategoriesbyParent($cats2->id) as $cats3)
                                                                            <a href="/urunler/{{ $cats3->sefurl }}">{{ $cats3->{'title_'.$defLocale} }}</a> ,
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="btn-group"><a href="/urunler/{{ $cats->sefurl }}">{{ $cats->{'title_'.$defLocale} }}</a></div>
                                        @endif
                                    @endforeach
                                </div>
                            </nav>
                        </div>
                @endif
            </div>
        </div>
    </nav>
    <!-- //Header End -->

    <!-- slider / breadcrumbs section -->
    @yield('top')

    <!-- Content -->
    @yield('content')

    <!-- Footer Section Start -->
    <footer class="Site-Footer">
        <div class="container">
            <div class="QuickLiks">
                <a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}} </a>
                <?php $contents = \App\Content::whereStatus(1)->where('parent_id',0)->orderBy('sequence','asc')->get(); ?>
                @foreach($contents as $content)
                    <a href="{{{ url('/'.$content->sefurl) }}}">{{ $content->{'title_'.$defLocale} }}</a>
                @endforeach
            </div>
            <address><b>{{ $siteSettings->isim }} :</b> @if($siteSettings->adres != '') <span>{{ $siteSettings->adres }} - </span>@endif<b>Tel: </b><span>{{ $siteSettings->tel }} - </span><b>E-Posta: </b><span>{{ $siteSettings->email }}</span></address>
        </div>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <p class="Copyright">{!!Lang::get('frontend/general.copyright', array('host'=>'bakkal.qa'))!!} &copy; 2017 - {{ date('Y') }}</p>
                    </div>
                    <div class="col-md-3">
                        <div class="SocialMedia">
                            <div class="SocialMediaLinks">
                                <?php $socials = \App\Social::whereStatus(1)->orderBy('sequence','asc')->get(); ?>
                                @foreach($socials as $scl)
                                    <a class="{{ $scl->title }}" href="{{ $scl->link }}" rel="external"  title="{{ $scl->title }}"><i class="fa fa-{{ $scl->icon }}"></i></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </footer>
    <!-- //Footer Section End -->


    <!--global js starts-->
    <script src="{{ asset('assets/js/frontend/jQuery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/config.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/checkpagehelper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/hs.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/categorymenuevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/remainder.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/raitinghelper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/plugins/inputmask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/plugins/imagesloaded.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/script.js') }}" type="text/javascript"></script>
    {!! $siteSettings->google_analytics !!}
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
