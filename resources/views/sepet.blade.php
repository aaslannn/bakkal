@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.my-cart')}}
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
                <li>{{Lang::get('frontend/general.cart')}}</li>
            </ol>
        </div>
        <div class="MyCart">
            <div class="container">
                <div class="DefaultBox">
                    <div class="DefaultBoxHeading">{{Lang::get('frontend/general.my-cart')}}</div>
                    @if( Cart::count() == 0)
                        <div class="DefaultBoxBody center">{{Lang::get('frontend/general.noproductincart')}}</div>
                    @else
                    <form name="cartOrder" class="cartOrder" id="cartOrder" action="#" method="post">
                        <meta name="csrf_token" content="{{ csrf_token() }}">
                        {{ csrf_field() }}
                        <div class="DefaultBoxBody">
                            @include('notifications')
                            <table class="table table-bordered CartList">
                                <thead>
                                <tr>
                                    <th>{{Lang::get('frontend/general.product')}}</th>
                                    <th>{{Lang::get('frontend/general.count')}}</th>
                                    <th>{{Lang::get('frontend/general.priceperitem')}}</th>
                                    <th>{{Lang::get('frontend/general.kdv')}}</th>
                                    <th>{{Lang::get('frontend/general.total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $cart = Cart::Content();
                                $kdv = 0;
                                foreach($cart as $row)
                                {
                                    $prd = \App\Product::whereStatus(1)->whereId($row->id)->first();
                                    if ($prd->kdv > 0)
                                    {
                                        $prdKdv = \App\Library\Common::getKDV($prd->real_price,$prd->kdv) * $row->qty;
                                        $kdv += $prdKdv;
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <a href="{{ url('/urun/'.$prd->sefurl) }}">
                                                <img src="{{ \App\Library\Common::getPrdImage($prd->id) }}">
                                                <span>
                                                    {{ $prd->{'title_'.$defLocale} }}
                                                    {!! ($row->options->has('opt') ? ' ('.\App\Library\Common::getPropsAndOptions($row->options->get('opt')).')' : '') !!}
                                                </span>
                                            </a>
                                        </td>
                                        <td><span>
                                                <input type="text" class="form-control PrdQuantity {{ \App\Library\Common::IsStockDinamic() == 1 ? 'QuantityLimit' : '' }}" name="qty_{{ $row->rowid }}" id="qty_{{ $row->rowid }}" data-id="{{ $row->rowid }}" data-pid="{{ $row->id }}" value="{{ $row->qty }}" {{ \App\Library\Common::IsStockDinamic() == 0 ? 'maxlength=2' : '' }}>
                                            </span>
                                        </td>
                                        <td><span>{{ $prd->currency.number_format($row->price,2) }}</span></td>
                                        <td><span>
                                                {!! ($prd->kdv > 0 ? '%'.$prd->kdv : Lang::get('frontend/general.kdvincluded')) !!}
                                            </span></td>
                                        <td><span>{{ $prd->currency.number_format($row->subtotal,2) }}</span><a id="delCart" data-id="{{ $row->rowid }}" data-url="{{{ url('/delCart') }}}"><i class="fa fa-trash ml-30"></i></a></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                @if($kdv > 0)
                                    <tr class="Summary">
                                        <td colspan="3" rowspan="3" class="noborder"></td>
                                        <td class="text-right"><b>{{Lang::get('frontend/general.subtotal')}}</b></td>
                                        <td>{{ $siteSettings->para_birim.number_format(Cart::total(),2) }}</td>
                                    </tr>
                                    <tr class="Summary">
                                        <td class="text-right"><b>{{Lang::get('frontend/general.kdv')}}</b></td>
                                        <td>{{ $siteSettings->para_birim.number_format($kdv,2) }}</td>
                                    </tr>
                                    <tr class="Summary">
                                        <td class="text-right"><b>{{Lang::get('frontend/general.total')}}</b></td>
                                        <td>{{ $siteSettings->para_birim.number_format(Cart::total()+$kdv,2) }}</td>
                                    </tr>
                                @else
                                    <tr class="Summary">
                                        <td colspan="3" rowspan="3" class="noborder"></td>
                                        <td class="text-right"><b>{{Lang::get('frontend/general.total')}}</b></td>
                                        <td>{{ $siteSettings->para_birim.number_format(Cart::total(),2) }}</td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="DefaultBoxFooter text-center">
                            <a class="BtnWarning inline-block mr-15" href="{{{ url('/') }}}"><i class="fa fa-chevron-right"></i><span>{{Lang::get('frontend/general.continueshopping')}}</span></a>
                            <button type="submit" class="BtnWarning inline-block mr-15" id="updateCart"><i class="fa fa-refresh"></i><span>{{Lang::get('frontend/general.updatecart')}}</span></button>
                            <a class="BtnSuccess inline-block" href="{{{ url('/siparis/teslimat') }}}"><i class="fa fa-shopping-cart"></i><span>{{Lang::get('frontend/general.finishshopping')}}</span></a>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
        <script src="{{ asset('assets/js/frontend/plugins/jquery.price_format.2.0.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/frontend/events/cartevents.js') }}" type="text/javascript"></script>
        <script>
            $(".PrdQuantity").priceFormat({
                prefix:"",
                centsLimit: 0,
                thousandsSeparator:""
            });
        </script>
    <!--page level js ends-->
@stop
