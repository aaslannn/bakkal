@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.my-orders')}}
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
                <li>{{Lang::get('frontend/general.my-orders')}}</li>
            </ol>
        </div>
        <div class="MyOrders">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('uye.menu')
                    </div>
                    <div class="col-md-9">
                        <div class="DefaultBox">
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.my-orders')}}</div>
                            <div class="DefaultBoxBody">
                                <div class="HelpBox mb-15">
                                    <div class="HelpBoxIcon"><i class="fa fa-question-circle"></i></div>
                                    <div class="HelpBoxContent"><b>{{Lang::get('frontend/general.aboutthispage')}}</b><span>{{Lang::get('frontend/general.ordershelptext')}}</span></div>
                                </div>
                                <div class="has-error">
                                    @include('notifications')
                                </div>
                                @if($orders->count() > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">{{Lang::get('frontend/general.totalprice')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.paymethod')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.shipping')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.orderstatus')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.orderdate')}}</th>
                                        <th class="text-center">{{Lang::get('orders/table.actions')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $ord)
                                        <tr>
                                            <td>{{ $ord->id }}</td>
                                            <td class="text-center">{{{ $siteSettings->para_birim.number_format($ord->topTutar,2) }}}</td>
                                            <td class="text-center">{{{ $ord->paymethod->{'title_'.$defLocale} }}}</td>
                                            <td class="text-center">
                                                {{{ $ord->cargo->name }}}
                                                @if($ord->kargoTakip != '')
                                                    <b class="block">{{Lang::get('frontend/general.shippingtrackno')}}:</b><b class="block">{{ $ord->kargoTakip }}</b>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{{ $ord->orderstatus->{'title_'.$defLocale} }}}
                                                @if($ord->status == 7 && $ord->odemeTuru == 3)
                                                   <br><a href="{{{ url('/siparis/'.$ord->id.'/odeme') }}}">{{Lang::get('frontend/general.pay')}}</a>
                                                @endif
                                            </td>
                                            <td class="text-center"><span class="block">{{{ $ord->created_at }}}</span></td>
                                            <td class="text-center">
                                                <a href="{{ route('siparisler.show', $ord->id) }}"><i class="fa fa-pencil-square"></i>{{Lang::get('frontend/general.order-details')}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                        <div class="CategoryListPagination text-center">
                            <nav>
                                {!! $orders->render() !!}
                            </nav>
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
