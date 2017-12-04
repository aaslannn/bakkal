@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ $cat->title_tr }}
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
                <?php echo \App\Library\Common::getCatBreadcrumb($cat->id,1,LaravelLocalization::getCurrentLocale()); ?>
            </ol>
        </div>
        <div class="CategoryList">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="CategoryFilter">
                            <div class="DefaultBox">
                                <div class="DefaultBoxHeading">
                                    {{ $cat->{'title_'.$defLocale} }}<span class="Summary block">{{Lang::get('frontend/general.productfoundcount', array('count'=>$products->count()))}}</span>
                                </div>
                                <div class="DefaultBoxBody Selected">
                                    <div class="SelectedCategories mb-5">
                                        <ul>
                                            <?php echo \App\Library\Common::getCatBreadcrumb($cat->id,1,LaravelLocalization::getCurrentLocale()); ?>
                                        </ul>
                                    </div>
                                    @if($cat->subcats->count() > 0)
                                        <div class="SubCategories"><b class="mb-10 block">{{Lang::get('categories/table.altcat')}}</b>
                                            <ul>
                                                @foreach($cat->subcats as $subcat)
                                                    <li><a href="/urunler/{{ $subcat->sefurl }}"><i class="fa fa-chevron-right mr-10"></i>{{ $subcat->{'title_'.$defLocale} }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if ($products->count() > 0)
                            <div class="DefaultBox">
                                <div class="DefaultBoxHeading">
                                    {{Lang::get('frontend/general.applyfilter')}}
                                </div>
                                <form name="prFilter" method="get" action="">
                                <div class="DefaultBoxBody">
                                    <?php $brands = Input::has('brands') ? Input::get('brands') : []; ?>
                                    @if($siteSettings->getBrand == 1)
                                        @if ($markalar->count() > 0)
                                        <b class="block mb-10">{{Lang::get('brands/title.brands')}}
                                            <div class="Brands">
                                                @foreach($markalar as $val)
                                                    @if(count($val->product_brand))
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="brands[]" value="{{ $val->brand_id }}" {{ in_array($val->brand_id,$brands) ? 'checked' : '' }}>{{ $val->product_brand->name }}
                                                        </label>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </b>
                                        @endif
                                    @endif
                                    <div class="DefaultBoxBody"><b class="block mb-10">{{Lang::get('frontend/general.filteroptions')}}</b>
                                        <?php
                                        $discount = Input::has('discount') ? Input::get('discount') : 0;
                                        $new = Input::has('new') ? Input::get('new') : 0;
                                        $stock = Input::has('stock') ? Input::get('stock') : 0;
                                        $min_price = Input::has('min_price') ? Input::get('min_price') : null;
                                        $max_price = Input::has('max_price') ? Input::get('max_price') : null;
                                        ?>
                                        <div class="AdditionalFilters">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="discount" value="1" {{ $discount == 1 ? 'checked' : '' }}>{{Lang::get('frontend/general.discounted-products')}}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="new" value="1" {{ $new == 1 ? 'checked' : '' }}>{{Lang::get('frontend/general.new-products')}}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="stock" value="1" {{ $stock == 1 ? 'checked' : '' }}>{{Lang::get('frontend/general.stock-products')}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="DefaultBoxBody"><b class="block mb-10">{{Lang::get('frontend/general.pricerange')}}</b>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Min" class="form-control PriceFormat" name="min_price" value="{{ $min_price ?  $min_price : '' }}" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <input type="text" placeholder="Max" class="form-control PriceFormat" name="max_price" value="{{ $max_price ?  $max_price : '' }}" maxlength="10">
                                                </div>
                                            </div>
                                            <div class="col-md-2"><span class="mt-5 block">{{ \App\Sabit::paraBirimi($siteSettings->para_birim) }}</span></div>
                                        </div>
                                    </div>
                                    <div class="DefaultBoxBody text-center">
                                        <button type="submit" class="BtnWarning inline-block"><i class="fa fa-search"></i><span>{{Lang::get('frontend/general.applyfilter')}}</span></button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9">
                        @if($cat->image != '')
                        <div class="CategoryHeroMedia"><img src="{{ url('/').'/uploads/categories/'.$cat->image }}"></div>
                        @endif
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
                                    <form name="prStyleFilter">
                                        <meta name="csrf_token" content="{{ csrf_token() }}">
                                        {{ csrf_field() }}
                                        <div class="SwicthView"><span>{{Lang::get('frontend/general.appearance')}}:</span>
                                        <a data-name="Thumbnail" {{ $catStyle == 'Thumbnail' ? 'class=Selected' : '' }}><i class="fa fa-th-large"></i></a>
                                        <a data-name="Table" {{ $catStyle == 'Table' ? 'class=Selected' : '' }}><i class="fa fa-bars"></i></a></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="DefaultBoxBody CategoryListWrapper {{ $catStyle }}">
                            <div class="row">
                                @foreach($products as $prd)
                                    {{ $prd->minPrice  }}
                                    <div class="col-md-4 ProductWrapper" data-price="{{ $prd->real_price }}" data-new="{{ $prd->new }}" >
                                        <div class="Product">
                                            <div class="ProductMediaWrapper">
                                                <a href="/urun/{{ $prd->sefurl }}">
                                                    <img src="{{ \App\Library\Common::getPrdImage($prd->id) }}">
                                                    {!! ($prd->new == 1 ? '<span class="New">' . Lang::get('frontend/general.new') . '</span>' : '') !!}
                                                </a>
                                            </div>
                                            <div class="ProductCaption">
                                                @if($prd->discount != '' && $prd->discount_price > 0)
                                                    <div class="row">
                                                        <div class="col-xs-6 text-right">
                                                            <div class="Damping">{{Lang::get('frontend/general.discountpercent', array('percent'=>\App\Library\Common::getYuzde($prd->price,$prd->discount_price)))}}</div>
                                                        </div>
                                                        <div class="col-xs-6 text-left">
                                                            <div class="price"><span class="line-through">{{ $prd->currency.number_format($prd->price,2) }}</span><span>{{ $prd->currency.number_format($prd->discount_price,2) }}</span></div>
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
                                {!! $products->appends(['orderBy' => $orderBy, 'discount' => $discount, 'new' => $new, 'stock' => $stock, 'min_price' => $min_price, 'max_price' => $max_price, 'brands' => $brands ])->render() !!}
                            </div>
                        </div>
                        @else
                            <div class="DefaultBoxBody CategoryListWrapper {{ $catStyle }}">
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
    <script src="{{ asset('assets/js/frontend/services/categoryfilterservices.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/helpers/productlisttemphelper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/controllers/categoryfiltercontroller.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/models/productlistfiltermodel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/plugins/jquery.price_format.2.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/categorylistevents.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/frontend/events/categoryfilterevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
