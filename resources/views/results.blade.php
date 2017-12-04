@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.searchresults')}} : {{ $q }}
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
    <?php
    $myUrl = '/results?q='.$q;
    if(isset($cat))
        $myUrl .= '&catId='.$cat->id;
    ?>
    <section class="MainContent">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{{ url('/') }}}">{{Lang::get('frontend/general.home')}}</a></li>
                <li>{{Lang::get('frontend/general.searchresults')}}</li>
            </ol>
        </div>
        <div class="CategoryList">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="CategoryFilter">
                            <div class="DefaultBox">
                                <div class="DefaultBoxHeading">

                                    {{Lang::get('frontend/general.word')}} : {{ $q }}<span class="Summary block">{{Lang::get('frontend/general.productfoundcount', array('count'=>$products->count()))}}</span>
                                </div>
                                <div class="DefaultBoxBody Selected">
                                    @if (isset($cat))
                                        @if($cat->subcats->count() > 0)
                                            <div class="SubCategories"><b class="mb-10 block">{{Lang::get('frontend/general.subcats')}}</b>
                                                <ul>
                                                    @foreach($cat->subcats as $subcat)
                                                        <li><a href="/urunler/{{ $subcat->sefurl }}"><i class="fa fa-chevron-right mr-10"></i>{{ $subcat->{'title_'.$defLocale} }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @else
                                        <?php $categories = \App\Library\Common::getCategoriesbyParent(); ?>
                                        <div class="SubCategories"><b class="mb-10 block">{{Lang::get('frontend/general.categories')}}</b>
                                            <ul>
                                                @foreach($categories as $subcat)
                                                    <li><a href="/urunler/{{ $subcat->sefurl }}"><i class="fa fa-chevron-right mr-10"></i>{{ $subcat->{'title_'.$defLocale} }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        @if ($products->count() > 0)
                            <div class="CategoryListHeading">
                                <div class="row">
                                    <div class="col-md-9"><span>{{Lang::get('frontend/general.sort')}}:</span>
                                        <div class="btn-group">
                                            <a class="btn {!! ($orderBy == 'new' ? ' Selected' : '') !!}" href="{{ url($myUrl.'&orderBy=new') }}">{{Lang::get('frontend/general.newest')}}</a>
                                            <a class="btn {!! ($orderBy == 'chosen' ? ' Selected' : '') !!}" href="{{ url($myUrl.'&orderBy=chosen') }}">{{Lang::get('frontend/general.trending-products')}}</a>
                                            <a class="btn {!! ($orderBy == 'minPrice' ? ' Selected' : '') !!}" href="{{ url($myUrl.'&orderBy=minPrice') }}">{{Lang::get('frontend/general.lowestprice')}}</a>
                                            <a class="btn {!! ($orderBy == 'maxPrice' ? ' Selected' : '') !!}" href="{{ url($myUrl.'&orderBy=maxPrice') }}">{{Lang::get('frontend/general.highestprice')}}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="SwicthView"><span>{{Lang::get('frontend/general.appearance')}}:</span><a data-name="Thumbnail" class="Selected"><i class="fa fa-th-large"></i></a><a data-name="Table"><i class="fa fa-bars"></i></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="DefaultBoxBody CategoryListWrapper Thumbnail">
                                <div class="row">
                                    @foreach($products as $prd)
                                        <div class="col-md-4 ProductWrapper" data-price="{{ $prd->real_price }}" data-new="{{ $prd->new }}" >
                                            <div class="Product">
                                                <div class="ProductMediaWrapper">
                                                    <a href="/urun/{{ $prd->sefurl }}">
                                                        <img src="{{ \App\Library\Common::getPrdImage($prd->id) }}">
                                                        {!! ($prd->new == 1 ? '<span class="New">'.Lang::get('frontend/general.new').'</span>' : '') !!}
                                                    </a>
                                                </div>
                                                <div class="ProductCaption">
                                                    @if($prd->discount != '' && $prd->discount_price > 0)
                                                        <div class="row">
                                                            <div class="col-xs-6 text-right">
                                                                <div class="Damping">{{Lang::get('frontend/general.discountpercent', array('percent'=>\App\Library\Common::getYuzde($prd->price,$prd->discount_price)))}}</div>
                                                            </div>
                                                            <div class="col-xs-6 text-left">
                                                                <div class="price">
                                                                    <span class="line-through">{{ $prd->currency.number_format($prd->price,2) }}</span>
                                                                    <span>{{ $prd->currency.number_format($prd->discount_price,2) }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="price"><span>{{ $prd->currency.number_format($prd->real_price,2) }}</span></div>
                                                    @endif
                                                    <a href="/urun/{{ $prd->sefurl }}">{{ $prd->{'title_'.$defLocale} }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="CategoryListPagination text-center">
                                    {!! $products->render() !!}
                                </div>
                            </div>
                        @else
                            <div class="DefaultBoxBody CategoryListWrapper Thumbnail">
                                <div class="row">{{Lang::get('frontend/general.noresultfound')}}</div>
                            </div>
                        @endif

                </div>
            </div>
        </div>
    </section>
    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="{{ asset('assets/js/frontend/events/categorymenuevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/categorylistevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
