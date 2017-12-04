<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
        | {!! \App\Setting::find(1)->meta_baslik !!} Yönetim Paneli
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="{!! \App\Setting::find(1)->meta_baslik !!} Yönetim Paneli">
    <meta name="author" content="dalyabilisim">
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('assets/js/html5shiv.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/respond.min.js') }}" type="text/javascript"></script>
    <![endif]-->
    <!-- global css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/styles/black.css') }}" rel="stylesheet" type="text/css" id="colorscheme" />
    <link href="{{ asset('assets/css/panel.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/metisMenu.css') }}" rel="stylesheet" type="text/css"/>

    <!-- end of global css -->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
</head>

<body class="skin-josh">
    <header class="header">
        <a href="{{ route('dashboard') }}" class="logo">
            {!! \App\Library\Common::getLogo() !!}
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <div class="responsive_nav"></div>
                </a>
            </div>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if(Sentry::getUser()->pic)
                                <img src="{!! url('/').'/uploads/users/'.Sentry::getUser()->pic !!}" alt="img" class="img-circle img-responsive pull-left" height="35px" width="35px"/>
                            @else
                                <img src="{!! asset('assets/img/authors/avatar3.jpg') !!} " width="35" class="img-circle img-responsive pull-left" height="35" alt="riot">
                            @endif
                            <div class="riot">
                                <div>
                                    {{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}
                                    <span>
                                        <i class="caret"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                @if(Sentry::getUser()->pic)
                                    <img src="{!! url('/').'/uploads/users/'.Sentry::getUser()->pic !!}" alt="img" class="img-circle img-bor"/>
                                @else
                                    <img src="{!! asset('assets/img/authors/avatar3.jpg') !!}" class="img-responsive img-circle" alt="User Image">
                                @endif
                                <p class="topprofiletext">{{ Sentry::getUser()->first_name }} {{ Sentry::getUser()->last_name }}</p>
                            </li>
                            <!-- Menu Body -->
                            <li>
                                <a href="{{ URL::route('users.show',Sentry::getUser()->id) }}">
                                    <i class="livicon" data-name="user" data-s="18"></i>
                                    Profil
                                </a>
                            </li>
                            <li role="presentation"></li>
                            <li>
                                <a href="{{ route('users.update', Sentry::getUser()->id) }}">
                                    <i class="livicon" data-name="gears" data-s="18"></i>
                                    Düzenle
                                </a>
                            </li>
                            <li>
                                <a href="{{ URL::to('admin/logout') }}">
                                    <i class="livicon" data-name="sign-out" data-s="18"></i>
                                    Çıkış
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
            <section class="sidebar ">
                <div class="page-sidebar  sidebar-nav">
                    <!-- BEGIN SIDEBAR MENU -->
                    <ul id="menu" class="page-sidebar-menu">
                        <li {!! (Request::is('admin') ? 'class="active"' : '') !!}>
                            <a href="{{ route('dashboard') }}">
                                <i class="livicon" data-name="home" data-size="18" data-color="#42aaca" data-hc="#42aaca" data-loop="true"></i>
                                <span class="title">{{ trans('panel.home') }}</span>
                            </a>

                        </li>
                        <li {!! (Request::is('admin/settings') || Request::is('admin/settings/*') || Request::is('admin/languages') || Request::is('admin/languages/*') || Request::is('admin/translations') || Request::is('admin/translations/*') || Request::is('admin/cargos') || Request::is('admin/cargos/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="hammer" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('settings/title.settings') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('settings'))
                                <li {!! (Request::is('admin/settings') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/settings') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('settings/title.edit') }}
                                    </a>
                                </li>
                                @endif
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('languages'))
                                    <li {!! (Request::is('admin/languages') ? 'class="active" id="active"' : '') !!}>
                                        <a href="{{ URL::to('admin/languages') }}">
                                            <i class="fa fa-angle-double-right"></i>
                                            {{ trans('languages/title.management') }}
                                        </a>
                                    </li>
                                @endif
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('translations'))
                                    <li {!! (Request::is('admin/translations') ? 'class="active" id="active"' : '') !!}>
                                        <a href="{{ URL::to('admin/translations') }}">
                                            <i class="fa fa-angle-double-right"></i>
                                            {{ trans('translations/title.management') }}
                                        </a>
                                    </li>
                                @endif
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('cargos'))
                                <li {!! (Request::is('admin/cargos') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/cargos') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('cargos/title.management') }}
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        <li {!! (Request::is('admin/paymethods') || Request::is('admin/paymethods/*') || Request::is('admin/bankaccounts') || Request::is('admin/bankaccounts/*') || Request::is('admin/posaccounts') || Request::is('admin/posaccounts/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="money" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('settings/title.pay-settings') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('paymethods'))
                                <li {!! (Request::is('admin/paymethods') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/paymethods') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('paymethods/title.paymethods') }}
                                    </a>
                                </li>
                                @endif
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('posaccounts'))
                                <li {!! (Request::is('admin/posaccounts') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/posaccounts') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('posaccounts/title.posaccounts') }}
                                    </a>
                                </li>
                                @endif
                                    @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('bankaccounts'))
                                        <li {!! (Request::is('admin/bankaccounts') ? 'class="active" id="active"' : '') !!}>
                                            <a href="{{ URL::to('admin/bankaccounts') }}">
                                                <i class="fa fa-angle-double-right"></i>
                                                {{ trans('bankaccounts/title.bankaccounts') }}
                                            </a>
                                        </li>
                                    @endif
                            </ul>
                        </li>
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('customers'))
                            <li {!! (Request::is('admin/customers') || Request::is('admin/customers/*') || Request::is('admin/deleted_customers') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/customers') }}">
                                    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="users" data-size="18" data-loop="true"></i>
                                    {{ trans('customers/title.management') }}
                                </a>
                            </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('categories'))
                        <li {!! (Request::is('admin/categories') || Request::is('admin/categories/create') || Request::is('admin/categories/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="sitemap" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('categories/title.management') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li {!! (Request::is('admin/categories') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/categories') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('categories/title.categories') }}
                                    </a>
                                </li>
                                <li {!! (Request::is('admin/categories/create') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/categories/create') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('categories/title.create') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('products'))
                        <li {!! (Request::is('admin/products') || Request::is('admin/products/create') || Request::is('admin/products/*') || Request::is('admin/brands') || Request::is('admin/brands/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="tags" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('products/title.management') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li {!! (Request::is('admin/products') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/products') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('products/title.products') }}
                                    </a>
                                </li>
                                <li {!! (Request::is('admin/products/create') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/products/create') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('products/title.create') }}
                                    </a>
                                </li>
                                @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('brands'))
                                <li {!! (Request::is('admin/brands') || Request::is('admin/brands/*') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/brands') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('brands/title.management') }}
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('reviews'))
                        <li {!! (Request::is('admin/reviews') || Request::is('admin/reviews/create') || Request::is('admin/reviews/*') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('admin/reviews') }}">
                                <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="comments" data-size="18" data-loop="true"></i>
                                {{ trans('reviews/title.reviews') }}
                            </a>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('orders'))
                        <li {!! (Request::is('admin/orders') || Request::is('admin/orders/create') || Request::is('admin/orders/*') ? 'class="active"' : '') !!}>
                            <a href="{{ URL::to('admin/orders') }}">
                                <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="shopping-cart-in" data-size="18" data-loop="true"></i>
                                {{ trans('orders/title.orders') }}
                                <?php $sipCount = \App\Order::whereStatus(1)->get()->count(); ?>
                                @if ($sipCount > 0)
                                <span class="badge badge-danger">{{ $sipCount }} Yeni</span>
                                @endif
                            </a>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('discodes'))
                            <li {!! (Request::is('admin/discodes') || Request::is('admin/discodes/create') || Request::is('admin/discodes/*') ? 'class="active"' : '') !!}>
                                <a href="#">
                                    <i class="livicon" data-name="piggybank" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                    <span class="title">{{ trans('discodes/title.management') }}</span>
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li {!! (Request::is('admin/discodes') ? 'class="active" id="active"' : '') !!}>
                                        <a href="{{ URL::to('admin/discodes') }}">
                                            <i class="fa fa-angle-double-right"></i>
                                            {{ trans('discodes/title.discodes') }}
                                        </a>
                                    </li>
                                    <li {!! (Request::is('admin/discodes/create') ? 'class="active" id="active"' : '') !!}>
                                        <a href="{{ URL::to('admin/discodes/create') }}">
                                            <i class="fa fa-angle-double-right"></i>
                                            {{ trans('discodes/title.create') }}
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('users'))
                        <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="user" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('users/title.management') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/users') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('users/title.users') }}
                                    </a>
                                </li>
                                <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/users/create') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('users/title.create') }}
                                    </a>
                                </li>
                                <li {!! ((Request::is('admin/users/*')) && !(Request::is('admin/users/create')) ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::route('users.show',Sentry::getUser()->id) }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('users/title.user_profile') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('groups'))
                            <li {!! (Request::is('admin/groups') || Request::is('admin/groups/*') ? 'class="active"' : '') !!}>
                                <a href="{{ URL::to('admin/groups') }}">
                                    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="users" data-size="18" data-loop="true"></i>
                                    {{ trans('groups/title.management') }}
                                </a>
                            </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('contents'))
                        <li {!! (Request::is('admin/contents') || Request::is('admin/contents/create') || Request::is('admin/contents/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="list-ul" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('contents/title.management') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li {!! (Request::is('admin/contents') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/contents') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('contents/title.pages') }}
                                    </a>
                                </li>
                                <li {!! (Request::is('admin/contents/create') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/contents/create') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('contents/title.create') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('slides'))
                        <li {!! (Request::is('admin/slides') || Request::is('admin/slides/create') || Request::is('admin/slides/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="image" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('slides/title.management') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li {!! (Request::is('admin/slides') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/slides') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('slides/title.slides') }}
                                    </a>
                                </li>
                                <li {!! (Request::is('admin/slides/create') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/slides/create') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('slides/title.create') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if (Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('socials'))
                        <li {!! (Request::is('admin/socials') || Request::is('admin/socials/create') || Request::is('admin/socials/*') ? 'class="active"' : '') !!}>
                            <a href="#">
                                <i class="livicon" data-name="share" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                                <span class="title">{{ trans('socials/title.management') }}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li {!! (Request::is('admin/socials') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/socials') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('socials/title.socials') }}
                                    </a>
                                </li>
                                <li {!! (Request::is('admin/socials/create') ? 'class="active" id="active"' : '') !!}>
                                    <a href="{{ URL::to('admin/socials/create') }}">
                                        <i class="fa fa-angle-double-right"></i>
                                        {{ trans('socials/title.create') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
            </section>
        </aside>
        <aside class="right-side">
            
            <!-- Notifications -->
            @include('notifications')
            
            <!-- Content -->
            @yield('content')

        </aside>
        <!-- right-side -->
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    @if (Request::is('admin/form_builder2') || Request::is('admin/gridmanager') || Request::is('admin/portlet_draggable') || Request::is('admin/calendar'))
        <script src="{{ asset('assets/vendors/form_builder1/js/jquery.ui.min.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!--livicons-->
    <script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}" type="text/javascript"></script>
   <script src="{{ asset('assets/js/josh.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/metisMenu.js') }}" type="text/javascript"> </script>
    <script src="{{ asset('assets/vendors/holder-master/holder.js') }}" type="text/javascript"></script>
    <script>
        {{-- csrf protection for ajax requests --}}
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("meta[name='_token']").attr("content")
            }
        });
        var LOCALE = "tr";
        var PUBLIC_REL = "{!! URL::to('/') !!}";
    </script>
    <!-- end of global js -->
    <!-- begin page level js -->
    @yield('footer_scripts')
    <!-- end page level js -->
</body>
</html>
