@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.orderapprove')}} - {{ $sip->id  }}
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
                <li><a href="{{{ url('/sepet') }}}">{{Lang::get('frontend/general.cart')}}</a></li>
                <li>{{Lang::get('frontend/general.order')}}</li>
            </ol>
        </div>
        <div class="CargoPackageDetail">
            @if($sip->odemeTuru == 1)
                <div class="Wizard">
                    <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                    <div class="Success"><i class="fa fa-money"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                    <div class="lastitem Success"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
                    <div class="OrderConfirmation">
                        <div class="Warning">
                            <b> {{Lang::get('frontend/general.cashpayondoorreceived')}}</b>
                            <span><b>{{Lang::get('frontend/general.yourorderno')}}</b></span><span class="mb-30">{{ $sip->id }}</span>
                            <span><b>{{Lang::get('frontend/general.amountondoor')}}</b></span><span>{{ $siteSettings->para_birim.number_format($sip->topTutar,2)  }}</span>
                            <div>{!!Lang::get('general.followyourorder', array('url'=>url('/uye/siparisler')))!!}</div>
                        </div>
                    </div>
                </div>
            @elseif($sip->odemeTuru == 2)
                <div class="Wizard">
                    <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                    <div class="Success"><i class="fa fa-money"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                    <div class="lastitem Warning"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
                    <div class="OrderConfirmation">
                        <div class="Warning">
                            <b> {{Lang::get('frontend/general.eftexpected')}}</b>
                            <span><b>{{Lang::get('frontend/general.transferrefno')}}</b></span><span class="mb-30">{{ $sip->id }}</span>
                            <span><b>{{Lang::get('frontend/general.amounttopay')}}</b></span><span>{{ $siteSettings->para_birim.number_format($sip->topTutar,2) }}</span>
                            <div>{{Lang::get('frontend/general.dontforgetrefno')}}<br>{!!Lang::get('general.followyourorder', array('url'=>url('/uye/siparisler')))!!}</div>
                        </div>
                    </div>
                </div>
            @elseif($sip->odemeTuru == 3)
                @if($sip->status == 7 || $sip->status == 10)
                    <div class="Wizard">
                        <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                        <div class="Success"><i class="fa fa-money"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                        <div class="lastitem Danger"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
                        <div class="OrderConfirmation">
                            <div class="Danger">
								
								@if(Session::has('error'))
								<h4>{!!Session::get('error')!!}</h4>
								@endif
                                <b> {{Lang::get('frontend/general.paymentfail')}}</b>
                                <span> <b>{{Lang::get('frontend/general.paymenttryagain')}}</b></span>
                                <div> <a class="BtnWarning inline-block" href="{{{ url('/siparis/'.$sip->id.'/odeme') }}}"><i class="fa fa-arrow-left"></i><span>{{Lang::get('frontend/general.gotopaymentpage')}}</span></a></div>
                            </div>
                        </div>
                    </div>
                @elseif($sip->status == 1)
                    <div class="Wizard">
                        <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                        <div class="Success"><i class="fa fa-money"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                        <div class="lastitem Success"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
                        <div class="OrderConfirmation">
                            <div class="Success">
                                <b> {{Lang::get('frontend/general.yourorderapproved')}}</b>
                                <span><b>{{Lang::get('frontend/general.yourorderno')}}</b></span><span class="mb-30">{{ $sip->id }}</span>
                                <span> <b>{{Lang::get('frontend/general.amountpaidcard')}}</b></span><span>{{ $siteSettings->para_birim.number_format($sip->topTutar,2) }}</span>
                                <div>{!!Lang::get('frontend/general.followyourorder', array('url'=>url('/uye/siparisler')))!!}</div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="Wizard">
                    <div class="Success"><i class="fa fa-truck"></i><span>{{Lang::get('frontend/general.deliveryinfo')}}</span></div>
                    <div class="Success"><i class="fa fa-money"></i><span>{{Lang::get('frontend/general.paymentinfo')}}</span></div>
                    <div class="lastitem Danger"><i class="fa fa-check"></i><span>{{Lang::get('frontend/general.orderapprove')}}</span></div>
                    <div class="OrderConfirmation">
                        <div class="Danger">
                            <b> {{Lang::get('frontend/general.anerroroccurred')}}</b><span> <b>{{Lang::get('frontend/general.checkyourorder')}}</b></span>
                            <div>{!!Lang::get('general.followyourorder', array('url'=>url('/uye/siparisler')))!!}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    <!-- //Container End -->
@stop

{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
        <script src="{{ asset('assets/js/frontend/events/cargopackageevents.js') }}" type="text/javascript"></script>
    <!--page level js ends-->
@stop
