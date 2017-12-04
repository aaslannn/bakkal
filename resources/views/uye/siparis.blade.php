@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{Lang::get('frontend/general.order-details')}}
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
                <li><a href="{{{ url('/uye/siparisler') }}}">{{Lang::get('frontend/general.my-orders')}}</a></li>
                <li>{{Lang::get('frontend/general.order-details')}}</li>
            </ol>
        </div>
        <div class="MyOrderDetail">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        @include('uye.menu')
                    </div>
                    <div class="col-md-9">
                        <div class="DefaultBox" id="PrintArea">
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.order-details')}}</div>
                            <div class="DefaultBoxBody">
                                <ul class="TableList">
                                    <li><span>{{Lang::get('frontend/general.orderno')}}:</span><span>{{{ $order->id  }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.refno')}}:</span><span>{{{ $order->refNo  }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.paymethod')}}:</span><span>{{{ $order->paymethod->{'title_'.$defLocale} }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.orderstatus')}}:</span><span>{{{ $order->orderstatus->{'title_'.$defLocale} }}}</span></li>
                                    @if($order->odemeTuru == 2)
                                        <li><span>{{Lang::get('frontend/general.bankaccountinfo')}}:</span>
                                        <span>
                                            <b>{{Lang::get('frontend/general.bankname')}}: </b><span>{{{ $order->orderbank->bankaAdi }}} </span>
                                            <b>{{Lang::get('frontend/general.branch')}}: </b><span>{{{ $order->orderbank->subeKodu }}} <span>{{{ $order->orderbank->subeAdi }}} </span><br>
                                            <b>{{Lang::get('frontend/general.accountowner')}}: </b><span>{{{ $order->orderbank->hesapAdi }}} </span>
                                            <b>{{Lang::get('frontend/general.accounttype')}}: </b><span>{{{ $order->orderbank->hesapTuru }}} </span>
                                            <b>{{Lang::get('frontend/general.accountno')}}: </b><span>{{{ $order->orderbank->hesapNo }}} </span><br>
                                            <b>{{Lang::get('frontend/general.ibanno')}}: </b><span>{{{ $order->orderbank->iban }}} </span>
                                        </span>
                                        </li>
                                    @endif
                                    <li><span>{{Lang::get('frontend/general.shippingfirm')}}:</span><span>{{{ $order->cargo->name }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.shippingtrackno')}}:</span><span>{{{ $order->kargoTakip  }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.orderdate')}}:</span><span>{{{ $order->created_at }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.ipaddress')}}:</span><span>{{{ $order->uyeIp }}}</span></li>
                                    @if($order->ind_kod != '')
                                        <li><span>{{Lang::get('frontend/general.promotioncode')}}:</span><span>{{{ $order->ind_kod }}}</span></li>
                                    @endif

                                </ul>
                            </div>
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.my-orders')}}</div>
                            <div class="DefaultBoxBody">
                                <table class="table table-bordered table-striped MyCartDetail">
                                    <thead>
                                    <tr>
                                        <th class="text-center">{{Lang::get('frontend/general.product-name')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.amount')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.stockcode')}}</th>
                                        <th class="text-center">{{Lang::get('frontend/general.price')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $araToplam = 0;
                                    $kdvTutar = 0;
                                    ?>
                                    @foreach($order->orderdetails as $detail)
                                        <tr>
                                            <td class="ProductTitle">
                                                @if($detail->product)
                                                <a href="{{ url('/urun/'.$detail->product->sefurl) }}">
                                                    <img src="{{ \App\Library\Common::getPrdImage($detail->product_id) }}">
                                                    <span>{{ $detail->product->{'title_'.$defLocale} }} {!! ($detail->option_id ? ' <span class="prdOpt">('.\App\Library\Common::getPropsAndOptions($detail->option_id).')</span>' : '') !!}</span>
                                                </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">x{{ $detail->adet }}</td>
                                            <td class="text-center">{{ $detail->product ? $detail->product->id : '-' }}</td>
                                            <td class="text-center">
                                                {{ $siteSettings->para_birim.number_format($detail->toplamFiyat,2) }}
                                                {!! ($detail->havale_ind_yuzde > 0 ? ' <br><i>(%'.$detail->havale_ind_yuzde .' '.Lang::get('frontend/general.havale-ind').')</i>' : '') !!}
                                            </td>
                                        </tr>
                                        <?php
                                        $araToplam += $detail->toplamFiyat;
                                        $kdvTutar += $detail->kdvTutar;
                                        ?>
                                    @endforeach
                                    <?php $kdvDahil = $araToplam + $kdvTutar; ?>
                                    <tr class="TotalPrice">
                                        <td colspan="2"></td>
                                        <td class="text-right"> <b>{{Lang::get('frontend/general.subtotal')}}:</b></td>
                                        <td class="text-right">{{ $siteSettings->para_birim.number_format($araToplam,2) }}</td>
                                    </tr>
                                    @if($kdvTutar > 0)
                                    <tr class="TotalPrice">
                                        <td colspan="2"></td>
                                        <td class="text-right"> <b>{{Lang::get('frontend/general.kdv')}}:</b></td>
                                        <td class="text-right">{{ $siteSettings->para_birim.number_format($kdvTutar,2) }}</td>
                                    </tr>
                                    <tr class="TotalPrice">
                                        <td colspan="2"></td>
                                        <td class="text-right"> <b>{{Lang::get('frontend/general.kdvincluded')}}:</b></td>
                                        <td class="text-right">{{ $siteSettings->para_birim.number_format($kdvDahil,2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="TotalPrice">
                                        <td colspan="2"></td>
                                        <td class="text-right"> <b>{{Lang::get('frontend/general.shipmentprice')}}:</b></td>
                                        <td class="text-right">{{ $siteSettings->para_birim.number_format($order->kargoTutar,2) }}</td>
                                    </tr>
                                    @if($order->ind_oran > 0)
                                        <tr class="TotalPrice">
                                            <td colspan="2"></td>
                                            <td class="text-right"> <b>{{Lang::get('frontend/general.promodiscount')}}:</b></td>
                                            <td class="text-right">% {{ $order->ind_oran }}</td>
                                        </tr>
                                    @endif
                                    <tr class="TotalPrice">
                                        <td colspan="2"></td>
                                        <td class="text-right"> <b>{{Lang::get('frontend/general.grandtotal')}}</b></td>
                                        <td class="text-right">{{ $siteSettings->para_birim.number_format($order->topTutar,2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.deliveryinfo')}}</div>
                            <div class="DefaultBoxBody">
                                <ul class="TableList">
                                    <li><span>{{Lang::get('frontend/general.namesurname')}}:</span><span>{{{ $order->alici_adi }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.email')}}:</span><span>{{{ $order->alici_email }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.address')}}:</span><span><span>{{{ $order->address }}} {{{ $order->state }}}  {{{ $order->city_id }}} / {{{ $order->country->ulke }}}</span></span></li>
                                    <li><span>{{Lang::get('frontend/general.tel')}}:</span><span>{{{ $order->tel }}}</span></li>
                                    <li><span>{{Lang::get('frontend/general.giftwrap')}}:</span><span>{{{ \App\Sabit::yesNo($order->hediye)  }}}</span></li>
                                </ul>
                            </div>
                            <div class="DefaultBoxHeading">{{Lang::get('frontend/general.billinginfo')}}</div>
                            <div class="DefaultBoxBody">
                                <ul class="TableList">
                                    <li><span>{{Lang::get('frontend/general.billtype')}}:</span><span>{{{ \App\Sabit::faturaType($order->ftype,LaravelLocalization::getCurrentLocale()) }}}</span></li>
                                    @if($order->faturaAyni == 1)
                                        <li><span>{{Lang::get('frontend/general.nameonbill')}}:</span><span>{{{ $order->alici_adi }}}</span></li>
                                        <li><span>{{Lang::get('frontend/general.address')}}:</span><span><span>{{{ $order->address.' '.$order->town.' '.$order->city_id.' '.$order->state }}} / {{{ $order->country->ulke }}}</span></span></li>
                                        <li><span>{{Lang::get('frontend/general.tel')}}:</span><span>{{{ $order->tel }}}</span></li>
                                        <li><span>{{Lang::get('frontend/general.tcidno')}}:</span><span>{{{ $order->tckimlik }}}</span></li>
                                    @else
                                        <li><span>{{Lang::get('frontend/general.nameonbill')}}:</span><span>{{{ $order->fisim }}}</span></li>
                                        <li><span>{{Lang::get('frontend/general.address')}}:</span><span><span>{{{ $order->faddress.' '.$order->ftown.' '.$order->fcity_id.' '.$order->fstate }}} / {{{ $order->fcountry->ulke }}}</span></span></li>
                                        <li><span>{{Lang::get('frontend/general.tel')}}:</span><span>{{{ $order->tel }}}</span></li>
                                        @if($order->ftype == 1)
                                            <li><span>{{Lang::get('frontend/general.tcidno')}}:</span><span>{{{ $order->ftckimlik }}}</span></li>
                                        @else
                                            <li><span>{{Lang::get('frontend/general.taxadministration')}}:</span><span>{{{ $order->vergid }}}</span></li>
                                            <li><span>{{Lang::get('frontend/general.taxno')}}:</span><span>{{{ $order->vergino }}}</span></li>
                                        @endif
                                    @endif
                                </ul>
                                <a class="BtnWarning BtnPrint inline-block mt-15"><i class="fa fa-print"></i><span>{{Lang::get('frontend/general.print')}}</span></a>
                                @if ($order->status != 3 && $order->status != 4 && $order->status != 5 && $order->status != 9)
                                    &nbsp;
                                    <a class="BtnDanger inline-block mt-15" href="{{ route('confirm-delete/siparis', $order->id) }}" data-toggle="modal" data-target="#delete_confirm"><i class="fa fa-print"></i><span>{{Lang::get('frontend/general.cancelorder')}}</span></a>
                                @endif
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
    <script src="{{ asset('assets/js/frontend/events/printevents.js') }}" type="text/javascript"></script>
    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="customer_delete_confirm_title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>$(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});</script>
    <div class="AjaxLoader hide">
        <div class="LoaderBox">
            <div class="fa fa-spinner fa-spin"></div><span>Suspendisse ac imperdiet nunc.</span>
            <div class="LoaderFooter text-right"><a class="ColorRed">{{Lang::get('frontend/general.cancel')}}</a><a>{{Lang::get('frontend/general.ok')}}</a></div>
        </div>
    </div>
    <!--page level js ends-->
@stop
