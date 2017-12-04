@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.home')}}
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
    <?php Session::forget('redirect'); ?>
    <section class="MainContent">
        <div class="HomePage">
            <div class="container">
                @if($slides->count() > 0)
                <div class="row">
                    <div class="col-md-9">
                        <div id="HeroCarousel" data-interval="7000" data-pause="hover" class="carousel slide">
                            <ol class="carousel-indicators">
                                @for($i=0; $i < $slides->count(); $i++)
                                    <li data-slide-to="{{ $i }}" data-target="#HeroCarousel"  {!! ($i == 0 ? 'class="active"' : '') !!}></li>
                                @endfor
                            </ol>
                            <div class="carousel-inner">
                                <?php $i = 0; ?>
                                @foreach ($slides as $slide)
                                    <div class="item {!! ($i == 0 ? 'active' : '') !!}">
                                            @if($slide->link != '')
                                                <a href="{{ $slide->link }}"><img src="{{ url('/').'/uploads/slides/'.$slide->image }}"></a>
                                            @else
                                                <img src="{{ url('/').'/uploads/slides/'.$slide->image }}">
                                            @endif
                                        <div class="carousel-caption">{{ $slide->{'title_'.$defLocale} }}</div>
                                    </div>
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                            <div class="carousel-controls"><a data-target="#HeroCarousel" data-slide="prev" class="left carousel-control"><i class="fa fa-chevron-left"></i></a><a data-target="#HeroCarousel" data-slide="next" class="right carousel-control"><i class="fa fa-chevron-right"></i></a></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div id="BestSelling" data-interval="4000" data-pause="hover" class="carousel slide">
                            <div class="carousel-heading"><b>{{Lang::get('frontend/general.trending-products')}}</b><a data-target="#BestSelling" data-slide="prev" class="left carousel-control"><i class="fa fa-chevron-left"></i></a><a data-target="#BestSelling" data-slide="next" class="right carousel-control"><i class="fa fa-chevron-right"></i></a></div>
                            <div class="carousel-inner">
                                <?php $i = 0; ?>
                                @foreach ($chosens as $chosen)
                                    <div class="item {!! ($i == 0 ? 'active' : '') !!}">
                                        <div class="Product">
                                            <a href="/urun/{{ $chosen->sefurl }}">
                                                <img src="{{ \App\Library\Common::getPrdImage($chosen->id) }}">
                                                {!! ($chosen->new == 1 ? '<span class="New">'.Lang::get('frontend/general.new').'</span>' : '') !!}
                                            </a>
                                            <div class="carousel-caption">
                                                @if($chosen->discount != '' && $chosen->discount_price > 0)
                                                    <div class="row">
                                                        <div class="col-xs-6 text-right">
                                                            <div class="Damping">{{ \App\Library\Common::getYuzde($chosen->price,$chosen->discount_price) }} {{Lang::get('frontend/general.discount')}}</div>
                                                        </div>
                                                        <div class="col-xs-6 text-left">
                                                            <div class="price">
                                                                <span class="line-through">{{ $chosen->currency.number_format($chosen->price,2) }}</span>
                                                                <span>{{ $chosen->currency.number_format($chosen->discount_price,2) }}</span></div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="price"><span>{{ $chosen->currency.number_format($chosen->real_price,2) }}</span></div>
                                                @endif
                                                <a href="/urun/{{ $chosen->sefurl }}">{{ $chosen->{'title_'.$defLocale} }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                            <div class="carousel-footer">
                                <ol class="carousel-indicators">
                                    @for($i=0; $i < $chosens->count(); $i++)
                                        <li data-slide-to="{{ $i }}" data-target="#BestSelling"  {!! ($i == 0 ? 'class="active"' : '') !!}></li>
                                    @endfor
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($dProducts->count() > 0)
                <div class="mt-10">
                    <div id="DiscountProduct" class="HorizontalSlider">
                        <div class="carousel-heading"><b>{{Lang::get('frontend/general.discounted-products')}}</b></div>
                        <div class="HorizontalSliderWrapper">
                            @foreach ($dProducts as $dPrd)
                                <div class="SliderItem">
                                    <div class="Product">
                                        <a href="/urun/{{ $dPrd->sefurl }}">
                                            <img src="{{ \App\Library\Common::getPrdImage($dPrd->id) }}">
                                            {!! ($dPrd->new == 1 ? '<span class="New">'.Lang::get('frontend/general.new').'</span>' : '') !!}
                                        </a>
                                        <div class="ItemCaption">
                                            @if($dPrd->discount != '' && $dPrd->discount_price > 0)
                                                <div class="row">
                                                    <div class="col-xs-6 text-right">
                                                        <div class="Damping">{{ \App\Library\Common::getYuzde($dPrd->price,$dPrd->discount_price) }} {{Lang::get('frontend/general.discount')}}</div>
                                                    </div>
                                                    <div class="col-xs-6 text-left">
                                                        <div class="price">
                                                            <span class="line-through">{{ $dPrd->currency.number_format($dPrd->price,2) }} </span>
                                                            <span>{{ $dPrd->currency.number_format($dPrd->discount_price,2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price"><span>{{ $dPrd->currency.number_format($dPrd->real_price,2) }}</span></div>
                                            @endif
                                            <a href="/urun/{{ $dPrd->sefurl }}">{{ $dPrd->{'title_'.$defLocale} }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="SliderControls"><a href="#" class="prev"><i class="fa fa-chevron-left"></i></a><a href="#" class="next"><i class="fa fa-chevron-right"></i></a></div>
                    </div>
                </div>
                    @endif
                <div class="mt-10">
                    <div class="DefaultBox">
                        <div class="DefaultBoxHeading text-center">{{Lang::get('frontend/general.featured-products')}}</div>
                        <div class="DefaultBoxBody">
                            <div class="row">
                                <?php $i = 0; ?>
                                @foreach ($vProducts as $vitrin)
                                <div class="col-md-3 ProductWrapper {!! ($i > 3 ? 'noborder' : '') !!}">
                                    <div class="Product">
                                        <div class="ProductMediaWrapper">
                                            <a href="/urun/{{ $vitrin->sefurl }}">
                                                <img src="{{ \App\Library\Common::getPrdImage($vitrin->id) }}">
                                                {!! ($vitrin->new == 1 ? '<span class="New">'.Lang::get('frontend/general.new').'</span>' : '') !!}
                                            </a>
                                        </div>
                                        <div class="ProductCaption">
                                            @if($vitrin->discount != '' && $vitrin->discount_price > 0)
                                                <div class="row">
                                                    <div class="col-xs-6 text-right">
                                                        <div class="Damping">{{ \App\Library\Common::getYuzde($vitrin->price,$vitrin->discount_price) }} {{Lang::get('frontend/general.discount')}}</div>
                                                    </div>
                                                    <div class="col-xs-6 text-left">
                                                        <div class="price">
                                                            <span class="line-through">{{ $vitrin->currency.number_format($vitrin->price,2) }}</span>
                                                            <span>{{ $vitrin->currency.number_format($vitrin->discount_price,2) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="price"><span>{{ $vitrin->currency.number_format($vitrin->real_price,2) }}</span></div>
                                            @endif
                                                <a href="/urun/{{ $vitrin->sefurl }}">{{ $vitrin->{'title_'.$defLocale} }}</a>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                                @endforeach
                            </div>
                        </div>
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
