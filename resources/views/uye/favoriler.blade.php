@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.favorite-products')}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
@stop

{{-- slider --}}
@section('top')
    <!--Carousel Start -->
    <!-- //Carousel End -->
@stop

{{-- content --}}
@section('content')
    <section class="MainContent">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}}</a></li>
                <li><a href="{{{ url('/uye/profil') }}}">{{Lang::get('frontend/general.myaccount')}}</a></li>
                <li>{{Lang::get('frontend/general.favorite-products')}}</li>
            </ol>
        </div>
        <div class="MyFavorites">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('uye.menu')
                    </div>
                    <div class="col-md-9">
                        <div class="DefaultBox">
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.favorite-products')}}</div>
                            <div class="DefaultBoxBody">
                                <div class="HelpBox mb-15">
                                    <div class="HelpBoxIcon"><i class="fa fa-question-circle"></i></div>
                                    <div class="HelpBoxContent"><b>{{Lang::get('frontend/general.aboutthispage')}}</b><span>{{Lang::get('frontend/general.favouritehelptext')}}</span></div>
                                </div>
                            </div>
                        </div>
                        @if($favorites->count() > 0)
                        <div class="MyFavoritesList">
                            <div class="has-error">
                                @include('notifications')
                            </div>
                            <form name="favorites" method="post" action="">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="DefaultBoxBody CategoryListWrapper Table">
                                <div class="row">
                                    @foreach($favorites as $fav)
                                        @if($fav->product)
                                            <div class="col-md-4 ProductWrapper">
                                                <div class="Product">
                                                    <div class="ProductSelect text-center">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="favs[]" value="{{ $fav->id }}">
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="ProductMediaWrapper">
                                                        <a href="/urun/{{ $fav->product->sefurl }}">
                                                            <img src="{{ \App\Library\Common::getPrdImage($fav->product->id) }}">
                                                            {!! ($fav->product->new == 1 ? '<span class="New">' . Lang::get('frontend/general.new') . '</span>' : '') !!}
                                                        </a>
                                                    </div>
                                                    <div class="ProductCaption">
                                                        @if($fav->product->discount != '' && $fav->product->discount_price > 0)
                                                            <div class="row">
                                                                <div class="col-xs-6 text-right">
                                                                    <div class="Damping">{{Lang::get('frontend/general.discountpercent', array('percent'=>\App\Library\Common::getYuzde($fav->product->price,$fav->product->discount_price)))}}</div>
                                                                </div>
                                                                <div class="col-xs-6 text-left">
                                                                    <div class="price"><span class="line-through">{{ $fav->product->currency.$fav->product->price }}</span><span>{{ $fav->product->currency.$fav->product->discount_price }}</span></div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="price"><span>{{  $fav->product->currency.$fav->product->real_price }}</span></div>
                                                        @endif
                                                        <a href="/urun/{{ $fav->product->sefurl }}">{{ $fav->product->{'title_'.$defLocale} }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                                <div class="row">
                                <div class="col-md-3">
                                    <button type="submit" class="BtnDanger inline-block mt-20"><i class="fa fa-trash"></i><span>{{Lang::get('frontend/general.removeselected')}}</span></button>
                                </div>
                                <div class="col-md-9">
                                    <div class="CategoryListPagination text-right">
                                        <nav>
                                            {!! $favorites->render() !!}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <!--page level js ends-->
@stop
